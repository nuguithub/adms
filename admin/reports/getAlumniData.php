<?php
include "../../connectDB.php";
require '../vendor/autoload.php'; // Include PhpSpreadsheet autoload file

$department = $_POST['department'];
$course = $_POST['course'];
$batch = $_POST['batch'];
$company = $_POST['company'];

$sql = "SELECT 
        CONCAT(alumni.fname, ' ', alumni.lname) AS name,
        COALESCE(w.position, 'No info') AS position,
        COALESCE(w.company, 'No info') AS company,
        COALESCE(w.workStart, 'No info') AS workStart,
        COALESCE(w.empStat, 'No info') AS empStat,
        alumni_program.batch,
        alumni_program.coll_course,
        alumni.contact_no,
        alumni.email
        FROM  
            alumni_program 
        INNER JOIN  
            alumni ON alumni_program.alumni_id = alumni.alumni_id 
        LEFT JOIN ( 
            SELECT 
                user_id,
                MAX(CASE WHEN workEnd = 'Present' THEN position END) AS position,
                MAX(CASE WHEN workEnd = 'Present' THEN company END) AS company,
                MAX(CASE WHEN workEnd = 'Present' THEN workStart END) AS workStart,
                MAX(CASE WHEN workEnd = 'Present' THEN empStat END) AS empStat
            FROM 
                workHistory
            WHERE 
                work_id IS NOT NULL
            GROUP BY 
                user_id
        ) AS w ON alumni.user_id = w.user_id
        WHERE alumni.archive IS NULL";  

$params = array();

if (!empty($department)) {
    $sql .= " AND alumni_program.coll_dept = ?";
    $params[] = $department;
}

if (!empty($course)) {
    $sql .= " AND alumni_program.coll_course = ?";
    $params[] = $course;
}

if (!empty($batch)) {
    $sql .= " AND alumni_program.batch = ?";
    $params[] = $batch;
}

if (!empty($company)) {
    $company = strtoupper($company);
    if ($company === 'CVSU' || $company === 'CAVITE STATE UNIVERSITY') {
        $sql .= " AND w.company IN (?, ?)";
        $params[] = 'CvSU';
        $params[] = 'Cavite State University';
    } else {
        $sql .= " AND w.company = ?";
        $params[] = $company;
    }
}

$sql .= " GROUP BY student_number ";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    if (!empty($params)) {
        // Dynamically bind parameters
        $paramTypes = str_repeat("s", count($params));
        mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Load existing Excel file
    $excelFileName = "alumni_data_report.xlsx";
    $excelPath = "../excelFiles/";

    $existingFilePath = "{$excelPath}{$excelFileName}";

    if (file_exists($existingFilePath)) {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($existingFilePath);
    } else {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    }

    $sheet = $spreadsheet->getActiveSheet();

    // Clear existing data starting from row 18
    $highestRow = $sheet->getHighestRow();
    if ($highestRow >= 18) {
        $sheet->removeRow(18, $highestRow - 17);
    }

    // Add new data starting from row 18
    $rowNumber = 18;
    while ($row = mysqli_fetch_assoc($result)) {

        $row['position'] = ucwords($row['position']);
        $row['company'] = ucwords($row['company']);
        $row['email'] = strtolower($row['email']);
        $row['contact_no'] = (string) $row['contact_no'];
        $sheet->setCellValueExplicit("G$rowNumber", $row['contact_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    
        
        if ($row['workStart'] != 'No info') {
            $row['workStart'] = date("F Y",strtotime($row['workStart']));
        }
        
        $sheet->fromArray([$row], null, 'A' . $rowNumber);
        $rowNumber++;
    }

    // Save the modified Excel file
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($existingFilePath);

    $totalRows = $rowNumber - 18; // Calculate the total number of added rows

    if ($totalRows > 0) {
        echo "<hr><p class='fw-bolder text-center mt-5 py-2 bg-black text-light'>Total Number: <span class='fw-normal px-5'>$totalRows</span></p>";
        echo "<div class='d-flex justify-content-end'><a class='btn btn-success btn-sm px-3' href='excelFiles/{$excelFileName}' download>Download Excel</a></div>";
    } else {
        echo "<p class='text-center mt-3'>No new data available for the selected criteria.</p>";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>