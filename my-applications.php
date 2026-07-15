<?php

session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

$user_id=$_SESSION['user_id'];

$query=mysqli_query($conn,"
SELECT

applications.id,

applications.applied_at,

applications.status,

internships.title,

internships.location,

internships.mode,

internships.duration,

internships.stipend,

companies.company_name,

domains.domain_name

FROM applications

INNER JOIN internships
ON applications.internship_id=internships.id

INNER JOIN companies
ON internships.company_id=companies.id

INNER JOIN domains
ON internships.domain_id=domains.id

WHERE applications.user_id='$user_id'

ORDER BY applications.applied_at DESC

");

include("includes/header.php");
include("includes/navbar.php");
?>

<link rel="stylesheet" href="assets/css/internships.css">

<section class="internship-section">

<div class="container">

<div class="page-header">

<h1>My Applications</h1>

<p>Track all your internship applications.</p>

</div>

<div class="internship-grid">

<?php

if(mysqli_num_rows($query)>0)
{

while($row=mysqli_fetch_assoc($query))
{

?>

<div class="internship-card">

<div class="company-name">

<?= htmlspecialchars($row['company_name']); ?>

</div>

<h2>

<?= htmlspecialchars($row['title']); ?>

</h2>

<div class="domain">

<?= htmlspecialchars($row['domain_name']); ?>

</div>

<div class="details">

<p>

<i class="fa-solid fa-location-dot"></i>

<?= htmlspecialchars($row['location']); ?>

</p>

<p>

<i class="fa-solid fa-money-bill-wave"></i>

<?= htmlspecialchars($row['stipend']); ?>

</p>

<p>

<i class="fa-solid fa-clock"></i>

<?= htmlspecialchars($row['duration']); ?>

</p>

<p>

<i class="fa-solid fa-laptop"></i>

<?= htmlspecialchars($row['mode']); ?>

</p>

</div>

<p style="margin:15px 0;">

<strong>Applied On:</strong>

<?= date("d M Y",strtotime($row['applied_at'])); ?>

</p>

<?php

$status=$row['status'];

$class="pending";

if($status=="Shortlisted")
{
    $class="shortlisted";
}
elseif($status=="Rejected")
{
    $class="rejected";
}

?>

<div class="status <?= $class; ?>">

<?= htmlspecialchars($status); ?>

</div>

</div>

<?php

}

}
else
{

?>

<div class="no-data">

<i class="fa-solid fa-file-circle-xmark"></i>

<h2>No Applications Yet</h2>

<p>

You haven't applied for any internships.

</p>

</div>

<?php

}

?>

</div>

</div>

</section>

<?php include("includes/footer.php"); ?>