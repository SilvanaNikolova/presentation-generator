<?php

// Показване на всички грешки за по-лесно отстраняване на проблеми при разработка
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Зарежда файлът с логиката, която маршрутизира всяка заявка към съответния PHP скрипт
require_once "router.php";

// Създава нов обект от класа Router, който ще обработва входящата заявка
$router = new Router();

// Взима пълния URL на заявката, изпратена от клиента (напр. "/api.php/login")
$requestURL = $_SERVER["REQUEST_URI"];

// Изпълнява действието според URL-а (login, registration, logout и т.н.)
$router->performAction($requestURL);

?>