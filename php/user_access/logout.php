<?php

function logout() {
	try {

		// Проверка дали потребителят е в сесия
		if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
			throw new Exception('Грешка: няма активна сесия.');
		}

		// Изчистване на сесията
		session_unset();
		session_destroy();

		// Потвърждение за успешно излизане
		echo json_encode(['success' => true]);
	} catch (Exception $e) {
		// Грешка при излизане
		echo json_encode(['success' => false, 'error' => $e->getMessage()]);
	}
}
?>
