<?php

class Database
{
	private $connection;

	public function __construct() {
		$config = parse_ini_file(__DIR__ . "/../config/config.ini", true);

		$host = $config['db']['host'];
		$dbname = $config['db']['name'];
		$user = $config['db']['user'];
		$password = $config['db']['password'];

		$this->initialize($host, $dbname, $user, $password);
	}

	public function __destruct() {
		$this->connection = null;
	}

	private function initialize($host, $database, $user, $password) {
		try {
			$this->connection = new PDO(
				"mysql:host=$host;dbname=$database",
				$user,
				$password,
				[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
			);
		} catch (PDOException $exception) {
			die("Възникна грешка при свързване с базата: " . $exception->getMessage());
		}
	}

	// Регистрация на потребител
	public function insertUser($data) {
		try {
			$sql = "INSERT INTO user (username, password, email) VALUES (:username, :password, :email);";
			$stmt = $this->connection->prepare($sql);
			return $stmt->execute($data);
		} catch (PDOException $exception) {
			throw $exception;
		}
	}

	// Вход – извличане на потребител по username
	public function selectUserByUsername($username) {
		try {
			$sql = "SELECT * FROM user WHERE username=:username;";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute(['username' => $username]);
			return $stmt;
		} catch (PDOException $exception) {
			throw $exception;
		}
	}
}
?>
