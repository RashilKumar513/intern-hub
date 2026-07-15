<?php

session_start();

include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

$user_id=$_SESSION['user_id'];

$internship_id=(int)$_GET['id'];

/* Check profile */

$profile=mysqli_query($conn,"
SELECT profile_completed
FROM user_profiles
WHERE user_id='$user_id'
LIMIT 1
");

if(mysqli_num_rows($profile)==0)
{
    header("Location:complete-profile.php");
    exit();
}

$p=mysqli_fetch_assoc($profile);

if($p['profile_completed']==0)
{
    header("Location:complete-profile.php");
    exit();
}

/* Already Applied */

$check=mysqli_query($conn,"
SELECT id
FROM applications
WHERE user_id='$user_id'
AND internship_id='$internship_id'
");

if(mysqli_num_rows($check)==0)
{
    mysqli_query($conn,"
    INSERT INTO applications
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

/* Get Original Apply Link */

$get=mysqli_query($conn,"
SELECT apply_link
FROM internships
WHERE id='$internship_id'
");

$data=mysqli_fetch_assoc($get);

/* Redirect */

header("Location:".$data['apply_link']);

exit();

?>