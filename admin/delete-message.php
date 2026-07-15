<?php

session_start();

if(!isset($_SESSION['admin']))
{
    header("Location:login.php");
    exit();
}

require_once("../config/db.php");
/** @var mysqli $conn */
$id = (int)$_GET['id'];

mysqli_query($conn,"
DELETE FROM contact_messages
WHERE id='$id'
");

header("Location:contact.php");
exit();

?>