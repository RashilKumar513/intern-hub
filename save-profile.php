<?php
session_start();

include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$phone = mysqli_real_escape_string($conn,$_POST['phone']);
$dob = mysqli_real_escape_string($conn,$_POST['dob']);
$gender = mysqli_real_escape_string($conn,$_POST['gender']);
$address = mysqli_real_escape_string($conn,$_POST['address']);
$city = mysqli_real_escape_string($conn,$_POST['city']);
$state = mysqli_real_escape_string($conn,$_POST['state']);
$college = mysqli_real_escape_string($conn,$_POST['college']);
$degree = mysqli_real_escape_string($conn,$_POST['degree']);
$branch = mysqli_real_escape_string($conn,$_POST['branch']);
$passing_year = mysqli_real_escape_string($conn,$_POST['passing_year']);
$cgpa = mysqli_real_escape_string($conn,$_POST['cgpa']);
$skills = mysqli_real_escape_string($conn,$_POST['skills']);
$linkedin = mysqli_real_escape_string($conn,$_POST['linkedin']);
$github = mysqli_real_escape_string($conn,$_POST['github']);
$bio = mysqli_real_escape_string($conn,$_POST['bio']);

/* Resume Upload */

$resume = "";

if(isset($_FILES['resume']) && $_FILES['resume']['error']==0)
{
    $resume = time()."_".$_FILES['resume']['name'];

    move_uploaded_file(
        $_FILES['resume']['tmp_name'],
        "uploads/resumes/".$resume
    );
}

/* Profile Photo Upload */

$photo = "";

if(isset($_FILES['photo']) && $_FILES['photo']['error']==0)
{
    $photo = time()."_".$_FILES['photo']['name'];

    move_uploaded_file(
        $_FILES['photo']['tmp_name'],
        "uploads/profiles/".$photo
    );
}

/* Save */

mysqli_query($conn,"
INSERT INTO user_profiles
(
user_id,
phone,
dob,
gender,
address,
city,
state,
college,
degree,
branch,
passing_year,
cgpa,
skills,
resume,
photo,
linkedin,
github,
bio,
profile_completed
)

VALUES
(
'$user_id',
'$phone',
'$dob',
'$gender',
'$address',
'$city',
'$state',
'$college',
'$degree',
'$branch',
'$passing_year',
'$cgpa',
'$skills',
'$resume',
'$photo',
'$linkedin',
'$github',
'$bio',
1
)
");

header("Location: dashboard.php");

exit();

?>