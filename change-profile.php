<?php
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
                echo "<script>alert('Invalid file format. Choose only image files such as JPG, JPEG, and PNG files.');</script>";
                return false;
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
                        echo "<script>alert('Failed to upload image.');</script>";
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
                    echo "<script>alert('Failed to upload image.');</script>";
                    return false;
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

        if (changeProfilePic($alumId, $img)) {
            echo "<script>alert('Profile picture uploaded successfully.');
            setTimeout(function() {
                window.location.href = 'profile.php';
            }, 1000); </script>";
            exit();
        } else {
            echo "<script>alert('Can't upload image.');
            setTimeout(function() {
                window.location.href = 'profile.php';
            }, 1000); </script>";
            
        }
    }

    $conn->close();
?>


<style>
#modalPic {
    background: #333 !important;
    color: #ccc;
}

.btn-close {
    padding: .5rem;
    background-color: #aaac;
    border-radius: 100%;
}
</style>
<div class="modal fade" id="changeProfileModal_<?php echo $alumId; ?>" tabindex="-1"
    aria-labelledby="changeProfileModalLabel_<?php echo $alumId; ?>" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content mt-5 position-absolute" id="modalPic">
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <h5 class="modal-title" id="changeProfileModalLabel_<?php echo $alumId; ?>">Update Profile Picture
                    </h5>
                    <button type="button rounded-circle" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <hr>

                <form method="post" enctype="multipart/form-data">
                    <input type="text" class="form-control" name="alumId" value="<?php echo $alumId;?>" hidden />
                    <button class="btn btn-success w-100" type="button" id="upload">+ Upload
                        photo</button>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" hidden />


                    <div id="imagePreview" class="d-none justify-content-center my-3">
                        <img id="imageTag" class="rounded-circle object-fit-cover mb-1" width="150" height="150" src="">
                        <p>Image Preview</p>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-end align-items-center">
                        <a type="button rounded-circle" class="text-decoration-none fw-bold me-3"
                            data-bs-dismiss="modal" aria-label="Close"> Cancel</a>
                        <input type="submit" id="submit" name="changePic" class="btn btn-primary rounded disabled"
                            value="Save Changes">
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
const fileInput = document.getElementById("image");
const imagePreview = document.getElementById("imagePreview");
const imageTag = document.getElementById("imageTag");
const submit = document.getElementById("submit");

document.getElementById("upload").addEventListener("click", function() {
    fileInput.click();
});

fileInput.addEventListener("change", function() {
    const selectedFile = fileInput.files[0];
    if (selectedFile) {
        const objectURL = URL.createObjectURL(selectedFile);
        imageTag.src = objectURL;
        imagePreview.classList.remove("d-none");
        imagePreview.classList.add("d-block");
        submit.classList.remove("disabled");
        pickImage.textContent = "Change image";
    } else {
        imageTag.src = "";
        imagePreview.classList.add("d-none");
        imagePreview.classList.remove("d-block");
        submit.classList.add("disabled");
    }
});
</script>