<?php

require_once "utility.php";
require_once "repository" . DIRECTORY_SEPARATOR . "user.php";

function login() {
	try {

		// Позволява само POST заявки
		checkIfServerRequestMethodIsPOST();

		// Извлича подадените от потребителя данни от формата
		$formFields = getLoginFormFields();

		// Създава обект User и проверява дали потребителят съществува
		$user = new User();
		$user->checkIfUserExists($formFields);

		// Ако е валиден, създава сесия и запазва потребителското име
		$_SESSION['loggedIn'] = true;
		$_SESSION['username'] = $formFields['usernameLogin'];

		// Връща положителен отговор към фронт-енда
		$response = ['success' => true];
		echo json_encode($response);
	}
	catch (Exception $exception) {
		// Ако има грешка – връща я във формат JSON
		$response = ['success' => false, 'error' => $exception->getMessage()];
		echo json_encode($response);
	}
}

// Функция, която валидира и връща данните от формата за вход
function getLoginFormFields(): array {
	try {
		$formFields = [];

		$formFields['usernameLogin'] = getUsername('usernameLogin');
		$formFields['passwordLogin'] = getPassword('passwordLogin');

		return $formFields;
	}
	catch (Exception $exception) {
		throw $exception;
	}
}
?>
