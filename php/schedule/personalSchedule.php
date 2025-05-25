<?php
session_start();
require_once __DIR__ . '/../repository/presentation.php';

$username = $_SESSION['username'] ?? null;
$type = $_GET['type'] ?? 'attending';

if (!$username) {
    die("Моля, влезте в системата, за да видите персоналното си разписание.");
}

$presentationRepo = new Presentation();
$presentations = $presentationRepo->getPresentationsByUserPreference($username, $type);

$html = file_get_contents(__DIR__ . '/../../personalSchedule.html');

if (empty($presentations)) {
    $presentationHtml = '<p>Няма презентации, които съответстват на избраните ви предпочитания.</p>';
} else {
    $presentationHtml = '';
    foreach ($presentations as $p) {
        $presentationHtml .= '
        <div class="presentation-block">
            <p><strong>Заглавие:</strong> ' . htmlspecialchars($p['title']) . '</p>
            <p><strong>Презентатор:</strong> ' . htmlspecialchars($p['presenterName']) . '</p>
            <p><strong>Дата:</strong> ' . htmlspecialchars($p['date']) . '</p>
            <p><strong>Място:</strong> ' . htmlspecialchars($p['place']) . '</p>
            <hr>
        </div>';
    }
}

$html = str_replace('{{presentations}}', $presentationHtml, $html);

echo $html;