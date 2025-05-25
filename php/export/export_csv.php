<?php
require_once __DIR__ . '/../repository/presentation.php';

session_start();

$presentationRepo = new Presentation();
$username = $_SESSION['username'] ?? null;

$type = $_GET['type'] ?? 'full';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=presentations.csv');

$output = fopen('php://output', 'w');

// Записваме BOM за UTF-8, за да се чете кирилицата правилно в Excel
fwrite($output, "\xEF\xBB\xBF");

fputcsv($output, ['Заглавие', 'Презентатор', 'Дата', 'Място']);

if ($type === 'full') {
    $presentations = $presentationRepo->getAllPresentations();
} elseif (in_array($type, ['attending', 'maybe', 'both']) && $username) {
    $presentations = $presentationRepo->getPresentationsByUserPreference($username, $type);
} else {
    $presentations = [];
}

foreach ($presentations as $p) {
    fputcsv($output, [
        $p['title'],
        $p['presenterName'],
        $p['date'],
        $p['place']
    ]);
}

fclose($output);
exit;
?>