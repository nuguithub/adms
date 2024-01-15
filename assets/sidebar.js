window.onload = function () {
	const sidebar = document.querySelector(".sidebar");
	const closeBtn = document.querySelector("#btn");

	closeBtn.addEventListener("click", function () {
		sidebar.classList.toggle("open");
		menuBtnChange();
	});

	function menuBtnChange() {
		if (sidebar.classList.contains("open")) {
			closeBtn.classList.replace("fa-bars", "fa-times");
		} else {
			closeBtn.classList.replace("fa-times", "fa-bars");
		}
	}
};
