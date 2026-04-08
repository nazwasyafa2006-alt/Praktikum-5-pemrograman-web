<?php
require_once 'start.php';

session_unset();
session_destroy();

echo "Session telah dihapus.";
?>