<?php
session_start();
session_destroy();
setcookie("PHPSESSID", "", time() - 3600, "/");
setcookie("user", "", time() - 3600, "/");
setcookie("pass", "", time() - 3600, "/");
header("Location: index.php");
?>