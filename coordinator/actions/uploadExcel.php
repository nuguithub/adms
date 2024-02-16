<?php
// Start or resume the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../../connectDB.php';
require_once '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

// Count the total number of rows in the Excel file
function countExcelRows($filePath) {
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $worksheetArr = $worksheet->toArray();

    // Subtracting 1 to exclude the header row
    return count($worksheetArr) - 1;
}

$_SESSION['successData'] = []; // Initialize the variable for successful data
$_SESSION['failedData'] = []; // Initialize the variable for failed data

// Function to process Excel data
function processExcelData($row, $conn, $college) {
    $student_number = $row[0];
    $first_name = ucwords(strtolower($row[1]));
    $middle_name = ucwords(strtolower($row[2]));
    $last_name = ucwords(strtolower($row[3]));
    $gender = $row[4];
    $civil_status = $row[5];
    $excelDate = $row[6];
    $birthday = date('Y-m-d', strtotime($excelDate));
    $address = $row[7];
    $coll_dept = strtoupper($row[8]);
    $coll_course = strtoupper($row[9]);
    $batch = $row[10];

    // Check if student number already exists in the alumni table
    $duplicateQuery = "SELECT * FROM alumni WHERE student_number = '$student_number'";
    $duplicateResult = mysqli_query($conn, $duplicateQuery);

    if (!empty($student_number)) {
        if (mysqli_num_rows($duplicateResult) > 0) {
            $_SESSION['failedData'][] = "$student_number already exists. Duplicate account.";
            return;
        }
    } else {
        $_SESSION['failedData'][] = "Student number is empty.";
        return;
    }
    
    // Check if department exists
    $deptQuery = "SELECT * FROM departments WHERE dept_code = '$coll_dept'";
    $deptResult = mysqli_query($conn, $deptQuery);

    if (!empty($coll_dept)) {
        if ($coll_dept != $college) {
            $_SESSION['failedData'][] = "Access restricted. Importing data limited to $college alumni only.";
            return;
        } else if (mysqli_num_rows($deptResult) == 0) {
            $_SESSION['failedData'][] = "Department $coll_dept is not existing.";
            return;
        }
    } else {
        $_SESSION['failedData'][] = "Department is empty.";
        return;
    }

    // Check if course exists
    $courseQuery = "SELECT * FROM courses WHERE course_code = '$coll_course'";
    $courseResult = mysqli_query($conn, $courseQuery);

    if(!empty($coll_course)) {
        if (mysqli_num_rows($courseResult) == 0) {
            $_SESSION['failedData'][] = "Course $coll_course is not existing.";
            return;
        }
    } else {
        $_SESSION['failedData'][] = "Course is empty.";
        return;
    }

    // Save actual data for successful records
    $_SESSION['successData'][] = [
        'student_number' => $student_number,
        'first_name' => $first_name,
        'middle_name' => $middle_name,
        'last_name' => $last_name,
        'gender' => $gender,
        'civil_status' => $civil_status,
        'birthday' => $birthday,
        'address' => $address,
        'coll_dept' => $coll_dept,
        'coll_course' => $coll_course,
        'batch' => $batch,
    ];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['importExcel'])) {
    $college = $_POST['college'];
    $validExcelMimes = [
        'text/xls',
        'text/xlsx',
        'application/excel',
        'application/vnd.msexcel',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];


    $excelRowCount = countExcelRows($_FILES['excelFile']['tmp_name']);

            if ($excelRowCount > 100) {
                $_SESSION['updAlumniMess'] = ["Excel file contains more than 100 rows. Importing limited to 100 rows.", "danger"];
                header("Location: ../alumni-directory.php");
                exit(); // Ensure script termination after redirection
            }

    if (!empty($_FILES['excelFile']['name']) && in_array($_FILES['excelFile']['type'], $validExcelMimes)) {
        if (is_uploaded_file($_FILES['excelFile']['tmp_name'])) {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($_FILES['excelFile']['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheetArr = $worksheet->toArray();
            // removing header row
            array_shift($worksheetArr);

            // Process the Excel data
            foreach ($worksheetArr as $row) {
                processExcelData($row, $conn, $college);
            }
        } else {
            $_SESSION['updAlumniMess'] = ["Importing alumni data failed.", "danger"];
        }
    } else {
        $_SESSION['updAlumniMess'] = ["Invalid file format. Please upload an Excel file.", "danger"];
    }

    // Redirect to error modal
    header("Location: ../alumni-directory.php");
    exit(); // Ensure script termination after redirection
}

mysqli_close($conn);
?>