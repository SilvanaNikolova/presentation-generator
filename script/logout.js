'use strict';

(function () {
	const logoutButton = document.getElementById("logout-button");

	if (logoutButton) {
		logoutButton.addEventListener("click", logout);
	}
})();

function logout(event) {
	event.preventDefault();

	const xhr = new XMLHttpRequest();

	xhr.addEventListener("load", () => handleLogoutResponse(xhr));

	xhr.open("POST", "php/api.php/logout", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(); // няма нужда от данни
}

function handleLogoutResponse(xhr) {
	const OK = 200;

	if (xhr.status === OK) {
		const response = JSON.parse(xhr.responseText);

		if (response.success) {
			window.location.href = "index.html";
		} else {
			alert(response.error || "Грешка при изход от системата.");
		}
	} else {
		alert("Сървърна грешка при изход.");
	}
}
