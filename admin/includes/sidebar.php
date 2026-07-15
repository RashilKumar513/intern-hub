<div class="sidebar">

    <h2>
        <i class="fa-solid fa-briefcase"></i>
        Intern Hub
    </h2>

    <ul>

        <li>
            <a href="dashboard.php" <?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'class="active"' : ''; ?>>
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="domains.php" <?= (basename($_SERVER['PHP_SELF']) == 'domains.php') ? 'class="active"' : ''; ?>>
                <i class="fa-solid fa-layer-group"></i>
                Domains
            </a>
        </li>

        <li>
            <a href="companies.php" <?= (basename($_SERVER['PHP_SELF']) == 'companies.php') ? 'class="active"' : ''; ?>>
                <i class="fa-solid fa-building"></i>
                Companies
            </a>
        </li>

        <li>
            <a href="internships.php" <?= (basename($_SERVER['PHP_SELF']) == 'internships.php') ? 'class="active"' : ''; ?>>
                <i class="fa-solid fa-briefcase"></i>
                Internships
            </a>
        </li>

        <li>
            <a href="applications.php" <?= (basename($_SERVER['PHP_SELF']) == 'applications.php') ? 'class="active"' : ''; ?>>
                <i class="fa-solid fa-file-circle-check"></i>
                Applications
            </a>
        </li>

        <li>
            <a href="users.php" <?= (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'class="active"' : ''; ?>>
                <i class="fa-solid fa-users"></i>
                Users
            </a>
        </li>

        <li>
            <a href="contact.php" <?= (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'class="active"' : ''; ?>>
                <i class="fa-solid fa-envelope"></i>
                Contact Messages
            </a>
        </li>

        <li>
            <a href="../logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>
        </li>

    </ul>

</div>