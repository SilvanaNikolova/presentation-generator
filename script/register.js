'use strict';

(function () {
	const registerButton = document.getElementById("register-button");

	if (registerButton) {
		registerButton.addEventListener("click", register);
	}
})();

function register(event) {
	try {
		event.preventDefault();

		const formData = {};
		formData["emailRegister"] = validateEmail("register-email");
		formData["usernameRegister"] = validateUsername("register-username");
		formData["passwordRegister"] = validatePassword("register-password");

		const repeatedPassword = document.getElementById("register-password-repeated").value.trim();
		if (!repeatedPassword || repeatedPassword !== formData["passwordRegister"]) {
			throw "Грешка: паролите не съвпадат.";
		}

		const REGISTER_METHOD = "POST";
		const REGISTER_URL = "php/api.php/registration";

		sendRegistrationRequest(REGISTER_URL, REGISTER_METHOD, `formData=${JSON.stringify(formData)}`);
	} catch (error) {
		displayRegistrationMessage(error, false);
	}
}

function validateEmail(id) {
	const value = document.getElementById(id).value.trim();

	if (!value) {
		throw "Грешка: имейлът е задължителен.";
	}
	if (!value.match(/^[\w.-]+@[a-z]+\.[a-z]{2,}$/i)) {
		throw "Грешка: невалиден имейл формат.";
	}

	return formatInput(value);
}

function validateUsername(id) {
	const value = document.getElementById(id).value.trim();

	if (!value) {
		throw "Грешка: потребителското име е задължително.";
	}
	if (!value.match(/^[A-Za-z0-9_-]{3,50}$/)) {
		throw "Грешка: потребителското име трябва да е между 3 и 50 символа.";
	}

	return formatInput(value);
}

function validatePassword(id) {
	const value = document.getElementById(id).value.trim();

	if (!value) {
		throw "Грешка: паролата е задължителна.";
	}
	if (!value.match(/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,20}$/)) {
		throw "Грешка: паролата трябва да е между 6 и 20 символа, с поне една главна буква и цифра.";
	}

	return formatInput(value);
}

function formatInput(str) {
	return str
		.trim()
		.replace(/\//g, "")
		.replace(/[&<>"']/g, s => ({
			"&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;"
		})[s] || s);
}

function sendRegistrationRequest(url, method, data) {
	const xhr = new XMLHttpRequest();

	xhr.addEventListener("load", () => handleRegistrationResponse(xhr));
	xhr.open(method, url, true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send(data);
}

function handleRegistrationResponse(xhr) {
    console.log(xhr.responseText);

	const responseCode = 200;

	if (xhr.status === responseCode) {
		const response = JSON.parse(xhr.responseText);
		if (response.success) {
			displayRegistrationMessage("Успешна регистрация!", true);
			setTimeout(() => window.location.href = "login.html", 1500);
		} else {
			displayRegistrationMessage(response.error || "Регистрацията не бе успешна.", false);
		}
	} else {
        console.error("Грешка при JSON парсване:", e);
		displayRegistrationMessage("Сървърна грешка при регистрация.", false);
	}
}

function displayRegistrationMessage(message, success) {
	const messageElement = document.getElementById("register-message");
	messageElement.style.color = success ? "green" : "red";
	messageElement.textContent = message;
}
