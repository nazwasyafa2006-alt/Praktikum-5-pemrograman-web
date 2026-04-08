<?php
require_once 'start.php';

if (isset($_SESSION['username'])) {
    echo "Username: " . $_SESSION['username'] . "<br>";
    echo "Warna favorit: " . $_SESSION['favorite_color'];
} else {
    echo "Session belum diatur.";
}
?>