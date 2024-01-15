<?php

require_once 'connectDB.php';

function escapeString($conn, $value)
{
    return mysqli_real_escape_string($conn, $value);
}

function fetchUserData($conn, $id)
{
    $getUser = "SELECT a.*, ap.coll_dept, ap.coll_course 
                FROM alumni a
                LEFT JOIN alumni_program ap ON a.alumni_id = ap.alumni_id
                WHERE a.user_id = '$id'";
    $userResult = $conn->query($getUser);
    

    return ($userResult && $userResult->num_rows > 0) ? $userResult->fetch_assoc() : null;
}

function getOtherCareerName($conn, $otherCareer, $coll_dept, $coll_course, $position)
{
    $checkSql = "SELECT career_name FROM careers WHERE career_name = '$otherCareer'";
    $result = $conn->query($checkSql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc()["career_name"];
    }

    if ($position == 'other') {
        $addCareer = "INSERT INTO careers (career_name, department, course, related) VALUES ('$otherCareer', '$coll_dept', '$coll_course', 'NOT')";
        if ($conn->query($addCareer)) {
            return $conn->insert_id;
        }
    }

    return false;
}

function isValidDateRange($start, $end)
{
    // Check if $end date is later than $start date
    return (strtotime($start) <= strtotime($end)) && (strtotime($end) <= strtotime(date('Y-m-d')));
}

function updateWorkHistory($conn, $user_id, $curDate, $position, $empStat, $company, $workStart, $formattedWorkEnd)
{
    if (empty($formattedWorkEnd)) {
        $formattedWorkEnd = 'Present';
    }

    if ($position == 'Unemployed') {
        $company = 'N/A';
    }

    $checkExistingQuery = "SELECT COUNT(*) FROM workHistory WHERE user_id = ? AND workEnd = 'Present'";
    $stmtCheckExisting = $conn->prepare($checkExistingQuery);
    $stmtCheckExisting->bind_param("s", $user_id);
    $stmtCheckExisting->execute();
    $stmtCheckExisting->bind_result($rowCount);
    $stmtCheckExisting->fetch();
    $stmtCheckExisting->close();

    if ($rowCount > 0 && $formattedWorkEnd == 'Present') {
        // Update the existing record with the current date as the end date
        $updateQuery = "UPDATE workHistory SET workEnd = ? WHERE user_id = ? AND workEnd = 'Present'";
        $stmtUpdate = $conn->prepare($updateQuery);
        $stmtUpdate->bind_param("ss", $curDate, $user_id);

        if (!$stmtUpdate->execute()) {
            $stmtUpdate->close();
            return false;
        }

        $stmtUpdate->close();
    }

    $addWorkQuery = "INSERT INTO workHistory (user_id, company, position, empStat, workStart, workEnd) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($addWorkQuery);

    // If the position is numeric, assume it's a career_id and fetch the career_name
    if (is_numeric($position)) {
        $careerQuery = "SELECT career_name FROM careers WHERE career_id = ?";
        $stmtCareer = $conn->prepare($careerQuery);
        $stmtCareer->bind_param("i", $position);
        $stmtCareer->execute();
        $stmtCareer->bind_result($position);
        $stmtCareer->fetch();
        $stmtCareer->close();
    }

    $stmtInsert->bind_param("isssss", $user_id, $company, $position, $empStat, $workStart, $formattedWorkEnd);

    if ($stmtInsert->execute()) {
        $stmtInsert->close();
        return true;
    }

    $stmtInsert->close();
    return false;
}



if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editWork"])) {

    $id = $_POST['id'];
    $company = escapeString($conn, $_POST['company']);
    $position = escapeString($conn, $_POST['position']);
    $empStat = escapeString($conn, $_POST['empStat']);
    $workStart = escapeString($conn, $_POST['workStart']);
    $workEnd = escapeString($conn, $_POST['workEnd']);
    $otherCareer = escapeString($conn, $_POST['otherCareer']);

    switch ($empStat) {
        case "COS":
            $empStat = "Career of Service";
            break;
        case "JO":
            $empStat = "Job Order";
            break;
        case "WO":
            $empStat = "Work Order";
            break;
        default:
            $empStat;
    }

    $userData = fetchUserData($conn, $id);

    if ($userData) {
        $user_id = $userData['user_id'];
        $coll_dept = $userData['coll_dept'];
        $coll_course = $userData['coll_course'];

        if($workEnd != '' || $workEnd != NULL) {
            if (!isValidDateRange($workStart, $workEnd)) {
                echo "<script>alert('Invalid date range. Work End date should be later than Work Start date and not ahead of the current date.');
                        setTimeout(function() {
                        window.location.href = 'profile.php';
                        }, 300); </script>";
            } else {
                if (!empty($otherCareer)) {
                    $otherCareerName = getOtherCareerName($conn, $otherCareer, $coll_dept, $coll_course, $position);
            
                    if ($otherCareerName !== false) {
                        if (updateWorkHistory($conn, $user_id, DATE('Y-m'), $otherCareerName, $empStat, $company, $workStart, $workEnd)) {
                            echo "<script>alert('Account updated successfully.');
                                setTimeout(function() {
                                window.location.href = 'profile.php';
                                }, 300); </script>";
                        } else {
                            echo "<script>alert('Failed to update account.');
                                setTimeout(function() {
                                window.location.href = 'profile.php';
                                }, 300); 
                                </script>";
                        }
                    } else {
                        echo "<script>alert('Failed to add other career.');
                            setTimeout(function() {
                            window.location.href = 'profile.php';
                            }, 300); </script>";
                    }
                } else {
                    // Check for the "Select Career" option
                    if ($position === "Select Career") {
                        echo "<script>alert('Pick position.');
                            setTimeout(function() {
                            window.location.href = 'profile.php';
                            }, 300); </script>";
                    } else {
                        // Check for blank workEnd to save as "Present"
                        $workEnd = empty($workEnd) ? 'Present' : $workEnd;
            
                        if (updateWorkHistory($conn, $user_id, DATE('Y-m'), $position, $empStat, $company, $workStart, $workEnd)) {
                            echo "<script>alert('Account updated successfully.');
                                setTimeout(function() {
                                window.location.href = 'profile.php';
                                }, 300); </script>";
                        } else {
                            echo "<script>alert('Failed to update account.');
                                setTimeout(function() {
                                window.location.href = 'profile.php';
                                }, 300); </script>";
                        }
                    }
                }
            }
        } else {
            if (!empty($otherCareer)) {
                $otherCareerName = getOtherCareerName($conn, $otherCareer, $coll_dept, $coll_course, $position);
        
                if ($otherCareerName !== false) {
                    if (updateWorkHistory($conn, $user_id, DATE('Y-m'), $otherCareerName, $empStat, $company, $workStart, $workEnd)) {
                        echo "<script>alert('Account updated successfully.');
                            setTimeout(function() {
                            window.location.href = 'profile.php';
                            }, 300); </script>";
                    } else {
                        echo "<script>alert('Failed to update account.');
                            setTimeout(function() {
                            window.location.href = 'profile.php';
                            }, 300); 
                            </script>";
                    }
                } else {
                    echo "<script>alert('Failed to add other career.');
                        setTimeout(function() {
                        window.location.href = 'profile.php';
                        }, 300); </script>";
                }
            } else {
                // Check for the "Select Career" option
                if ($position === "Select Career") {
                    echo "<script>alert('Pick position.');
                        setTimeout(function() {
                        window.location.href = 'profile.php';
                        }, 300); </script>";
                } else {
                    // Check for blank workEnd to save as "Present"
                    $workEnd = empty($workEnd) ? 'Present' : $workEnd;
        
                    if (updateWorkHistory($conn, $user_id, DATE('Y-m'), $position, $empStat, $company, $workStart, $workEnd)) {
                        echo "<script>alert('Account updated successfully.');
                            setTimeout(function() {
                            window.location.href = 'profile.php';
                            }, 300); </script>";
                    } else {
                        echo "<script>alert('Failed to update account.');
                            setTimeout(function() {
                            window.location.href = 'profile.php';
                            }, 300); </script>";
                    }
                }
            }
        }
        
    } else {
        echo "<script>alert('User not found.');</script>";
    }
}

$conn->close();
?>