<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

include("includes/header.php");
include("includes/navbar.php");

?>
<?php

include("config/db.php");

$user_id = $_SESSION['user_id'];

$profileCompleted = false;

$q = mysqli_query($conn,"
SELECT profile_completed
FROM user_profiles
WHERE user_id='$user_id'
LIMIT 1
");

if($q && mysqli_num_rows($q)>0)
{
    $row = mysqli_fetch_assoc($q);

    if($row['profile_completed']==1)
    {
        $profileCompleted = true;
    }
}

?>

<style>

.dashboard-page{
    min-height:calc(100vh - 80px);
    display:flex;
    justify-content:center;
    align-items:center;
    background:#f4f7fc;
    padding:40px 20px;
}


.dashboard-card{
    width:100%;
    max-width:650px;
    background:#fff;
    border-radius:20px;
    padding:60px 40px;
    text-align:center;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
}

.dashboard-card h1{
    font-size:40px;
    color:#2563EB;
    margin-bottom:15px;
}

.dashboard-card h2{
    color:#1F2937;
    margin-bottom:30px;
}

.dashboard-card .emoji{
    font-size:60px;
    margin:20px 0;
}

</style>

<section class="dashboard-page">
    

<div class="dashboard-card">

<h1>

Welcome,

<?= htmlspecialchars($_SESSION['user_name']); ?> 👋

</h1>

<p>

Welcome to Intern Hub.

Explore internships and complete your profile whenever you're ready.

</p>

<div style="margin-top:35px;">

<a href="internships.php" class="btn-primary">

Browse Internships

</a>

</div>

</div>

</section>

<?php include("includes/footer.php"); ?>