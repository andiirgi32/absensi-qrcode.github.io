<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'default';
?>
<link rel="stylesheet" href="styles/<?= $theme ?>.css">