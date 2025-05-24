<?php

require_once __DIR__ . '/../repository/presentation.php';

$config = parse_ini_file(__DIR__ . '/../config/config.ini', true);
$presentationPath = $config['presentations']['path'];

if (!file_exists($presentationPath)) {
    die("Error: JSON file not found at $presentationPath");
}

$jsonData = file_get_contents($presentationPath);
$presentations = json_decode($jsonData, true);

if (!is_array($presentations)) {
    die("Error: Invalid JSON format in presentations.json");
}

$presentationObj = new Presentation();

foreach ($presentations as $presentation) {
    if (
        isset($presentation['title'], $presentation['presenterName'], $presentation['facultyNumber'], $presentation['date'], $presentation['place'])
    ) {
        $presentationObj->addPresentation([
            'title' => $presentation['title'],
            'presenterName' => $presentation['presenterName'],
            'facultyNumber' => $presentation['facultyNumber'],
            'date' => $presentation['date'],
            'place' => $presentation['place']
        ]);
    } else {
        echo "Skipping invalid record...\n";
    }
}

echo "Presentations successfully inserted!";
?>
