<?php

class Database
{
	private $connection;

	// Чете конфигурацията от .ini файл и създава връзка с базата
	public function __construct() {
		$config = parse_ini_file("config/config.ini", true);

		$host = $config['db']['host'];
		$dbname = $config['db']['name'];
		$user = $config['db']['user'];
		$password = $config['db']['password'];

		$this->initialize($host, $dbname, $user, $password);
	}

	// Затваря връзката с базата
	public function __destruct() {
		$this->connection = null;
	}

	public function getConnection() {
		return $this->connection;
	}

	// Създава PDO връзка с база данни
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
	// Вмъква нов потребител в таблицата user
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

	public function insertPresentation($data) {
		try {
			$sql = "INSERT INTO presentation (title, presenterName, facultyNumber, date, place)
					VALUES (:title, :presenterName, :facultyNumber, :date, :place)";
			$stmt = $this->connection->prepare($sql);

			return $stmt->execute($data);
			} catch (PDOException $exception) {
				throw $exception;
			}
	}

	// Извличане на презентация по заглавие
	public function selectPresentationByTitle($title) {
		try {
			$sql = "SELECT * FROM presentation WHERE title = :title";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute(['title' => $title]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			throw $exception;
		}
	}

	public function selectAllPresentations() {
		try {
			$sql = "SELECT * FROM presentation ORDER BY date ASC";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			throw $exception;
		}
	}

	// Вмъкване на потребителско предпочитание
	public function insertPreference($data) {
		try {
			$sql = "INSERT INTO preference (username, presentationId, preferenceType)
					VALUES (:username, :presentationId, :preferenceType)";
			$stmt = $this->connection->prepare($sql);
			return $stmt->execute($data);
		} catch (PDOException $exception) {
			throw $exception;
		}
	}

	// Актуализиране на съществуващо предпочитание
	public function updatePreference($data) {
		try {
			$sql = "UPDATE preference
					SET preferenceType = :preferenceType
					WHERE username = :username AND presentationId = :presentationId";
			$stmt = $this->connection->prepare($sql);
			return $stmt->execute($data);
		} catch (PDOException $exception) {
			throw $exception;
		}
	}

	// Извличане на предпочитание за даден потребител и презентация
	public function selectPreference($username, $presentationId) {
		try {
			$sql = "SELECT * FROM preference
					WHERE username = :username AND presentationId = :presentationId";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute([
				'username' => $username,
				'presentationId' => $presentationId
			]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			throw $exception;
		}
	}
}

?>
