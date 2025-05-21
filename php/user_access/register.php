<?php

require_once "utility.php";
require_once "repository" . DIRECTORY_SEPARATOR . "user.php";

function registration() {
	try {
		checkIfServerRequestMethodIsPOST();

		// Взима подадените данни от формата
		$formFields = getRegisterFormFields();

		// Проверява дали потребителското име вече съществува
		$user = new User();
		$user->checkIfUserIsRegistered($formFields);

		// Хеширане на паролата за сигурност
		$formFields['passwordRegister'] = password_hash($formFields['passwordRegister'], PASSWORD_DEFAULT);
		
		// Добавяне на новия потребител в базата данни
		$user->addUserData($formFields);

		// Стартиране на сесия за новорегистрирания потребител
		$_SESSION['loggedIn'] = true;
		$_SESSION['username'] = $formFields['usernameRegister'];

		// Потвърждение за успешна регистрация
		$response = ['success' => true];
		echo json_encode($response);
	}
	catch (Exception $exception) {
		$response = ['success' => false, 'error' => $exception->getMessage()];
		echo json_encode($response);
	}
}

// Валидация и извличане на данните от формата
function getRegisterFormFields(): array {
	try {
		$formFields = [];

		$formFields['usernameRegister'] = getUsername('usernameRegister');
		$formFields['passwordRegister'] = getPassword('passwordRegister');
		$formFields['emailRegister'] = getEmail('emailRegister');

		return $formFields;
	}
	catch (Exception $exception) {
		throw $exception;
	}
}

// Допълнителна функция за валидиране на имейл адрес
function getEmail($fieldName) {
	$formData = json_decode($_POST["formData"], true);
	$email = $formData[$fieldName] ?? '';

	if (!$email) {
		throw new Exception("Грешка: имейлът е задължително поле");
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		throw new Exception("Грешка: невалиден имейл адрес");
	}

	return formatInput($email);
}
?>
