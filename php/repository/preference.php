<?php
require_once "database.php";

class Preference {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function setPreference($username, $presentationId, $type) {
        if ($type === "empty") {
            return $this->deletePreference($username, $presentationId);
        }

        $existing = $this->getPreference($username, $presentationId);

        if ($existing) {
            $sql = "UPDATE preference SET preferenceType = :type WHERE username = :username AND presentationId = :presentationId";
        } else {
            $sql = "INSERT INTO preference (username, presentationId, preferenceType) VALUES (:username, :presentationId, :type)";
        }

        $stmt = $this->db->getConnection()->prepare($sql);
        return $stmt->execute([
            'username' => $username,
            'presentationId' => $presentationId,
            'type' => $type
        ]);
    }

    public function deletePreference($username, $presentationId) {
        $sql = "DELETE FROM preference WHERE username = :username AND presentationId = :presentationId";
        $stmt = $this->db->getConnection()->prepare($sql);
        return $stmt->execute([
            'username' => $username,
            'presentationId' => $presentationId
        ]);
    }

    public function getPreference($username, $presentationId) {
        $sql = "SELECT * FROM preference WHERE username = :username AND presentationId = :presentationId";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'presentationId' => $presentationId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllPreferencesByUser($username) {
        $sql = "SELECT p.title, p.date, pr.preferenceType 
                FROM preference pr
                JOIN presentation p ON pr.presentationId = p.id
                WHERE pr.username = :username";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPreferenceByUsernameAndPresentationId($username, $presentationId) {
        $sql = "SELECT preferenceType FROM preference WHERE username = :username AND presentationId = :presentationId";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'presentationId' => $presentationId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
