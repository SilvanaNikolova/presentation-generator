<?php

require_once "utility.php";
require_once "repository" . DIRECTORY_SEPARATOR . "presentation.php";
require_once "repository" . DIRECTORY_SEPARATOR . "preference.php";

function loadDashboardData() {
    try {
        checkSessionSet();

        $username = $_SESSION['username'];
        $presentationRepo = new Presentation();
        $preferenceRepo = new Preference();

        $presentations = $presentationRepo->getAllPresentations();

        foreach ($presentations as &$presentation) {
            if (isset($presentation['id'])) {
                $pref = $preferenceRepo->getPreferenceByUsernameAndPresentationId($username, $presentation['id']);
                $presentation['preferenceType'] = $pref['preferenceType'] ?? "empty";
            } else {
                $presentation['preferenceType'] = "empty";
            }
        }

        echo json_encode(['success' => true, 'data' => $presentations]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
