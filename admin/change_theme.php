<?php
session_start();

if (isset($_POST['theme'])) {
    $theme = $_POST['theme'];
    $_SESSION['theme'] = $theme;

    // Set a cookie to store the theme for 30 days
    // setcookie('theme', $theme, time() + (30 * 24 * 60 * 60), "/"); // 30 days

    setcookie('theme', $theme, time() + (10 * 365 * 24 * 60 * 60), "/"); // 10 tahun
}

// Use JavaScript to go back to the previous page
echo "<script>window.history.go(-1);</script>";
exit();
