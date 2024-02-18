<div class="card overflow-auto shadow border-0 mb-5" style="background: #eee3;">
    <div class="mx-auto m-5" style="width: 80%;">
        <h3 class="fw-bold mb-3">Career Data</h3>

        <table class="table align-middle table-borderless gg">
            <tbody>
                <tr>
                    <td>
                        <label class="form-label" for="departmentx">Select Department:</label>
                    </td>
                    <td>
                        <select class="form-select" id="departmentx" disabled>
                            <option value="">All Colleges</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="form-label" for="coursex">Select Course:</label>
                    </td>
                    <td>
                        <select class="form-select" id="coursex">
                            <option value="">All Courses</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-sm btn-secondary px-3" onclick="getCareerData()">Get Career Reports</button>

        <div id="resultx"></div>

    </div>
</div>


<script>
$(document).ready(function() {
    // Fetch and populate departmentxs
    $.ajax({
        type: "GET",
        url: "careerReports/getDepartments.php",
        success: function(data) {
            $("#departmentx").html(data);

            // Call getCourses.php on page load to initially populate the coursexs
            var selectedDepartmentx = $("#departmentx").val();
            updateCoursesDropdownx(selectedDepartmentx);
        }
    });

    // Event listener for departmentx change
    $("#departmentx").change(function() {
        var selectedDepartmentx = $(this).val();
        updateCoursesDropdownx(selectedDepartmentx);
    });

    // Event listener for "Generate Report" button
    $("#generateReportBtn").click(function() {
        getCareerData();
    });
});

// Function to update the coursexs dropdown based on the selected departmentx
function updateCoursesDropdownx(selectedDepartmentx) {
    $.ajax({
        type: "GET",
        url: "careerReports/getCourses.php",
        data: {
            departmentx: selectedDepartmentx
        },
        success: function(data) {
            $("#coursex").html(data);
        }
    });
}

function getCareerData() {
    var departmentx = document.getElementById("departmentx").value;
    var coursex = document.getElementById("coursex").value;

    $.ajax({
        type: "POST",
        url: "careerReports/getCareerData.php",
        data: {
            departmentx: departmentx,
            coursex: coursex
        },
        success: function(response) {
            $("#resultx").html(response);
        },
    });
}
</script>