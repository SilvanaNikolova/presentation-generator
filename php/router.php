<?php

// Зареждане на файловете, които съдържат логиката за регистрация, вход и изход
require_once "user_access" . DIRECTORY_SEPARATOR . "register.php";
require_once "user_access" . DIRECTORY_SEPARATOR . "login.php";
require_once "user_access" . DIRECTORY_SEPARATOR . "logout.php";
require_once "content_manager" . DIRECTORY_SEPARATOR . "dashboard.php";
require_once "content_manager" . DIRECTORY_SEPARATOR . "set_preference.php";
require_once "content_manager" . DIRECTORY_SEPARATOR . "load_preferences.php";

// Клас Router отговаря за разпознаване и насочване на заявките към правилната функция
class Router
{
	public function performAction($requestURL) {
		// Задаване на тип на отговора като JSON с UTF-8 кодировка
		header("Content-Type: application/json; charset=UTF-8");
		session_start();

		// Ограничаваме API-то да приема само POST заявки
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			echo json_encode(["success" => false, "error" => "Грешка: само POST заявки са разрешени."]);
			return;
		}

		// Насочване на заявката към правилната функция според URL края
		if (preg_match("/\/registration$/", $requestURL)) {
			registration(); // Извиква се registration() от register.php
		}
		elseif (preg_match("/\/login$/", $requestURL)) {
			login(); // Извиква се login() от login.php
		}
		elseif (preg_match("/\/logout$/", $requestURL)) {
			logout(); // Извиква се logout() от logout.php
		}
		elseif (preg_match("/\/loadDashboard$/", $requestURL)) {
			loadDashboardData();
		}
		elseif (preg_match("/\/setPreference$/", $requestURL)) {
			setPreference();
		}
		elseif (preg_match("/\\/loadPreferences$/", $requestURL)) {
			loadPreferences();
		}
		else {
			// Ако URL-ът не съвпада с никоя от очакваните крайни точки
			echo json_encode(["success" => false, "error" => "Грешка: невалиден API път."]);
		}
	}
}