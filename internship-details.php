<?php

session_start();

include("config/db.php");

// Redirect to login if not authenticated
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Internship not found.");
}

$id = (int)$_GET['id'];

$query = mysqli_query($conn,"
SELECT internships.*,
       companies.company_name,
       companies.logo,
       domains.domain_name
FROM internships
LEFT JOIN companies
ON internships.company_id = companies.id
LEFT JOIN domains
ON internships.domain_id = domains.id
WHERE internships.id = $id
");

if(!$query || mysqli_num_rows($query) == 0){
    die("Internship not found.");
}

$row = mysqli_fetch_assoc($query);

?>

<?php include("includes/header.php"); ?>
<?php include("includes/navbar.php"); ?>

<section class="internship-details">

<div class="container">

<h1><?= htmlspecialchars($row['title']); ?></h1>

<h3 class="company-name">
    <i class="fa-solid fa-building"></i>
    <?= htmlspecialchars($row['company_name']); ?>
</h3>

<div class="details-grid">

<div class="detail-item">

<strong>📂 Domain</strong>

<p><?= htmlspecialchars($row['domain_name']); ?></p>

</div>

<div class="detail-item">

<strong>📍 Location</strong>

<p><?= htmlspecialchars($row['location']); ?></p>

</div>

<div class="detail-item">

<strong>🌐 Mode</strong>

<p><?= htmlspecialchars($row['mode']); ?></p>

</div>

<div class="detail-item">

<strong>⏳ Duration</strong>

<p><?= htmlspecialchars($row['duration']); ?></p>

</div>

<div class="detail-item">

<strong>💰 Stipend</strong>

<p><?= htmlspecialchars($row['stipend']); ?></p>

</div>

</div>

<h2>Skills Required</h2>

<div class="skills">

<?php

$skills = explode(",", $row['skills_required']);

foreach($skills as $skill)
{

?>

<span><?= trim($skill); ?></span>

<?php

}

?>

</div>

<h2>Description</h2>

<p>

<?= nl2br(htmlspecialchars($row['description'])); ?>

</p>

<div class="action-buttons">

<a
href="save-internship.php?id=<?= $row['id']; ?>"
class="save-btn">

<i class="fa-solid fa-heart"></i>

Save

</a>

<a
href="apply.php?id=<?= $row['id']; ?>"
class="apply-btn">

<i class="fa-solid fa-paper-plane"></i>

Apply Now

</a>

</div>

</div>

</section>

<?php include("includes/footer.php"); ?>