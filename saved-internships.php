<?php

session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

$user_id=$_SESSION['user_id'];

$query = mysqli_query($conn,"
SELECT

saved_internships.id AS saved_id,

internships.*,

companies.company_name,

domains.domain_name

FROM saved_internships

INNER JOIN internships
ON saved_internships.internship_id = internships.id

INNER JOIN companies
ON internships.company_id = companies.id

INNER JOIN domains
ON internships.domain_id = domains.id

WHERE saved_internships.user_id='$user_id'

ORDER BY saved_internships.id DESC
");

if(!$query)
{
    die("SQL Error : ".mysqli_error($conn));
}

include("includes/header.php");
include("includes/navbar.php");
?>

<link rel="stylesheet" href="assets/css/internships.css">

<section class="internship-section">

<div class="container">

<div class="page-header">

<h1>Saved Internships ❤️</h1>

<p>Your favourite internships are listed here.</p>

</div>

<div class="internship-grid">

<?php

if(mysqli_num_rows($query)>0)
{

while($internship=mysqli_fetch_assoc($query))
{

?>

<div class="internship-card">

<div class="company-name">

<?= htmlspecialchars($internship['company_name']); ?>

</div>

<h2>

<?= htmlspecialchars($internship['title']); ?>

</h2>

<div class="domain">

<?= htmlspecialchars($internship['domain_name']); ?>

</div>

<div class="details">

<p>

<i class="fa-solid fa-location-dot"></i>

<?= htmlspecialchars($internship['location']); ?>

</p>

<p>

<i class="fa-solid fa-money-bill-wave"></i>

<?= htmlspecialchars($internship['stipend']); ?>

</p>

<p>

<i class="fa-solid fa-clock"></i>

<?= htmlspecialchars($internship['duration']); ?>

</p>

<p>

<i class="fa-solid fa-laptop"></i>

<?= htmlspecialchars($internship['mode']); ?>

</p>

</div>

<div class="skills">

<?= nl2br(htmlspecialchars($internship['skills_required'])); ?>

</div>

<div class="card-buttons">

<a
href="internship-details.php?id=<?= $internship['id']; ?>"
class="btn-view">

View Details

</a>

<a
href="<?= htmlspecialchars($internship['apply_link']); ?>"
target="_blank"
class="btn-apply">

Apply

</a>

<a
href="remove-saved.php?id=<?= $internship['saved_id']; ?>"
class="btn-save"
onclick="return confirm('Remove this internship from saved list?')">

Remove

</a>

</div>

</div>

<?php

}

}
else
{

?>

<div class="no-data">

<i class="fa-solid fa-heart-crack"></i>

<h2>No Saved Internships</h2>

<p>

Start saving internships to see them here.

</p>

</div>

<?php

}

?>

</div>

</div>

</section>

<?php include("includes/footer.php"); ?>