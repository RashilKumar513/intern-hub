<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
?>

<nav class="navbar">

<div class="container nav-container">

    <!-- Logo -->
    <a href="index.php" class="logo">
        <i class="fa-solid fa-briefcase"></i>
        <span>Intern Hub</span>
    </a>

    <!-- Navigation -->
    <ul class="nav-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="internships.php">Internships</a></li>
        <li><a href="companies.php">Companies</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>

    <!-- Right Side -->
    <div class="nav-buttons">

<?php
if(isset($_SESSION['user_id']))
{
    require_once("config/db.php");

    $photo = "assets/images/default-user.png";
    $email = "";

    $id = $_SESSION['user_id'];

    $q = mysqli_query($conn,"
    SELECT profile_image
    FROM user_profiles
    WHERE user_id='$id'
    LIMIT 1
    ");

    if($q && mysqli_num_rows($q)>0)
    {
        $p = mysqli_fetch_assoc($q);

        if(!empty($p['profile_image']))
        {
            $photo = "uploads/profiles/".$p['profile_image'];
        }
    }

    $userQuery = mysqli_query($conn,"
SELECT email
FROM users
WHERE id='$id'
LIMIT 1
");

if($userQuery && mysqli_num_rows($userQuery)>0)
{
    $navUser = mysqli_fetch_assoc($userQuery);
    $email = $navUser['email'];
}
?>

<div class="profile-dropdown">

    <button type="button" class="profile-btn" onclick="toggleProfileMenu(event)">
    <img src="<?= $photo; ?>" class="nav-profile-img">

    <span>
        <?= htmlspecialchars(explode(" ", $_SESSION['user_name'])[0]); ?>
    </span>

    <i class="fa-solid fa-chevron-down"></i>
</button>

    <div class="profile-menu" id="profileMenu">

        <div class="profile-header">
            <img src="<?= $photo ?>" class="profile-big">
            <h3><?= htmlspecialchars($_SESSION['user_name']); ?></h3>
        </div>

        <div class="profile-links">
            <a href="profile.php">
                <i class="fa-solid fa-user"></i>
                My Profile
            </a>

            <a href="edit-profile.php">
                <i class="fa-solid fa-user-pen"></i>
                Edit Profile
            </a>

            <a href="saved-internships.php">
                <i class="fa-solid fa-heart"></i>
                Saved Internships
            </a>

            <a href="applied-internships.php">
                <i class="fa-solid fa-file-circle-check"></i>
                My Applications
            </a>

            <a href="contact.php">
                <i class="fa-solid fa-envelope"></i>
                Contact Us
            </a>
        </div>

        <div style="border-top: 1px solid #eee; padding-top: 10px;">
            <a href="logout.php" class="logout-link" style="display: flex; align-items: center; gap: 12px; padding: 14px 20px;">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>
        </div>

    </div>

    </div>

</div>

<?php
}
else
{
?>

        <?php
$currentPage = basename($_SERVER['PHP_SELF']);

if($currentPage != "login.php")
{
?>
    <a href="login.php" class="btn-outline">Login</a>
<?php
}

if($currentPage != "register.php")
{
?>
    <a href="register.php" class="btn-primary">Register</a>
<?php
}
?>

<?php
}
?>

    </div>

</div>

</nav>