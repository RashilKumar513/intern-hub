<?php

$pageTitle="Applications";



include("includes/auth_check.php");

/** @var mysqli $conn */
/* Fetch Applications */

$query=mysqli_query($conn,"
SELECT

applications.id,
applications.status,
applications.applied_at,

users.full_name,
users.email,

user_profiles.phone,
user_profiles.resume,

internships.title,

companies.company_name

FROM applications

INNER JOIN users
ON applications.user_id=users.id

LEFT JOIN user_profiles
ON users.id=user_profiles.user_id

INNER JOIN internships
ON applications.internship_id=internships.id

INNER JOIN companies
ON internships.company_id=companies.id

ORDER BY applications.applied_at DESC

");

?>

<!DOCTYPE html>

<html>

<head>

<title>Applications</title>

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

<h2 style="margin-bottom:25px;">

Internship Applications

</h2>

<table>

<tr>

<th>ID</th>

<th>Student</th>

<th>Email</th>

<th>Phone</th>

<th>Company</th>

<th>Internship</th>

<th>Resume</th>

<th>Status</th>

<th>Action</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($query))
{

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= htmlspecialchars($row['full_name']); ?></td>

<td><?= htmlspecialchars($row['email']); ?></td>

<td><?= htmlspecialchars($row['phone']); ?></td>

<td><?= htmlspecialchars($row['company_name']); ?></td>

<td><?= htmlspecialchars($row['title']); ?></td>

<td>

<?php

if(!empty($row['resume']))
{

?>

<a
href="../uploads/resumes/<?= htmlspecialchars($row['resume']); ?>"
target="_blank">

Download

</a>

<?php

}
else
{

echo "No Resume";

}

?>

</td>

<td>

<?php

$status = $row['status'];

$color = "#f59e0b";

if($status=="Reviewed")
{
    $color="#3b82f6";
}
elseif($status=="Shortlisted")
{
    $color="#10b981";
}
elseif($status=="Selected")
{
    $color="#16a34a";
}
elseif($status=="Rejected")
{
    $color="#ef4444";
}

?>

<span style="
background:<?= $color ?>;
color:#fff;
padding:8px 15px;
border-radius:20px;
font-weight:600;
display:inline-block;
">

<?= htmlspecialchars($status); ?>

</span>

</td>

<td>

<form action="update-status.php" method="GET">

<input
type="hidden"
name="id"
value="<?= $row['id']; ?>">

<select
name="status"
style="padding:8px;border-radius:6px;">

<option value="Pending" <?= $status=="Pending"?"selected":""; ?>>
Pending
</option>

<option value="Reviewed" <?= $status=="Reviewed"?"selected":""; ?>>
Reviewed
</option>

<option value="Shortlisted" <?= $status=="Shortlisted"?"selected":""; ?>>
Shortlisted
</option>

<option value="Selected" <?= $status=="Selected"?"selected":""; ?>>
Selected
</option>

<option value="Rejected" <?= $status=="Rejected"?"selected":""; ?>>
Rejected
</option>

</select>

<button
type="submit"
style="
margin-left:8px;
padding:8px 14px;
background:#2563eb;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
">

Update

</button>

</form>

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

</div>

</div>

</body>

</html>