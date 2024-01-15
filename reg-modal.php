<style>
ol li {
    font-size: 14px;
    margin-right: 1.5rem;
}
</style>

<div class="modal fade" id="disclaimerModal" tabindex="-1" aria-labelledby="disclaimerModalLabel" aria-hidden="true">
    <div class="modal-dialog position-absolute top-50 start-50 translate-middle">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disclaimerModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-start">Welcome to the CvSU's Alumni Document Management System ("ADMS") registration. By
                    registering, you agree to the following terms:</p>
                <ol>
                    <li><strong>Eligibility:</strong> You must be a verified alumni of CvSU to register.</li>
                    <li><strong>Data Privacy:</strong> We adhere to the Data Privacy Act of the Philippines (Republic
                        Act No. 10173). Your personal data will be used for alumni-related purposes only.</li>
                    <li><strong>Usage:</strong> Use ADMS responsibly and for lawful purposes only. Do not share your
                        login details.</li>
                    <li><strong>Information:</strong> Keep your alumni information updated. We may verify and update
                        your provided details.</li>
                    <li><strong>Access Termination:</strong> We may suspend or terminate your access if you violate
                        these terms.</li>
                    <li><strong>Modifications:</strong> These terms can change; review them periodically.</li>
                </ol>
                <h6>Agreement</h6>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="agreementCheckbox">
                    <label class="form-check-label" for="agreementCheckbox">
                        I agree to the terms and conditions
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmButton" disabled>Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("agreementCheckbox").addEventListener("change", function() {
    const confirmButton = document.getElementById("confirmButton");
    confirmButton.disabled = !this.checked;

    if (this.checked) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "set_session.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send();
    }
});

document.getElementById("confirmButton").addEventListener("click", function() {
    window.location.href = "register_step1.php";
});
</script>