<?php
// SmartCare Lab 6: File Download
$file = 'dummy-data.txt';
$filepath = __DIR__ . '/' . $file;
if (file_exists($filepath)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$file.'"');
    header('Content-Length: ' . filesize($filepath));
    readfile($filepath);
    exit;
} else {
    echo "File not found.";
}
?>
