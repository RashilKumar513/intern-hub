<?php

if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}

require_once("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] != "POST")
{
    header("Location: edit-profile.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ==========================================
   FORM DATA
========================================== */

$phone = mysqli_real_escape_string($conn, trim($_POST['phone'] ?? ""));
$dob = mysqli_real_escape_string($conn, trim($_POST['dob'] ?? ""));
$gender = mysqli_real_escape_string($conn, trim($_POST['gender'] ?? ""));

$preferred_domain = mysqli_real_escape_string($conn, trim($_POST['preferred_domain'] ?? ""));

$college = mysqli_real_escape_string($conn, trim($_POST['college'] ?? ""));
$degree = mysqli_real_escape_string($conn, trim($_POST['degree'] ?? ""));
$department = mysqli_real_escape_string($conn, trim($_POST['department'] ?? ""));
$semester = mysqli_real_escape_string($conn, trim($_POST['semester'] ?? ""));
$cgpa = mysqli_real_escape_string($conn, trim($_POST['cgpa'] ?? ""));

$bio = mysqli_real_escape_string($conn, trim($_POST['bio'] ?? ""));

/* ==========================================
   GET OLD PROFILE
========================================== */

$profile_image = "";
$resume = "";

$oldQuery = mysqli_query($conn,"
SELECT profile_image,resume
FROM user_profiles
WHERE user_id='$user_id'
LIMIT 1
");

if($oldQuery && mysqli_num_rows($oldQuery)>0)
{
    $old = mysqli_fetch_assoc($oldQuery);

    $profile_image = $old['profile_image'] ?? "";
    $resume = $old['resume'] ?? "";
}

/* ==========================================
   PROFILE PHOTO
========================================== */

if(isset($_FILES['photo']) && $_FILES['photo']['error']==0)
{
    if(!is_dir("uploads/profiles"))
    {
        mkdir("uploads/profiles",0777,true);
    }

    $extension = strtolower(pathinfo($_FILES['photo']['name'],PATHINFO_EXTENSION));

    $profile_image = "profile_".$user_id."_".time().".".$extension;

    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "uploads/profiles/".$profile_image
    );
}

/* ==========================================
   RESUME
========================================== */

if(isset($_FILES['resume']) && $_FILES['resume']['error']==0)
{
    if(!is_dir("uploads/resumes"))
    {
        mkdir("uploads/resumes",0777,true);
    }

    $extension = strtolower(pathinfo($_FILES['resume']['name'],PATHINFO_EXTENSION));

    $resume = "resume_".$user_id."_".time().".".$extension;

    move_uploaded_file(
        $_FILES['resume']['tmp_name'],
        "uploads/resumes/".$resume
    );
}

/* ==========================================
   PROFILE EXISTS ?
========================================== */

$check = mysqli_query($conn,"
SELECT id
FROM user_profiles
WHERE user_id='$user_id'
LIMIT 1
");

if(mysqli_num_rows($check)>0)
{

    $update = mysqli_query($conn,"
    UPDATE user_profiles
    SET

    phone='$phone',
    dob='$dob',
    gender='$gender',

    preferred_domain='$preferred_domain',

    college='$college',
    degree='$degree',
    department='$department',
    semester='$semester',
    cgpa='$cgpa',

    bio='$bio',

    profile_image='$profile_image',

    resume='$resume',

    profile_completed='1'

    WHERE user_id='$user_id'
    ");

}
else
{

    $insert = mysqli_query($conn,"
    INSERT INTO user_profiles(

    user_id,

    phone,
    dob,
    gender,

    preferred_domain,

    college,
    degree,
    department,
    semester,
    cgpa,

    bio,

    profile_image,

    resume,

    profile_completed

    )

    VALUES(

    '$user_id',

    '$phone',
    '$dob',
    '$gender',

    '$preferred_domain',

    '$college',
    '$degree',
    '$department',
    '$semester',
    '$cgpa',

    '$bio',

    '$profile_image',

    '$resume',

    '1'

    )
    ");

}

/* ==========================================
   REDIRECT
========================================== */

header("Location: profile.php?updated=1");
exit();

?>