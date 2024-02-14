<?php
include "../../connectDB.php";
require '../vendor/autoload.php'; // Include PhpSpreadsheet autoload file

$department = $_POST['department'];
$course = $_POST['course'];
$batch = $_POST['batch'];

$sql = "SELECT alumni.student_number, alumni.fname, alumni.lname, alumni.gender, alumni_program.coll_dept, alumni_program.coll_course, alumni_program.batch 
        FROM alumni_program 
        INNER JOIN alumni ON alumni_program.alumni_id = alumni.alumni_id 
        WHERE 1=1";

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

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    if (!empty($params)) {
        // Dynamically bind parameters
        $paramTypes = str_repeat("s", count($params));
        mysqli_stmt_bind_param($stmt, $paramTypes, ...$params);
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Create a PhpSpreadsheet instance
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers to the Excel file
    $headers = array("Student Number", "First Name", "Last Name", "Sex", "College", "Course", "Year Graduated");
    $sheet->fromArray([$headers], null, 'A1');

    $rowNumber = 2;
    $totalRows = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->fromArray([$row], null, 'A' . $rowNumber);
        $rowNumber++;
        $totalRows++;
    }

    // Output download link if there is data
    if ($totalRows > 0) {
        $excelFileName = "alumni_data_report.xlsx";
        $excelPath = "../excelFiles/";

        $existingFilePath = "{$excelPath}{$excelFileName}";

        if (file_exists($existingFilePath)) {
            // Attempt to delete the existing file
            if (unlink($existingFilePath)) {
                // echo "Old Excel file removed successfully.";
            } 
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($existingFilePath);

        
        echo "<hr><p class='fw-bolder text-center mt-5 py-2 bg-black text-light'>Total Number: <span class='fw-normal px-5'>$totalRows</span></p>";
        echo "<div class='d-flex justify-content-end'><a class='btn btn-success btn-sm px-3' href='excelFiles/{$excelFileName}' download>Download Excel</a></div>";
    } else {
        echo "<p class='text-center mt-3'>No data available for the selected criteria.</p>";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>