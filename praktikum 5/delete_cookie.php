<?php
setcookie("user", "", time() - 3600, "/");
echo "Cookie telah dihapus.";
?>