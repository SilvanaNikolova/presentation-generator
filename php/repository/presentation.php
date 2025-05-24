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
}

?>