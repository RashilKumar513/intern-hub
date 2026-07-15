<?php
include 'config/db.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<link rel="stylesheet" href="assets/css/internships.css">

<!-- PAGE HEADER -->
<section class="page-header">
    <div class="container">
        <h1>Internship Opportunities</h1>
        <p>Find your perfect internship match</p>
    </div>
</section>

<!-- FILTER SECTION -->
<section class="filter-section">
    <div class="container">
        <form method="GET" action="internships.php" class="filter-form">
            <div class="filter-group">
                <label>Search</label>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search internships..." 
                    value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>"
                    class="filter-input">
            </div>

            <div class="filter-group">
                <label>Domain</label>
                <select name="domain" class="filter-select">
                    <option value="">All Domains</option>
                    <?php
                    $domain_result = mysqli_query($conn, "SELECT * FROM domains ORDER BY domain_name");
                    if($domain_result) {
                        while($d = mysqli_fetch_assoc($domain_result)) {
                        ?>
                            <option value="<?= $d['id']; ?>" 
                                <?= (isset($_GET['domain']) && $_GET['domain'] == $d['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($d['domain_name']); ?>
                            </option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Company</label>
                <select name="company" class="filter-select">
                    <option value="">All Companies</option>
                    <?php
                    $company_result = mysqli_query($conn, "SELECT * FROM companies ORDER BY company_name");
                    if($company_result) {
                        while($c = mysqli_fetch_assoc($company_result)) {
                        ?>
                            <option value="<?= $c['id']; ?>"
                                <?= (isset($_GET['company']) && $_GET['company'] == $c['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($c['company_name']); ?>
                            </option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Mode</label>
                <select name="mode" class="filter-select">
                    <option value="">All Modes</option>
                    <option value="Remote" <?= (isset($_GET['mode']) && $_GET['mode'] == 'Remote') ? 'selected' : ''; ?>>Remote</option>
                    <option value="Hybrid" <?= (isset($_GET['mode']) && $_GET['mode'] == 'Hybrid') ? 'selected' : ''; ?>>Hybrid</option>
                    <option value="Onsite" <?= (isset($_GET['mode']) && $_GET['mode'] == 'Onsite') ? 'selected' : ''; ?>>Onsite</option>
                </select>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
        </form>
    </div>
</section>

<!-- INTERNSHIPS LISTING -->
<section class="internships-section">
    <div class="container">
        <?php
        // Build query based on filters
        $where_clauses = array();
        
        if(isset($_GET['search']) && !empty($_GET['search'])) {
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $where_clauses[] = "(i.title LIKE '%$search%' OR i.description LIKE '%$search%' OR c.company_name LIKE '%$search%')";
        }
        
        if(isset($_GET['domain']) && !empty($_GET['domain'])) {
            $domain = mysqli_real_escape_string($conn, $_GET['domain']);
            $where_clauses[] = "i.domain_id = '$domain'";
        }
        
        if(isset($_GET['company']) && !empty($_GET['company'])) {
            $company = mysqli_real_escape_string($conn, $_GET['company']);
            $where_clauses[] = "i.company_id = '$company'";
        }
        
        if(isset($_GET['mode']) && !empty($_GET['mode'])) {
            $mode = mysqli_real_escape_string($conn, $_GET['mode']);
            $where_clauses[] = "i.mode = '$mode'";
        }
        
        $where = count($where_clauses) > 0 ? "WHERE " . implode(" AND ", $where_clauses) : "";
        
        // Get total internships
        $total_query = mysqli_query($conn, "
            SELECT COUNT(*) as count
            FROM internships i
            LEFT JOIN companies c ON i.company_id = c.id
            LEFT JOIN domains d ON i.domain_id = d.id
            $where
        ");
        
        if(!$total_query) {
            $total = 0;
        } else {
            $total_result = mysqli_fetch_assoc($total_query);
            $total = $total_result ? $total_result['count'] : 0;
        }
        
        // Get internships - Show all available if no filters match
        $query=mysqli_query($conn,"
SELECT
i.*,
c.company_name,
c.logo,
d.domain_name
FROM internships i

INNER JOIN companies c
ON i.company_id=c.id

INNER JOIN domains d
ON i.domain_id=d.id

$where

ORDER BY i.id DESC
");
        
        if(!$query) {
            $total = 0;
            $query = false;
        }
        
        if($total > 0 && $query) {
        ?>
            <div class="results-info">
                <p>Showing <strong><?= min(100, $total); ?></strong> of <strong><?= $total; ?></strong> internships</p>
            </div>

            <div class="internships-list">
                <?php
                while($row = mysqli_fetch_assoc($query)) {
                ?>
                    <div class="internship-item">
                        <div class="internship-left">
                            <?php if(!empty($row['logo'])): ?>
                                <div style="margin-bottom: 15px;">
                                    <img src="<?= htmlspecialchars($row['logo']); ?>" alt="Company Logo" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                                </div>
                            <?php endif; ?>
                            <h3><?= htmlspecialchars($row['title']); ?></h3>
                            <p class="company-name">
                                <i class="fa-solid fa-building"></i>
                                <?= htmlspecialchars($row['company_name']); ?>
                            </p>
                            <p class="internship-description">
                                <?= htmlspecialchars(substr($row['description'] ?? "",0,150)); ?>...
                            </p>
                            <div class="internship-tags">
                                <span class="tag location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <?= htmlspecialchars($row['location']); ?>
                                </span>
                                <span class="tag mode">
                                    <i class="fa-solid fa-laptop"></i>
                                    <?= htmlspecialchars($row['mode']); ?>
                                </span>
                                <span class="tag domain">
                                    <i class="fa-solid fa-tag"></i>
                                    <?= htmlspecialchars($row['domain_name']); ?>
                                </span>
                            </div>
                        </div>

                        <div class="internship-right">
                            <div class="internship-stipend">
                                <i class="fa-solid fa-indian-rupee-sign"></i>
                                <span><?= htmlspecialchars($row['stipend']); ?>/month</span>
                            </div>
                            <div class="internship-duration">
                                <i class="fa-solid fa-calendar"></i>
                                <span><?= htmlspecialchars($row['duration']); ?></span>
                            </div>
                            <div class="internship-actions">
                                <a href="internship-details.php?id=<?= $row['id']; ?>" class="btn-primary">
                                    View Details
                                </a>
                                <a href="save-internship.php?id=<?= $row['id']; ?>" class="btn-outline">
                                    <i class="fa-solid fa-heart"></i>
                                    Save
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <div class="empty-state">
                <i class="fa-solid fa-briefcase"></i>
                <h3>No Internships Found</h3>
                <p>Try adjusting your search filters</p>
                <a href="internships.php" class="btn-primary">Clear Filters</a>
            </div>
        <?php
        }
        ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>