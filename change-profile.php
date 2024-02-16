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

                <form method="post" action="change_pp.php" enctype="multipart/form-data">
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