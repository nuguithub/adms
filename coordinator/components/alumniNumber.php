<div class="card overflow-auto shadow border-0 my-3" style="background: #eee3;">
    <div class="mx-auto m-5" style="width: 80%;">
        <h3 class="fw-bold mb-3">No. of Graduates</h3>

        <table class="table align-middle table-borderless gg">
            <tbody>
                <tr>
                    <td>
                        <label class="form-label" for="department">Select College:</label>
                    </td>
                    <td>
                        <select class="form-select" id="department" disabled>
                            <option value="">All College</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label" for="course">Select Course:</label>
                    </td>
                    <td>
                        <select class="form-select" id="course">
                            <option value="">All Courses</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label" for="batch">Select Batch:</label>
                    </td>
                    <td>
                        <select class="form-select" id="batch">
                            <option value="">All Batches</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label" for="company">Select Company:</label>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="company" placeholder="All Company">
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-sm btn-secondary px-3" onclick="getAlumniData()">Get Alumni Reports</button>

        <div id="result"></div>

    </div>
</div>


<script>
$(document).ready(function() {
    // Fetch and populate departments
    $.ajax({
        type: "GET",
        url: "reports/getDepartments.php",
        success: function(data) {
            $("#department").html(data);

            // Call getCourses.php on page load to initially populate the courses
            var selectedDepartment = $("#department").val();
            updateCoursesDropdown(selectedDepartment);
        }
    });

    // Function to update the courses dropdown based on the selected department
    function updateCoursesDropdown(selectedDepartment) {
        $.ajax({
            type: "GET",
            url: "reports/getCourses.php",
            data: {
                department: selectedDepartment
            },
            success: function(data) {
                $("#course").html(data);
            }
        });
    }

    // Fetch and populate batches
    $.ajax({
        type: "GET",
        url: "reports/getBatches.php",
        success: function(data) {
            var batches = JSON.parse(data);
            for (var i = 0; i < batches.length; i++) {
                $("#batch").append('<option value="' + batches[i] + '">' + batches[i] +
                    '</option>');
            }
        }
    });

    // Event listener for department change
    $("#department").change(function() {
        var selectedDepartment = $(this).val();
        updateCoursesDropdown(selectedDepartment);
    });

    // Event listener for "Generate Report" button
    $("#generateReportBtn").click(function() {
        getAlumniData();
    });
});

function getAlumniData() {
    var department = document.getElementById("department").value;
    var course = document.getElementById("course").value;
    var batch = document.getElementById("batch").value;
    var company = document.getElementById("company").value;

    $.ajax({
        type: "POST",
        url: "reports/getAlumniData.php",
        data: {
            department: department,
            course: course,
            batch: batch,
            company: company
        },
        success: function(response) {
            $("#result").html(response);
        },
    });
}
</script>