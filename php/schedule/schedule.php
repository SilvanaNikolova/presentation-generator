<?php
require_once __DIR__ . '/../repository/presentation.php';

$presentationRepo = new Presentation();
$presentations = $presentationRepo->getAllPresentations();

$html = file_get_contents(__DIR__ . '/../../schedule.html');

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

$html = str_replace('{{presentations}}', $presentationHtml, $html);

echo $html;