<?php

require_once "user_access" . DIRECTORY_SEPARATOR . "register.php";
require_once "user_access" . DIRECTORY_SEPARATOR . "login.php";
require_once "user_access" . DIRECTORY_SEPARATOR . "logout.php";

class Router
{
	public function performAction($requestURL) {
		header("Content-Type: application/json; charset=UTF-8");
		session_start();

		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			echo json_encode(["success" => false, "error" => "Грешка: само POST заявки са разрешени."]);
			return;
		}

		if (preg_match("/\/registration$/", $requestURL)) {
			registration();
		}
		elseif (preg_match("/\/login$/", $requestURL)) {
			login();
		}
		elseif (preg_match("/\/logout$/", $requestURL)) {
			logout();
		}
		else {
			echo json_encode(["success" => false, "error" => "Грешка: невалиден API път."]);
		}
	}
}