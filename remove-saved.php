<?php

session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

$id=(int)$_GET['id'];

mysqli_query($conn,"
DELETE FROM saved_internships
WHERE id='$id'
");

header("Location:saved-internships.php");
exit();

?>