<?php

session_start();

/* Remove only USER session */

unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['role']);
unset($_SESSION['otp_email']);
unset($_SESSION['otp_user_id']);

/* Redirect to user login */

header("Location: login.php");
exit();

?>