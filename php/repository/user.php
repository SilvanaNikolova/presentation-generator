<?php
require_once "database.php";

// Клас User инкапсулира всички операции, свързани с потребители
class User {
	private $database;

	// Създава нова инстанция и осъществява връзка с базата
	public function __construct() {
		$this->database = new Database();
	}

	// Добавя нов потребител в базата чрез подадените полета
	public function addUserData(array &$formFields) {
        $data = [
		'username' => $formFields['usernameRegister'],
		'password' => $formFields['passwordRegister'],
		'email'    => $formFields['emailRegister']
	    ];

		$query = $this->database->insertUser($data);

		if (!$query) {
			throw new Exception("Грешка: регистрацията не бе успешна.");
		}
	}

	// Проверява дали потребителят вече е регистриран
	public function checkIfUserIsRegistered(array &$formFields) {
		$user = $this->selectUserByUsername($formFields['usernameRegister']);

		if (!empty($user)) {
			throw new Exception('Грешка: потребителят вече съществува.');
		}
	}

	// Проверява дали потребителят съществува и дали паролата е вярна
	public function checkIfUserExists(array &$formFields) {
		$user = $this->selectUserByUsername($formFields['usernameLogin']);

		if (empty($user)) {
			throw new Exception('Грешка: потребителят не съществува.');
		}

		if (!password_verify($formFields['passwordLogin'], $user['password'])) {
			throw new Exception('Грешка: грешна парола.');
		}
	}

	// Извлича потребител по потребителско име от базата
	private function selectUserByUsername($username) {
		$result = $this->database->selectUserByUsername($username);

		if (is_array($result)) {
			return $result;
		}

		// Ако връща PDOStatement, извличаме асоциативен масив
		return $result->fetch(PDO::FETCH_ASSOC);
	}
}

?>