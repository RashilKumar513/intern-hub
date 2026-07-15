<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include_once __DIR__ . "/../config/db.php";

/* ---------------- ADD DOMAIN ---------------- */

if(isset($_POST['add']))
{
    $name=mysqli_real_escape_string($conn,$_POST['domain_name']);
    $description=mysqli_real_escape_string($conn,$_POST['description']);

    mysqli_query($conn,"INSERT INTO domains(domain_name,description)
    VALUES('$name','$description')");

    header("Location: domains.php");
    exit();
}

/* ---------------- DELETE DOMAIN ---------------- */

if(isset($_GET['delete']))
{
    $id=(int)$_GET['delete'];

    mysqli_query($conn,"DELETE FROM domains WHERE id=$id");

    header("Location: domains.php");
    exit();
}
/* ---------------- EDIT DOMAIN ---------------- */

if(isset($_POST['update']))
{
    $id=(int)$_POST['id'];

    $name=mysqli_real_escape_string($conn,$_POST['domain_name']);

    $description=mysqli_real_escape_string($conn,$_POST['description']);

    mysqli_query($conn,"
        UPDATE domains
        SET
        domain_name='$name',
        description='$description'
        WHERE id=$id
    ");

    header("Location: domains.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Domains</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

.page{

padding:35px;

}

.page-top{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

}

.add-btn{

background:#2563EB;
color:white;

padding:12px 22px;

border:none;

border-radius:10px;

cursor:pointer;

font-size:15px;

}

.form-box{

background:white;

padding:25px;

border-radius:18px;

margin-bottom:25px;

box-shadow:0 10px 25px rgba(0,0,0,.08);

}

.form-box input,
.form-box textarea{

width:100%;

padding:14px;

margin:10px 0;

border:1px solid #ddd;

border-radius:10px;

outline:none;

}

.form-box button{

background:#2563EB;
color:white;

padding:14px 25px;

border:none;

border-radius:10px;

cursor:pointer;

}

table{

width:100%;

background:white;

border-collapse:collapse;

box-shadow:0 10px 25px rgba(0,0,0,.08);

}

th{

background:#2563EB;
color:white;

padding:15px;

}

td{

padding:15px;

border-bottom:1px solid #eee;

}

.action a{

padding:8px 14px;

border-radius:8px;

text-decoration:none;

color:white;

margin-right:8px;

}

.delete{

background:#ef4444;

}

</style>

</head>

<body>

<div class="wrapper">

<!-- Sidebar -->

<div class="sidebar">

<h2>Intern Hub</h2>

<ul>

<li><a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a></li>

<li><a href="domains.php"><i class="fa-solid fa-layer-group"></i> Domains</a></li>

<li><a href="#"><i class="fa-solid fa-building"></i> Companies</a></li>

<li><a href="#"><i class="fa-solid fa-briefcase"></i> Internships</a></li>

<li><a href="#"><i class="fa-solid fa-users"></i> Users</a></li>

<li><a href="../auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>

</ul>

</div>

<div class="main">

<div class="topbar">

<h1>Manage Domains</h1>

</div>

<div class="page">

<div class="form-box">

<form method="POST">

<input
type="text"
name="domain_name"
placeholder="Domain Name"
required>

<textarea
name="description"
placeholder="Description"
rows="4"
required></textarea>

<button
name="add">

Add Domain

</button>

</form>

</div>

<table>

<tr>

<th>ID</th>

<th>Domain</th>

<th>Description</th>

<th>Action</th>

</tr>

<?php

$result=mysqli_query($conn,"SELECT * FROM domains ORDER BY id DESC");

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= $row['domain_name']; ?></td>

<td><?= $row['description']; ?></td>

<td class="action">

<a
style="background:#2563EB;"
href="edit-domain.php?id=<?= $row['id']; ?>">

Edit

</a>

<a
class="delete"
href="?delete=<?= $row['id']; ?>"
onclick="return confirm('Delete this domain?')">

Delete

</a>

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

</div>

</body>

</html>