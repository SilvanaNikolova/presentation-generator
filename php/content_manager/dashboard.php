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

// function loadDashboardData() {
//     header("Content-Type: application/json; charset=UTF-8");

//     try {
//         checkSessionSet();

//         $config = parse_ini_file("config/config.ini", true);

//         if (!isset($config['presentations']) || !isset($config['presentations']['path'])) {
//             throw new Exception("Грешка: Липсва конфигурация за presentations.path в config.ini");
//         }

//         $filePath = $config['presentations']['path'];

//         if (!file_exists($filePath)) {
//             throw new Exception("Грешка: JSON файлът с презентации не е намерен.");
//         }

//         $presentationsJSON = file_get_contents($filePath);
//         $presentations = json_decode($presentationsJSON, true);

//         echo json_encode([
//             "success" => true,
//             "data" => $presentations,
//             "username" => $_SESSION['username']
//         ], JSON_UNESCAPED_UNICODE);

//     } catch (Exception $e) {
//         echo json_encode([
//             "success" => false,
//             "error" => $e->getMessage()
//         ]);
//     }
// }
