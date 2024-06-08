<?php
header('Content-Type: application/json');

$group = isset($_GET['group']) ? $_GET['group'] : 'free';
$messages = json_decode(file_get_contents('./rolling_messages.json'), true);

if (isset($messages[$group])) {
    echo json_encode($messages[$group]);
} else {
    echo json_encode([]);
}
?>
