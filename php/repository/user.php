<?php
require_once "database.php";

class User {
	private $database;

	public function __construct() {
		$this->database = new Database();
	}

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

	public function checkIfUserIsRegistered(array &$formFields) {
		$user = $this->selectUserByUsername($formFields['usernameRegister']);

		if (!empty($user)) {
			throw new Exception('Грешка: потребителят вече съществува.');
		}
	}

	public function checkIfUserExists(array &$formFields) {
		$user = $this->selectUserByUsername($formFields['usernameLogin']);

		if (empty($user)) {
			throw new Exception('Грешка: потребителят не съществува.');
		}

		if (!password_verify($formFields['passwordLogin'], $user['password'])) {
			throw new Exception('Грешка: грешна парола.');
		}
	}

	private function selectUserByUsername($username) {
		$result = $this->database->selectUserByUsername($username);

		if (is_array($result)) {
			return $result;
		}

		// Поддържа PDOStatement
		return $result->fetch(PDO::FETCH_ASSOC);
	}
}

?>