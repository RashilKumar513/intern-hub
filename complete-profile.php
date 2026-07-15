<?php
session_start();

include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$message = "";

$query = mysqli_query($conn,"
SELECT *
FROM user_profiles
WHERE user_id='$user_id'
");

if(mysqli_num_rows($query) > 0)
{
    $profile = mysqli_fetch_assoc($query);

    if($profile['profile_completed'] == 1)
    {
        header("Location: dashboard.php");
        exit();
    }
}

include("includes/header.php");
include("includes/navbar.php");
?>

<link rel="stylesheet" href="assets/css/register.css">

<section class="register-page">

<div class="register-container">

<div class="left-side">

<div class="logo-circle">

<i class="fa-solid fa-id-card"></i>

</div>

<h1>Intern Hub</h1>

<h2>Complete Your Profile</h2>

<p>

Complete your profile to unlock internship applications and personalized recommendations.

</p>

<img
src="assets/images/hero.png"
alt="Profile">

</div>

<div class="right-side">

<h2>Profile Details</h2>

<p class="subtitle">

Complete your information below.

</p>

<h2>Complete Your Profile</h2>

<p>

Complete your profile to apply for internships.

</p>

<form
method="POST"
action="save-profile.php"
enctype="multipart/form-data">

<div class="input-group">
    <i class="fa-solid fa-phone"></i>
    <input
    type="text"
    name="phone"
    placeholder="Phone Number"
    required>
</div>

<div class="input-group">
    <i class="fa-solid fa-calendar-days"></i>
    <input
    type="date"
    name="dob"
    required>
</div>

<div class="input-group">
    <i class="fa-solid fa-venus-mars"></i>

    <select name="gender" required>

        <option value="">Select Gender</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>

    </select>

</div>

<hr>

<h3 class="form-title">Education Details</h3>

<div class="input-group">

<i class="fa-solid fa-building-columns"></i>

<input
type="text"
name="college"
placeholder="College Name"
required>

</div>

<div class="input-group">

<i class="fa-solid fa-graduation-cap"></i>

<input
type="text"
name="degree"
placeholder="Degree"
required>

</div>

<div class="input-group">

<i class="fa-solid fa-code-branch"></i>

<input
type="text"
name="department"
placeholder="Department"
required>

</div>

<div class="input-group">

<i class="fa-solid fa-layer-group"></i>

<input
type="text"
name="semester"
placeholder="Semester"
required>

</div>

<div class="input-group">

<i class="fa-solid fa-percent"></i>

<input
type="text"
name="cgpa"
placeholder="CGPA / Percentage"
required>

</div>

<hr>

<h3 class="form-title">Career Details</h3>

<div class="input-group">

<i class="fa-solid fa-briefcase"></i>

<select name="preferred_domain" required>

<option value="">Preferred Domain</option>

<option>Web Development</option>

<option>Python Development</option>

<option>Java Development</option>

<option>Data Analytics</option>

<option>Artificial Intelligence</option>

<option>Machine Learning</option>

<option>UI / UX Design</option>

<option>Digital Marketing</option>

<option>Finance</option>

<option>Human Resources</option>

</select>

</div>

<div class="input-group">

<i class="fa-solid fa-user"></i>

<textarea
name="bio"
placeholder="Tell us about yourself..."
required></textarea>

</div>

<hr>

<h3 class="form-title">Upload Documents</h3>

<label>Resume (PDF)</label>

<input
type="file"
name="resume"
accept=".pdf"
required>

<br><br>

<label>Profile Photo</label>

<input
type="file"
name="profile_image"
accept="image/*"
required>

<br><br>

<button
type="submit"
class="btn-primary">

Save Profile

</button>

</form>

</div>

</div>

</section>

<?php include("includes/footer.php"); ?>