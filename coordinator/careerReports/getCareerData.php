<?php
include "../../connectDB.php";
require '../vendor/autoload.php';

$department = $_POST['departmentx'];
$course = $_POST['coursex'];

$sql = "SELECT 
        a.student_number,
        CONCAT(a.fname, ' ', COALESCE(a.mname, ''), ' ', a.lname) AS full_name,
        COALESCE(wh.position, 'No Info') AS position,
        CONCAT(wh.company, ', ', COALESCE(wh.company_address, '')) AS company,
        ap.coll_dept,
        ap.coll_course,
        ap.batch,
        CASE 
            WHEN wh.workEnd = 'Present' AND c.related = 'YES' THEN 'YES'
            WHEN wh.workEnd = 'Present' AND c.related = 'NOT' THEN 'NO'
            ELSE 'No Info'
        END AS inclined
        FROM alumni a
        LEFT JOIN workHistory wh ON a.user_id = wh.user_id
        LEFT JOIN careers c ON wh.position = c.career_name
        LEFT JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
            WHERE 
            ((wh.workEnd = 'Present' AND c.related = 'YES')
            OR
            (wh.workEnd = 'Present' AND c.related = 'NOT')
            OR
            (wh.position IS NULL))";

$params = array();

if (!empty($department)) {
    $sql .= " AND ap.coll_dept = ?";
    $params[] = $department;
}

if (!empty($course)) {
    $sql .= " AND ap.coll_course = ?";
    $params[] = $course;
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

    // Count variables initialization
    $employedCount = 0;
    $employedNotInclinedCount = 0;
    $noInfoCount = 0;

    // Create a PhpSpreadsheet instance
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add headers to the Excel file
    $headers = array("Student Number", "Full Name", "Position", "Company", "College Department", "College Course", "Batch", "Inclined");
    $sheet->fromArray([$headers], null, 'A1');

    $rowNumber = 2;
    while ($row = mysqli_fetch_assoc($result)) {
        $sheet->fromArray([$row], null, 'A' . $rowNumber);

        // Count based on 'Inclined' category
        switch ($row['inclined']) {
            case 'YES':
                $employedCount++;
                break;
            case 'NO':
                $employedNotInclinedCount++;
                break;
            case 'No Info':
                $noInfoCount++;
                break;
        }

        $rowNumber++;
    }

    if ($rowNumber > 2) {
        // Output download link if there is data
        $excelFileName = "career_data_report.xlsx";
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

        echo '<div class="container"><div class="col-9 mx-auto">';
        echo '<table class=" mt-2 table table-borderless repx">';
        echo '<tbody>';
        
        echo "<tr><th class='w-50 text-center'>Employed</th><td class='w-25'>$employedCount</td></tr>";
        echo "<tr><th class='text-center'>Employed but not Inclined</th><td>$employedNotInclinedCount</td></tr>";
        echo "<tr><th class='text-center'>No info</th><td>$noInfoCount</td></tr>";

        echo '</tbody>';
        echo '</table>';
        echo "<div class='d-flex justify-content-end'>
            <a class='btn btn-success btn-sm px-3' href='excelFiles/{$excelFileName}' download>Download Report</a>
            </div>
            </div>
            </div>";
    } else {
        echo "<p class='text-center mt-3'>No data available for the selected criteria.</p>";
    }
    
}

// Close the prepared statement
mysqli_stmt_close($stmt);

mysqli_close($conn);
?>