<?php
include 'config/db.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- HERO SECTION -->

<section class="hero">

<div class="container hero-container">

<div class="hero-left">

<div class="hero-badge">

<i class="fa-solid fa-circle-check"></i>

Trusted Internship Platform

</div>

<h1>

Launch Your Career

With The Perfect

<span>Internship</span>

</h1>

<p>

Find internships from Internshala, Unstop, LinkedIn and official company career pages.

Complete your profile and receive internship recommendations based on your skills.

</p>

<div class="hero-buttons">

<a href="internships.php" class="btn-primary">

Explore Internships

</a>

<a href="about.php" class="btn-secondary">

Learn More

</a>

</div>

</div>

<div class="hero-right">

<img src="assets/images/hero.png">

<div class="hero-card card1">

<i class="fa-solid fa-briefcase"></i>

<h3>1500+</h3>

<p>Internships</p>

</div>

<div class="hero-card card2">

<i class="fa-solid fa-building"></i>

<h3>250+</h3>

<p>Companies</p>

</div>

<div class="hero-card card3">

<i class="fa-solid fa-chart-line"></i>

<h3>Trending</h3>

<p>Skills</p>

</div>

</div>

</div>

</section>

<!-- STATS -->

<section class="stats">

<div class="container stats-container">

<div class="stat-box">

<i class="fa-solid fa-briefcase"></i>

<h2>1500+</h2>

<p>Internships</p>

</div>

<div class="stat-box">

<i class="fa-solid fa-building"></i>

<h2>250+</h2>

<p>Companies</p>

</div>

<div class="stat-box">

<i class="fa-solid fa-layer-group"></i>

<h2>15+</h2>

<p>Domains</p>

</div>

<div class="stat-box">

<i class="fa-solid fa-user-graduate"></i>

<h2>5000+</h2>

<p>Students</p>

</div>

</div>

</section>
<!-- ================= POPULAR DOMAINS ================= -->

<section class="domains">

    <div class="container">

        <div class="section-title">

            <h2>Popular Domains</h2>

            <p>
                Explore internships across different career domains.
            </p>

        </div>

        <div class="domain-grid">

            <div class="domain-card">
                <i class="fa-solid fa-laptop-code"></i>
                <h3>Technology</h3>
                <p>Web Development, Java, Python, AI</p>
                <a href="internships.php?domain=1">
    Explore
    <i class="fa-solid fa-arrow-right"></i>
</a>
            </div>

            <div class="domain-card">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Marketing</h3>
                <p>SEO, Digital Marketing, Social Media</p>
                <a href="internships.php?domain=3">
    Explore
    <i class="fa-solid fa-arrow-right"></i>
</a>
            </div>

            <div class="domain-card">
                <i class="fa-solid fa-briefcase"></i>
                <h3>Management</h3>
                <p>HR, Operations, Business Analyst</p>
                <a href="internships.php?domain=5">
    Explore
    <i class="fa-solid fa-arrow-right"></i>
</a>
            </div>

            <div class="domain-card">
                <i class="fa-solid fa-palette"></i>
                <h3>Design</h3>
                <p>UI/UX, Graphic Design, Branding</p>
                <a href="internships.php?domain=6">
    Explore
    <i class="fa-solid fa-arrow-right"></i>
</a>
            </div>

            <div class="domain-card">
                <i class="fa-solid fa-coins"></i>
                <h3>Finance</h3>
                <p>Accounting, Banking, Investment</p>
                <a href="internships.php?domain=4">
    Explore
    <i class="fa-solid fa-arrow-right"></i>
</a>
            </div>

            <div class="domain-card">
                <i class="fa-solid fa-chart-column"></i>
                <h3>Data Analytics</h3>
                <p>Python, SQL, Power BI, Excel</p>
                <a href="internships.php?domain=2">
    Explore
    <i class="fa-solid fa-arrow-right"></i>
</a>
            </div>

        </div>

    </div>

</section>
<!-- ===========================
     Latest Internships
=========================== -->

<!-- ===========================
     Latest Internships
=========================== -->

<section class="latest-internships">

    <div class="container">

        <div class="section-title">
            <h2>Latest Internships</h2>
            <p>Explore the latest internship opportunities.</p>
        </div>

        <div class="internship-grid">

<?php

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn,$_GET['search']) : "";

$domain = isset($_GET['domain']) ? (int)$_GET['domain'] : 0;

$company = isset($_GET['company']) ? (int)$_GET['company'] : 0;

$mode = isset($_GET['mode']) ? mysqli_real_escape_string($conn,$_GET['mode']) : "";

$sql = "
SELECT internships.*,
       companies.company_name,
       domains.domain_name
FROM internships
INNER JOIN companies
ON internships.company_id = companies.id
INNER JOIN domains
ON internships.domain_id = domains.id
WHERE 1=1
";

if($search != "")
{
    $sql .= " AND (
        internships.title LIKE '%$search%'
        OR companies.company_name LIKE '%$search%'
        OR domains.domain_name LIKE '%$search%'
        OR internships.location LIKE '%$search%'
    )";
}

if($domain > 0)
{
    $sql .= " AND internships.domain_id = $domain";
}
if($company > 0)
{
    $sql .= " AND internships.company_id = $company";
}

if($mode != "")
{
    $sql .= " AND internships.mode = '$mode'";
}

$sql .= " ORDER BY internships.id DESC LIMIT 6";

$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) > 0)
{
    while($row = mysqli_fetch_assoc($query))
    {
?>

            <div class="internship-card">

                <h3><?= htmlspecialchars($row['title']); ?></h3>

                <p>
                    <i class="fa-solid fa-building"></i>
                    <?= htmlspecialchars($row['company_name']); ?>
                </p>

                <p>
                    <i class="fa-solid fa-layer-group"></i>
                    <?= htmlspecialchars($row['domain_name']); ?>
                </p>

                <p>
                    <i class="fa-solid fa-location-dot"></i>
                    <?= htmlspecialchars($row['location']); ?>
                </p>

                <p>
                    <i class="fa-solid fa-laptop-house"></i>
                    <?= htmlspecialchars($row['mode']); ?>
                </p>

                <p>
                    <i class="fa-solid fa-clock"></i>
                    <?= htmlspecialchars($row['duration']); ?>
                </p>

                <p>
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                    <?= htmlspecialchars($row['stipend']); ?>
                </p>

                <a href="internship-details.php?id=<?= $row['id']; ?>" class="apply-btn">
                    View Details
                </a>

            </div>

<?php
    }
}
else
{
?>

            <div style="grid-column:1/-1;text-align:center;padding:50px;">
                <h2>No internships found 😔</h2>
                <p>Try searching with another keyword.</p>
            </div>

<?php
}
?>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>