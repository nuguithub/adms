<style>
#modalExcel {
    background: #333 !important;
    color: #ccc;
}

#ekis {
    padding: .5rem;
    background-color: #aaac;
    border-radius: 100%;
}
</style>
<div class="modal fade" id="importExcel" tabindex="-1" aria-labelledby="importExcelLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content mt-5 position-absolute" id="modalExcel">
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <h5 class="modal-title" id="importExcelLabel">Import Excel</h5>
                    <button type="button rounded-circle" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="ekis"></button>
                </div>
                <hr>

                <div class="text-end mb-2 overflow-hidden"><a href="ExceLFormat.xlsx" download style="font-size: 10px;"
                        class="btn btn-secondary btn-sm text-wrap w-25">Download Excel
                        Format</a></div>

                <form method="POST" action="actions/uploadExcel.php" enctype="multipart/form-data" id="excelForm">
                    <input type="text" name="college" value="<?php echo $college; ?>" hidden />
                    <label for="excelFile" class="btn btn-success w-100">+ Upload Excel File
                        <input type="file" class="form-control" id="excelFile" name="excelFile" accept=".xlsx, .xls"
                            hidden />
                    </label>
                    <div id="excelInfo" class="text-center my-3"></div>
                    <div class="text-end" style="font-size: 0.78rem;">
                        <strong>Note:</strong> <em>Please ensure that your file contains a maximum of 100 alumni data to
                            prevent any potential errors during the import process.</em>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-end align-items-center">
                        <a type="button rounded-circle" class="text-decoration-none fw-bold me-3"
                            data-bs-dismiss="modal" aria-label="Close"> Cancel</a>
                        <input type="submit" id="submit" name="importExcel" class="btn btn-primary rounded disabled"
                            value="Import Excel">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
const excelFileInput = document.getElementById('excelFile');
const excelInfo = document.getElementById('excelInfo');
const submitButton = document.getElementById('submit');

excelFileInput.addEventListener('change', function() {
    const fileName = excelFileInput.value.split('\\').pop();
    if (fileName) {
        excelInfo.innerHTML = `<strong>Selected Excel File:</strong> ${fileName}`;
        excelInfo.classList.remove('d-none');
        submitButton.classList.remove('disabled');
    } else {
        excelInfo.textContent = '';
        excelInfo.classList.add('d-none');
        submitButton.classList.add('disabled');
    }
});
</script>