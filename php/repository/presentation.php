<?php

require_once __DIR__ . '/../database.php';

class Presentation {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addPresentation($formFields) {
        $data = [
            'title' => $formFields['title'],
            'presenterName' => $formFields['presenterName'],
            'facultyNumber' => $formFields['facultyNumber'],
            'date' => $formFields['date'],
            'place' => $formFields['place']
        ];

        return $this->db->insertPresentation($data);
    }

    public function getPresentationByTitle($title) {
        return $this->db->selectPresentationByTitle($title);
    }

    public function getAllPresentations() {
        return $this->db->selectAllPresentations();
    }

    public function getPresentationsByUserPreference($username, $preferenceType) {
        $conn = $this->db->getConnection();

        if ($preferenceType === 'both') {
            $stmt = $conn->prepare("
                SELECT p.*
                FROM presentation p
                JOIN preference pr ON p.id = pr.presentationId
                WHERE pr.username = ?
                  AND pr.preferenceType IN ('attending', 'maybe')
            ");
            $stmt->execute([$username]);
        } else {
            $stmt = $conn->prepare("
                SELECT p.*
                FROM presentation p
                JOIN preference pr ON p.id = pr.presentationId
                WHERE pr.username = ?
                  AND pr.preferenceType = ?
            ");
            $stmt->execute([$username, $preferenceType]);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>