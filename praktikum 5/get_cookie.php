<?php
if (isset($_COOKIE["user"])) {
    echo "Nilai cookie user: " . $_COOKIE["user"];
} else {
    echo "Cookie tidak ditemukan.";
}
?>