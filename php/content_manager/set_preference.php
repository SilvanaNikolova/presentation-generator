<?php
require_once "utility.php";
require_once "repository/presentation.php";
require_once "repository/preference.php";

function setPreference() {
    header("Content-Type: application/json; charset=UTF-8");

    try {
        checkIfServerRequestMethodIsPOST();
        checkSessionSet();

        $formData = json_decode($_POST['formData'], true);

        if (!isset($formData['title']) || !isset($formData['preferenceType'])) {
            throw new Exception("Грешка: липсва информация за заглавие или предпочитание.");
        }

        $title = formatInput($formData['title']);
        $type = formatInput($formData['preferenceType']);
        $username = $_SESSION['username'];

        $presentationRepo = new Presentation();
        $presentation = $presentationRepo->getPresentationByTitle($title);

        if (!$presentation) {
            throw new Exception("Грешка: презентацията не съществува.");
        }

        $preferenceRepo = new Preference();
        $success = $preferenceRepo->setPreference($username, $presentation['id'], $type);

        echo json_encode(["success" => $success]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
