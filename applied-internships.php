<?php

session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ---------- GET APPLIED INTERNSHIPS ---------- */

$query = mysqli_query($conn,"
SELECT

i.id AS internship_id,
i.title,
i.location,
i.mode,
i.duration,
i.stipend,

c.company_name,
d.domain_name,

a.id AS application_id,
a.applied_at,
a.status

FROM applications a

INNER JOIN internships i
ON a.internship_id = i.id

LEFT JOIN companies c
ON i.company_id = c.id

LEFT JOIN domains d
ON i.domain_id = d.id

WHERE a.user_id='$user_id'

ORDER BY a.applied_at DESC
");

$applications = array();

while($row = mysqli_fetch_assoc($query))
{
    $applications[] = $row;
}

include("includes/header.php");
include("includes/navbar.php");
?>

<link rel="stylesheet" href="assets/css/style.css">

<section class="applications-section">
    <div class="container">
        <h2>My Applications</h2>

        <?php if(count($applications) > 0) { ?>
            <div class="applications-list">
                <?php foreach($applications as $application) { ?>
                    <div class="application-card">
                        <div class="app-left">
                            <h3><?= htmlspecialchars($application['title']); ?></h3>
                            <p class="company"><?= htmlspecialchars($application['company_name']); ?></p>
                            <p class="location">
                                <i class="fa-solid fa-location-dot"></i>
                                <?= htmlspecialchars($application['location']); ?>
                            </p>
                        </div>
                        <div class="app-middle">
                            <p class="applied-date">
                                Applied on: <?= date('M d, Y', strtotime($application['applied_at'])); ?>
                            </p>
                            <div class="status <?= strtolower($application['status']); ?>">
    <?= htmlspecialchars(ucfirst($application['status'])); ?>
</div>
                        </div>
                        <div class="app-right">
                            <a href="internship-details.php?id=<?= $application['internship_id']; ?>" class="btn-primary">View Details</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="empty-state">
                <i class="fa-solid fa-file-circle-check"></i>
                <p>You haven't applied to any internships yet.</p>
                <a href="internships.php" class="btn-primary">Browse Internships</a>
            </div>
        <?php } ?>
    </div>
</section>

<?php include("includes/footer.php"); ?>
