<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$internship_id = intval($_GET['id']);

$check = mysqli_query($conn,"
SELECT id
FROM saved_internships
WHERE user_id='$user_id'
AND internship_id='$internship_id'
");

if(mysqli_num_rows($check)==0)
{
    mysqli_query($conn,"
    INSERT INTO saved_internships
    (
        user_id,
        internship_id
    )
    VALUES
    (
        '$user_id',
        '$internship_id'
    )
    ");
}

header("Location:internships.php?saved=1");
exit();
?>