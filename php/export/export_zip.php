<?php
require_once __DIR__ . '/../repository/presentation.php';

session_start();

$presentationRepo = new Presentation();
$username = $_SESSION['username'] ?? null;
$type = $_GET['type'] ?? 'full';

// Създаваме временен CSV файл в паметта
$tempCsv = fopen('php://temp', 'r+');

// Добавяме BOM за UTF-8, за да се чете кирилицата правилно в Excel
fwrite($tempCsv, "\xEF\xBB\xBF");

// Заглавията на CSV файла
fputcsv($tempCsv, ['Заглавие', 'Презентатор', 'Дата', 'Място']);

if ($type === 'full') {
    $presentations = $presentationRepo->getAllPresentations();
} elseif (in_array($type, ['attending', 'maybe', 'both']) && $username) {
    $presentations = $presentationRepo->getPresentationsByUserPreference($username, $type);
} else {
    $presentations = [];
}

// Записваме данните във временния CSV
foreach ($presentations as $p) {
    fputcsv($tempCsv, [
        $p['title'],
        $p['presenterName'],
        $p['date'],
        $p['place']
    ]);
}

rewind($tempCsv);

// Създаваме ZIP архив в текущата директория
$zip = new ZipArchive();
$zipName = 'presentations.zip';

if ($zip->open($zipName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    exit("Не може да се създаде ZIP архива");
}

// Добавяме CSV файла към архива с име presentations.csv
$csvContents = stream_get_contents($tempCsv);
$zip->addFromString('presentations.csv', $csvContents);

$zip->close();
fclose($tempCsv);

// Изпращаме ZIP файла на клиента
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipName . '"');
header('Content-Length: ' . filesize($zipName));

readfile($zipName);

// Изтриваме временния ZIP файл след изтегляне
unlink($zipName);

exit;
?>