<?php
function checkIfServerRequestMethodIsPOST() {
	if ($_SERVER["REQUEST_METHOD"] !== "POST") {
		throw new Exception("Невалиден тип заявка.");
	}
}

function formatInput($input) {
	return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
}

function getUsername($fieldName) {
	$formData = json_decode($_POST["formData"], true);
	$username = $formData[$fieldName] ?? '';

	if (!$username) {
		throw new Exception("Грешка: потребителското име е задължително поле");
	}

	return formatInput($username);
}

function getPassword($fieldName) {
	$formData = json_decode($_POST["formData"], true);
	$password = $formData[$fieldName] ?? '';

	if (!$password) {
		throw new Exception("Грешка: паролата е задължително поле");
	}

	return formatInput($password);
}

?>
