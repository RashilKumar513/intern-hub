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

$user_id = $_SESSION['user_id'];

/* ==========================================
   GET USER + PROFILE
========================================== */

$sql = "
SELECT

u.full_name,
u.username,
u.email,

p.phone,
p.dob,
p.gender,
p.college,
p.degree,
p.department,
p.semester,
p.cgpa,
p.preferred_domain,
p.bio,
p.resume,
p.profile_image

FROM users u

LEFT JOIN user_profiles p
ON u.id = p.user_id

WHERE u.id='$user_id'

LIMIT 1
";

$result = mysqli_query($conn,$sql);

if(!$result)
{
    die(mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

if(!$user)
{
    die("User not found.");
}

/* ==========================================
   PROFILE PHOTO
========================================== */

$photo = "assets/images/default-user.png";

if(!empty($user['profile_image']))
{
    $photo = "uploads/profiles/".$user['profile_image'];
}

/* ==========================================
   PROFILE COMPLETION
========================================== */

$fields = array(

$user['phone'],
$user['dob'],
$user['gender'],
$user['college'],
$user['degree'],
$user['department'],
$user['semester'],
$user['cgpa'],
$user['preferred_domain'],
$user['bio'],
$user['resume'],
$user['profile_image']

);

$filled = 0;

foreach($fields as $field)
{
    if(!empty(trim((string)$field)))
    {
        $filled++;
    }
}

$percent = round(($filled/count($fields))*100);

include("includes/header.php");
include("includes/navbar.php");

?>

<link rel="stylesheet" href="assets/css/profile-view.css">

<?php if(isset($_GET['updated'])){ ?>

<div class="success-message">

<i class="fa-solid fa-circle-check"></i>

Profile Updated Successfully

</div>

<?php } ?>

<section class="profile-page">

<div class="profile-card">

<!-- ===========================
LEFT SIDE
=========================== -->

<div class="profile-left">

<img
src="<?= htmlspecialchars($photo); ?>"
class="profile-image"
alt="Profile">

<h2>

<?= htmlspecialchars($user['full_name']); ?>

</h2>

<p>

<?= htmlspecialchars($user['email']); ?>

</p>

<div class="progress-box">

<div class="progress-title">

<span>Profile Completion</span>

<span><?= $percent ?>%</span>

</div>

<div class="progress">

<div
class="progress-bar"
style="width:<?= $percent ?>%;">

</div>

</div>

</div>

<a
href="edit-profile.php"
class="edit-btn">

<i class="fa-solid fa-user-pen"></i>

Edit Profile

</a>

</div>

<!-- ===========================
RIGHT SIDE
=========================== -->

<div class="profile-right">

<h3>Personal Information</h3>

<div class="info-grid">

<div>

<label>Phone Number</label>

<p>

<?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : "Not Added"; ?>

</p>

</div>

<div>

<label>Gender</label>

<p>

<?= !empty($user['gender']) ? htmlspecialchars($user['gender']) : "Not Added"; ?>

</p>

</div>

<div>

<label>Date of Birth</label>

<p>

<?= !empty($user['dob']) ? htmlspecialchars($user['dob']) : "Not Added"; ?>

</p>

</div>

<div>

<label>Preferred Domain</label>

<p>

<?= !empty($user['preferred_domain']) ? htmlspecialchars($user['preferred_domain']) : "Not Added"; ?>

</p>

</div>

</div>

<h3>Education</h3>

<div class="info-grid">

<div>

<label>College</label>

<p>

<?= !empty($user['college']) ? htmlspecialchars($user['college']) : "Not Added"; ?>

</p>

</div>

<div>

<label>Degree</label>

<p>

<?= !empty($user['degree']) ? htmlspecialchars($user['degree']) : "Not Added"; ?>

</p>

</div>
<div>

<label>Department</label>

<p>

<?= !empty($user['department']) ? htmlspecialchars($user['department']) : "Not Added"; ?>

</p>

</div>

<div>

<label>Semester</label>

<p>

<?= !empty($user['semester']) ? htmlspecialchars($user['semester']) : "Not Added"; ?>

</p>

</div>

<div>

<label>CGPA</label>

<p>

<?= !empty($user['cgpa']) ? htmlspecialchars($user['cgpa']) : "Not Added"; ?>

</p>

</div>

</div>

<!-- ===========================
ABOUT ME
=========================== -->

<h3>About Me</h3>

<div class="bio">

<?php

if(!empty($user['bio']))
{
    echo nl2br(htmlspecialchars($user['bio']));
}
else
{
    echo "No bio available.";
}

?>

</div>

<!-- ===========================
RESUME
=========================== -->

<?php if(!empty($user['resume'])){ ?>

<div class="resume-box">

<h3>Resume</h3>

<a
href="uploads/resumes/<?= htmlspecialchars($user['resume']); ?>"
target="_blank">

<i class="fa-solid fa-file-arrow-down"></i>

Download Resume

</a>

</div>

<?php } ?>

</div>

</div>

</section>

<?php include("includes/footer.php"); ?>