<?php
require_once "utility.php";
require_once "repository/preference.php";

function loadPreferences() {
    header("Content-Type: application/json; charset=UTF-8");

    try {
        checkSessionSet();
        $username = $_SESSION['username'];

        $repo = new Preference();
        $preferences = $repo->getAllPreferencesByUser($username);

        echo json_encode(["success" => true, "data" => $preferences], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
