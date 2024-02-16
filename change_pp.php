<?php
    session_start();
    include 'connectDB.php';

    function changeProfilePic($alumId, $img)
    {
        global $conn;

        if (!empty($img['name'])) {
            $img_name = $img['name'];
            $img_tmp = $img['tmp_name'];
            $upload_dir = 'img/alumni/';
            $imageFileType = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
            $allowedImageTypes = array('jpg', 'jpeg', 'png');
                    
            if (!in_array($imageFileType, $allowedImageTypes)) {
                $_SESSION['profileStat'] = ["Invalid file format. Choose only image files such as JPG, JPEG, and PNG files.", "danger"];
                header("Location: profile.php");
                exit();
            }
        
            // Check if there's an existing image in the database
            $sql_select_image = "SELECT img FROM alumni WHERE alumni_id = '$alumId'";
            $result = $conn->query($sql_select_image);
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $current_img_name = $row['img'];
        
                // Check if the new image is different from the current image
                if ($img_name !== $current_img_name) {
                    // Delete the old image
                    if (!empty($current_img_name)) {
                        $current_img_path = $upload_dir . $current_img_name;
                        if (file_exists($current_img_path)) {
                            unlink($current_img_path);
                        }
                    }
        
                    // Rename the file if it already exists
                    $base_name = pathinfo($img_name, PATHINFO_FILENAME);
                    $counter = 1;
                    $new_img_name = $base_name . '.' . $imageFileType;
        
                    while (file_exists($upload_dir . $new_img_name)) {
                        $new_img_name = $base_name . '(' . $counter . ').' . $imageFileType;
                        $counter++;
                    }
        
                    $img_path = $upload_dir . $new_img_name;
        
                    if (!move_uploaded_file($img_tmp, $img_path)) {
                        $_SESSION['profileStat'] = ["Failed to upload image.", "danger"];
                        return false;
                    }
        
                    // Update the alumni record with the new image name
                    $sql = "UPDATE alumni SET img = '$new_img_name' WHERE alumni_id = '$alumId'";
                } else {
                    // If the new image has the same name as the current image, update the alumni record without changing the image name
                    $sql = "UPDATE alumni SET img = '$img_name' WHERE alumni_id = '$alumId'";
                }
            } else {
                // There is no existing image in the database, so just insert the new image name
                $img_path = $upload_dir . $img_name;
        
                if (!move_uploaded_file($img_tmp, $img_path)) {
                    $_SESSION['profileStat'] = ["Failed to upload image.", "danger"];
                    header("Location: profile.php");
                    exit();
                }
        
                $sql = "INSERT INTO alumni (alumni_id, img) VALUES ('$alumId', '$img_name')";
            }
        
            if ($conn->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        }
        
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["changePic"])) {
        $img = $_FILES['image'];
        $alumId = $_POST['alumId']; // Added a missing semicolon here

        if (changeProfilePic($alumId, $img)) {
            $_SESSION['profileStat'] = ["Profile picture uploaded successfully.", "success"];
            header("Location: profile.php");
            exit();
        } else {
            $_SESSION['profileStat'] = ["Can't upload image.", "danger"];
            header("Location: profile.php");
            exit();
        }
    }

    $conn->close();
?>