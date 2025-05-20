<?php

require_once "utility.php";
require_once "repository" . DIRECTORY_SEPARATOR . "user.php";

function login() {
	try {
		checkIfServerRequestMethodIsPOST();
		$formFields = getLoginFormFields();

		$user = new User();
		$user->checkIfUserExists($formFields);

		$_SESSION['loggedIn'] = true;
		$_SESSION['username'] = $formFields['usernameLogin'];

		$response = ['success' => true];
		echo json_encode($response);
	}
	catch (Exception $exception) {
		$response = ['success' => false, 'error' => $exception->getMessage()];
		echo json_encode($response);
	}
}

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
