<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../config/db.php';

/** @var mysqli $conn */

$userCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM users"))['total'];

$domainCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM domains"))['total'];

$companyCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM companies"))['total'];

$internshipCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM internships"))['total'];

$applicationCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM applications"))['total'];

$savedCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM saved_internships"))['total'];

$messageCount = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM contact_messages"))['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="wrapper">

    <?php include("includes/sidebar.php"); ?>

    <div class="main">

        <?php include("includes/topbar.php"); ?>

        <div class="page">

            <div class="cards">

                <div class="card">
                    <i class="fa-solid fa-users"></i>
                    <h2><?= $userCount; ?></h2>
                    <p>Total Users</p>
                </div>

                <div class="card">
                    <i class="fa-solid fa-layer-group"></i>
                    <h2><?= $domainCount; ?></h2>
                    <p>Domains</p>
                </div>

                <div class="card">
                    <i class="fa-solid fa-building"></i>
                    <h2><?= $companyCount; ?></h2>
                    <p>Companies</p>
                </div>

                <div class="card">
                    <i class="fa-solid fa-briefcase"></i>
                    <h2><?= $internshipCount; ?></h2>
                    <p>Internships</p>
                </div>

                <div class="card">
                    <i class="fa-solid fa-file-circle-check"></i>
                    <h2><?= $applicationCount; ?></h2>
                    <p>Applications</p>
                </div>

                <div class="card">
                    <i class="fa-solid fa-heart"></i>
                    <h2><?= $savedCount; ?></h2>
                    <p>Saved Internships</p>
                </div>

                <div class="card">
                    <i class="fa-solid fa-envelope"></i>
                    <h2><?= $messageCount; ?></h2>
                    <p>Contact Messages</p>
                </div>

            </div>

            <div class="table-box">

                <h2 style="margin-bottom:20px;">
                    Recent Users
                </h2>

                <table>

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Role</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $result = mysqli_query($conn,"
                    SELECT *
                    FROM users
                    ORDER BY id DESC
                    LIMIT 5
                    ");

                    while($row = mysqli_fetch_assoc($result))
                    {

                    ?>

                    <tr>

                        <td><?= $row['id']; ?></td>

                        <td><?= htmlspecialchars($row['full_name']); ?></td>

                        <td><?= htmlspecialchars($row['email']); ?></td>

                        <td><?= ucfirst(htmlspecialchars($row['role'])); ?></td>

                    </tr>

                    <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>