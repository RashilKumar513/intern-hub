<?php

session_start();

/* Remove only ADMIN session */

unset($_SESSION['admin']);

header("Location: login.php");
exit();

?>