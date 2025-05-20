<?php

function logout() {
	try {
		if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
			throw new Exception('Грешка: няма активна сесия.');
		}

		session_unset();
		session_destroy();

		echo json_encode(['success' => true]);
	} catch (Exception $e) {
		echo json_encode(['success' => false, 'error' => $e->getMessage()]);
	}
}
?>
