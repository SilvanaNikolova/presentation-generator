<?php

require_once "utility.php";
require_once "repository" . DIRECTORY_SEPARATOR . "user.php";

function registration() {
	try {
		checkIfServerRequestMethodIsPOST();
		$formFields = getRegisterFormFields();

		$user = new User();
		$user->checkIfUserIsRegistered($formFields);

		$formFields['passwordRegister'] = password_hash($formFields['passwordRegister'], PASSWORD_DEFAULT);
		$user->addUserData($formFields);

		$_SESSION['loggedIn'] = true;
		$_SESSION['username'] = $formFields['usernameRegister'];

		$response = ['success' => true];
		echo json_encode($response);
	}
	catch (Exception $exception) {
		$response = ['success' => false, 'error' => $exception->getMessage()];
		echo json_encode($response);
	}
}

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
