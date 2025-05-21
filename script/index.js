const loginForm = document.getElementById("login-form");
const registerForm = document.getElementById("register-form");

document.getElementById("show-login").addEventListener("click", () => {
  	registerForm.classList.remove("show");
	loginForm.reset();
  	loginForm.classList.add("show");
});

document.getElementById("show-register").addEventListener("click", () => {
	loginForm.classList.remove("show");
	registerForm.reset();
  	registerForm.classList.add("show");
});

document.getElementById("login-form").addEventListener("submit", async (e) => {
	e.preventDefault();
	const formData = {
    	usernameLogin: document.getElementById("login-username").value,
    	passwordLogin: document.getElementById("login-password").value
  };
  
	const response = await fetch("php/api.php/login", {
		method: "POST",
		headers: { "Content-Type": "application/x-www-form-urlencoded" },
		body: `formData=${JSON.stringify(formData)}`
  	});
	const result = await response.json();
	document.getElementById("login-message").style.color = result.success ? "green" : "red";
	document.getElementById("login-message").textContent = result.success ? "Успешна регистрация" : result.error;
	
	if (result.success) {
		window.location.href = "dashboard.html";
	}
});

document.getElementById("register-form").addEventListener("submit", async (e) => {
	e.preventDefault();
	const formData = {
		emailRegister: document.getElementById("register-email").value,
		usernameRegister: document.getElementById("register-username").value,
		passwordRegister: document.getElementById("register-password").value
  	};
  	const repeatedPassword = document.getElementById("register-password-repeated").value;
  	if (formData.passwordRegister !== repeatedPassword) {
		document.getElementById("registration-message").style.color = "red";
    	document.getElementById("registration-message").textContent = "Грешка: паролите не съвпадат.";
    	return;
  	}
  	const response = await fetch("php/api.php/registration", {
		method: "POST",
		headers: { "Content-Type": "application/x-www-form-urlencoded" },
		body: `formData=${JSON.stringify(formData)}`
	});
  	const result = await response.json();
  
	document.getElementById("registration-message").style.color = result.success ? "green" : "red";
  	document.getElementById("registration-message").textContent = result.success ? "Успешна регистрация!" : result.error;
  	if (result.success) 
		registerForm.reset();
});
