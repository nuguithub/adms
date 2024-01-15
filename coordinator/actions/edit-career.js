// Function to enable career name editing
function editCareer(careerId) {
	// Find the input field associated with the careerId
	const careerInput = document.getElementById(`career_${careerId}`);

	// Find the edit and save buttons associated with the careerId
	const editButton = document.getElementById(`edit_${careerId}`);
	const saveButton = document.getElementById(`save_${careerId}`);

	// Enable the input field for editing
	careerInput.disabled = false;

	// Hide the Edit button and show the Save button
	editButton.style.display = "none";
	saveButton.style.display = "";

	// Focus on the input field for easy editing
	careerInput.focus();
}

// Function to save edited career name
function saveCareer(careerId) {
	// Find the input field associated with the careerId
	const careerInput = document.getElementById(`career_${careerId}`);

	// Find the edit and save buttons associated with the careerId
	const editButton = document.getElementById(`edit_${careerId}`);
	const saveButton = document.getElementById(`save_${careerId}`);

	// Disable the input field to prevent further editing
	careerInput.disabled = true;

	// Show the Edit button and hide the Save button
	editButton.style.display = "";
	saveButton.style.display = "none";

	// Get the updated career name
	const updatedCareerName = careerInput.value;

	// Send an AJAX request to update the career name in the database
	const xhr = new XMLHttpRequest();
	xhr.open("POST", "updcar_act.php"); // Replace 'update-career.php' with your server-side script
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.onload = function () {
		if (xhr.status === 200) {
			alert("Career updated successfully!");
		} else {
			alert("Career update failed!");
		}
	};
	xhr.send("career_id=" + careerId + "&career_name=" + updatedCareerName);
}
