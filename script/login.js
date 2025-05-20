'use strict';

(function () {
	const enterButton = document.getElementById("enter-button");
	enterButton.addEventListener("click", login);
})();

function login(event) {
	try {
		event.preventDefault();

		const formData = {};
		formData["usernameLogin"] = validateLoginUsername("username");
		formData["passwordLogin"] = validateLoginPassword("password");

		const LOGIN_METHOD = "POST";
		const LOGIN_REQUEST_URL = "php/api.php/login";

		sendLoginRequest(LOGIN_REQUEST_URL, LOGIN_METHOD, `formData=${JSON.stringify(formData)}`);
	} catch (exception) {
		displayLoginError(exception);
	}
}

function validateLoginUsername(elementId) {
	const username = document.getElementById(elementId).value;

	if (!username.trim()) {
		throw "Грешка: потребителското име е задължително.";
	}

	return formatInput(username);
}

function validateLoginPassword(elementId) {
	const password = document.getElementById(elementId).value;

	if (!password.trim()) {
		throw "Грешка: паролата е задължително поле.";
	}

	return formatInput(password);
}

function sendLoginRequest(url, method, data) {
	const xhr = new XMLHttpRequest();

	xhr.addEventListener("load", () => handleLoginResponse(xhr));
	xhr.open(method, url, true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);
}

function handleLoginResponse(xhr) {
	const responseCode = 200;

	if (xhr.status === responseCode) {
		const response = JSON.parse(xhr.responseText);
		if (response.success) {
			window.location.href = "dashboard.html"; // или друга защитена страница
		} else {
			displayLoginError(response.error || "Грешка при вход.");
		}
	} else {
		displayLoginError("Грешка при свързване със сървъра.");
	}
}

function displayLoginError(message) {
	const errorLabel = document.getElementById("error");
	errorLabel.style.color = "red";
	errorLabel.textContent = message;
}

function formatInput(str) {
	return str.trim()
		.replace(/\//g, "")
		.replace(/[&<>"']/g, symbol => {
			const map = {
				"&": "&amp;",
				"<": "&lt;",
				">": "&gt;",
				'"': "&quot;",
				"'": "&#039;"
			};
			return map[symbol] || symbol;
		});
}
