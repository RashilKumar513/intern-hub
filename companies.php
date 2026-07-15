<?php
include 'config/db.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<link rel="stylesheet" href="assets/css/companies.css">

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <h1>Our Partner Companies</h1>
        <p>Explore internship opportunities from top companies across India</p>
    </div>
</section>

<!-- COMPANIES SECTION -->
<section class="companies-section">
    <div class="container">
        
        <div class="section-title">
            <h2>Featured Companies</h2>
            <p>These companies are actively hiring for internship positions</p>
        </div>

        <div class="companies-grid">
            <?php
            $query = mysqli_query($conn, "
                SELECT c.*, COUNT(i.id) as internship_count
                FROM companies c
                LEFT JOIN internships i ON c.id = i.company_id
                GROUP BY c.id
                ORDER BY internship_count DESC
                LIMIT 12
            ");

            while($company = mysqli_fetch_assoc($query)) {
            ?>
                <div class="company-card">
                    <div class="company-logo">
                        <img src="<?= !empty($company['logo']) ? htmlspecialchars($company['logo']) : 'assets/images/default-company.png'; ?>" 
                             alt="<?= htmlspecialchars($company['company_name']); ?>">
                    </div>
                    <div class="company-info">
                        <h3><?= htmlspecialchars($company['company_name']); ?></h3>
                        <p class="company-location">
                            <i class="fa-solid fa-location-dot"></i>
                            <?= htmlspecialchars($company['location'] ?? 'India'); ?>
                        </p>
                        <p class="company-description">
                            <?= htmlspecialchars(substr($company['description'] ?? '', 0, 100)); ?>...
                        </p>
                        <div class="company-stats">
                            <span class="stat">
                                <i class="fa-solid fa-briefcase"></i>
                                <?= $company['internship_count']; ?> Internships
                            </span>
                        </div>
                        <a href="internships.php?company=<?= $company['id']; ?>" class="btn-primary">
                            View Internships
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</section>

<!-- ALL COMPANIES SECTION -->
<section class="all-companies-section">
    <div class="container">
        <div class="section-title">
            <h2>All Companies</h2>
            <p>Browse all companies offering internships</p>
        </div>

        <div class="companies-list">
            <?php
            $all_companies = mysqli_query($conn, "
                SELECT * FROM companies
                ORDER BY company_name ASC
            ");

            while($comp = mysqli_fetch_assoc($all_companies)) {
            ?>
                <div class="company-list-item">
                    <div class="logo-small">
                        <img src="<?= !empty($comp['logo']) ? htmlspecialchars($comp['logo']) : 'assets/images/default-company.png'; ?>" 
                             alt="<?= htmlspecialchars($comp['company_name']); ?>">
                    </div>
                    <div class="company-details">
                        <h4><?= htmlspecialchars($comp['company_name']); ?></h4>
                        <p><?= htmlspecialchars($comp['location'] ?? 'India'); ?></p>
                    </div>
                    <a href="internships.php?company=<?= $comp['id']; ?>" class="btn-outline">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
