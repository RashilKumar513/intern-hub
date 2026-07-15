<?php

include("includes/auth_check.php");

$id = (int)$_GET['id'];
/** @var mysqli $conn */
$status = mysqli_real_escape_string($conn,$_GET['status']);

mysqli_query($conn,"
UPDATE applications
SET status='$status'
WHERE id='$id'
");

header("Location:applications.php");
exit();

?>