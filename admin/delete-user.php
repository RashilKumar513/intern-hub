<?php

session_start();

require_once("../config/db.php");
/** @var mysqli $conn */

if(!isset($_SESSION['admin']))
{
    header("Location:login.php");
    exit();
}

if(!isset($_GET['id']))
{
    header("Location:users.php");
    exit();
}

$user_id = (int)$_GET['id'];

/* Prevent deleting the admin account */

$check = mysqli_query($conn,"
SELECT role
FROM users
WHERE id='$user_id'
LIMIT 1
");

if(mysqli_num_rows($check)==0)
{
    header("Location:users.php");
    exit();
}

$user = mysqli_fetch_assoc($check);

if($user['role']=="admin")
{
    echo "<script>
    alert('Admin account cannot be deleted.');
    window.location='users.php';
    </script>";
    exit();
}

/* Delete saved internships */

mysqli_query($conn,"
DELETE FROM saved_internships
WHERE user_id='$user_id'
");

/* Delete applications */

mysqli_query($conn,"
DELETE FROM applications
WHERE user_id='$user_id'
");

/* Delete user profile */

mysqli_query($conn,"
DELETE FROM user_profiles
WHERE user_id='$user_id'
");

/* Delete user */

mysqli_query($conn,"
DELETE FROM users
WHERE id='$user_id'
");

header("Location:users.php");
exit();

?>