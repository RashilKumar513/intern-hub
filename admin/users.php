<?php

session_start();

require_once("../config/db.php");

/** @var mysqli $conn */

if(!isset($_SESSION['admin']))
{
    header("Location:login.php");
    exit();
}

$pageTitle = "Users";
$query = mysqli_query($conn,"
SELECT
    users.id,
    users.full_name,
    users.username,
    users.email,
    users.role,
    users.created_at,
    user_profiles.phone,
    user_profiles.profile_completed
FROM users
LEFT JOIN user_profiles
ON users.id = user_profiles.user_id
ORDER BY users.id DESC
");
?>

<!DOCTYPE html>

<html>

<head>

<title>Users</title>

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

<h2>Registered Users</h2>

<div class="table-box">

<table>

<thead>

<tr>

<th>ID</th>

<th>Name</th>

<th>Username</th>

<th>Email</th>

<th>Phone</th>

<th>Role</th>

<th>Profile</th>

<th>Joined</th>

<th>Action</th>

</tr>

</thead>

<tbody>
<?php

while($row=mysqli_fetch_assoc($query))
{

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= htmlspecialchars($row['full_name']); ?></td>

<td><?= htmlspecialchars($row['username']); ?></td>

<td><?= htmlspecialchars($row['email']); ?></td>

<td><?= !empty($row['phone']) ? htmlspecialchars($row['phone']) : "Not Added"; ?></td>

<td>

<?php

if($row['role']=="admin")
{
    echo "<span style='color:#2563eb;font-weight:bold;'>Admin</span>";
}
else
{
    echo "<span>User</span>";
}

?>

</td>

<td>

<?php

if($row['profile_completed']==1)
{
    echo "<span style='color:green;font-weight:bold;'>Completed</span>";
}
else
{
    echo "<span style='color:red;font-weight:bold;'>Incomplete</span>";
}

?>

</td>

<td>

<?= date("d M Y",strtotime($row['created_at'])); ?>

</td>

<td>

<a
href="delete-user.php?id=<?= $row['id']; ?>"
style="color:red;"
onclick="return confirm('Delete this user?');">

Delete

</a>

</td>

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

</html>