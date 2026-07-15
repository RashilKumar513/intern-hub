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

/* ======================================================
   GET USER + PROFILE DETAILS
====================================================== */

$sql = "
SELECT

u.id,
u.full_name,
u.username,
u.email,

p.phone,
p.dob,
p.gender,
p.preferred_domain,
p.college,
p.degree,
p.department,
p.semester,
p.cgpa,
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

/* ======================================================
   PROFILE IMAGE
====================================================== */

$photo="assets/images/default-user.png";

if(!empty($user['profile_image']))
{
    $photo="uploads/profiles/".$user['profile_image'];
}

include("includes/header.php");
include("includes/navbar.php");

?>

<link rel="stylesheet" href="assets/css/profile-view.css">

<section class="profile-page">

<div class="profile-card">

<!-- ===========================================
LEFT PANEL
=========================================== -->

<div class="profile-left">

<img
src="<?= htmlspecialchars($photo); ?>"
class="profile-image"
id="previewImage">

<h2>

<?= htmlspecialchars($user['full_name']); ?>

</h2>

<p>

<?= htmlspecialchars($user['email']); ?>

</p>

</div>

<!-- ===========================================
RIGHT PANEL
=========================================== -->

<div class="profile-right">

<h2>Edit Profile</h2>

<form
action="update-profile.php"
method="POST"
enctype="multipart/form-data">

<div class="info-grid">

<!-- FULL NAME -->

<div>

<label>Full Name</label>

<input
type="text"
value="<?= htmlspecialchars($user['full_name']); ?>"
readonly>

</div>

<!-- USERNAME -->

<div>

<label>Username</label>

<input
type="text"
value="<?= htmlspecialchars($user['username']); ?>"
readonly>

</div>

<!-- EMAIL -->

<div>

<label>Email Address</label>

<input
type="email"
value="<?= htmlspecialchars($user['email']); ?>"
readonly>

</div>

<!-- PHONE -->

<div>

<label>Phone Number</label>

<input
type="text"
name="phone"
value="<?= htmlspecialchars($user['phone'] ?? ''); ?>">

</div>

<!-- DOB -->

<div>

<label>Date of Birth</label>

<input
type="date"
name="dob"
value="<?= htmlspecialchars($user['dob'] ?? ''); ?>">

</div>

<!-- GENDER -->

<div>

<label>Gender</label>

<select name="gender">

<option value="">Select Gender</option>

<option value="Male"
<?= (($user['gender'] ?? '')=="Male") ? "selected" : ""; ?>>
Male
</option>

<option value="Female"
<?= (($user['gender'] ?? '')=="Female") ? "selected" : ""; ?>>
Female
</option>

<option value="Other"
<?= (($user['gender'] ?? '')=="Other") ? "selected" : ""; ?>>
Other
</option>

</select>

</div>

<!-- PREFERRED DOMAIN -->

<div>

<label>Preferred Domain</label>

<input
type="text"
name="preferred_domain"
value="<?= htmlspecialchars($user['preferred_domain'] ?? ''); ?>">

</div>

<!-- COLLEGE -->

<div>

<label>College</label>

<input
type="text"
name="college"
value="<?= htmlspecialchars($user['college'] ?? ''); ?>">

</div>
<!-- DEGREE -->

<div>

<label>Degree</label>

<input
type="text"
name="degree"
value="<?= htmlspecialchars($user['degree'] ?? ''); ?>">

</div>

<!-- DEPARTMENT -->

<div>

<label>Department</label>

<input
type="text"
name="department"
value="<?= htmlspecialchars($user['department'] ?? ''); ?>">

</div>

<!-- SEMESTER -->

<div>

<label>Semester</label>

<input
type="text"
name="semester"
value="<?= htmlspecialchars($user['semester'] ?? ''); ?>">

</div>

<!-- CGPA -->

<div>

<label>CGPA</label>

<input
type="text"
name="cgpa"
value="<?= htmlspecialchars($user['cgpa'] ?? ''); ?>">

</div>

</div>

<!-- ===========================
ABOUT ME
=========================== -->

<h3 style="margin-top:30px;">About Me</h3>

<textarea
name="bio"
rows="6"><?= htmlspecialchars($user['bio'] ?? ''); ?></textarea>

<!-- ===========================
RESUME
=========================== -->

<h3 style="margin-top:30px;">Resume</h3>

<input
type="file"
name="resume"
accept=".pdf,.doc,.docx">

<?php if(!empty($user['resume'])){ ?>

<p style="margin-top:12px;">

Current Resume :

<a
href="uploads/resumes/<?= htmlspecialchars($user['resume']); ?>"
target="_blank">

View Resume

</a>

</p>

<?php } ?>

<!-- ===========================
PROFILE PHOTO
=========================== -->

<h3 style="margin-top:30px;">Profile Photo</h3>

<input
type="file"
name="photo"
accept="image/*"
id="photoInput">

<br><br>

<button
type="submit"
class="edit-btn">

<i class="fa-solid fa-floppy-disk"></i>

Save Changes

</button>

</form>

</div>

</div>

</section>

<script>

const photoInput = document.getElementById("photoInput");

if(photoInput)
{
    photoInput.addEventListener("change", function(e){

        const file = e.target.files[0];

        if(file)
        {
            document.getElementById("previewImage").src =
            URL.createObjectURL(file);
        }

    });
}

</script>

<?php include("includes/footer.php"); ?>