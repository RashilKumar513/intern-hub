<?php

$pageTitle = "Manage Internships";

include("includes/auth_check.php");

/** @var mysqli $conn */

/* ---------- ADD INTERNSHIP ---------- */

if(isset($_POST['add_internship']))
{
    $company_id = (int)$_POST['company_id'];
    $domain_id = (int)$_POST['domain_id'];

    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $duration = mysqli_real_escape_string($conn,$_POST['duration']);
    $mode = mysqli_real_escape_string($conn,$_POST['mode']);
    $stipend = mysqli_real_escape_string($conn,$_POST['stipend']);
    $location = mysqli_real_escape_string($conn,$_POST['location']);
    $skills = mysqli_real_escape_string($conn,$_POST['skills_required']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $apply_link = mysqli_real_escape_string($conn,$_POST['apply_link']);

    mysqli_query($conn,"
        INSERT INTO internships
        (
            company_id,
            domain_id,
            title,
            duration,
            mode,
            stipend,
            location,
            skills_required,
            description,
            apply_link
        )
        VALUES
        (
            '$company_id',
            '$domain_id',
            '$title',
            '$duration',
            '$mode',
            '$stipend',
            '$location',
            '$skills',
            '$description',
            '$apply_link'
        )
    ");

    header("Location: internships.php");
    exit();
}

/* ---------- DELETE INTERNSHIP ---------- */

if(isset($_GET['delete']))
{
    $id = (int)$_GET['delete'];

    mysqli_query($conn,"DELETE FROM internships WHERE id=$id");

    header("Location: internships.php");
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>

<title>Manage Internships</title>

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

<div class="form-box">

<h2>Add Internship</h2>

<form method="POST">

<label>Company</label>

<select name="company_id" required>

<option value="">Select Company</option>

<?php

$companies = mysqli_query($conn,"SELECT * FROM companies ORDER BY company_name");

while($company = mysqli_fetch_assoc($companies))
{
?>

<option value="<?= $company['id']; ?>">

<?= htmlspecialchars($company['company_name']); ?>

</option>

<?php } ?>

</select>

<br><br>

<label>Domain</label>

<select name="domain_id" required>

<option value="">Select Domain</option>

<?php

$domains = mysqli_query($conn,"SELECT * FROM domains ORDER BY domain_name");

while($domain = mysqli_fetch_assoc($domains))
{
?>

<option value="<?= $domain['id']; ?>">

<?= htmlspecialchars($domain['domain_name']); ?>

</option>

<?php } ?>

</select>

<br><br>

<input
type="text"
name="title"
placeholder="Internship Title"
required>

<input
type="text"
name="duration"
placeholder="Duration">

<select name="mode">

<option value="Remote">Remote</option>

<option value="Onsite">Onsite</option>

<option value="Hybrid">Hybrid</option>

</select>

<input
type="text"
name="stipend"
placeholder="Stipend">

<input
type="text"
name="location"
placeholder="Location">

<textarea
name="skills_required"
placeholder="Skills Required"></textarea>

<textarea
name="description"
placeholder="Description"></textarea>

<input
type="url"
name="apply_link"
placeholder="Apply Link">

<button
type="submit"
name="add_internship">

Add Internship

</button>

</form>

</div>
</div>

<div class="table-box">

<h2 style="margin-bottom:20px;">Internship List</h2>

<table>

<tr>
    <th>ID</th>
    <th>Company</th>
    <th>Domain</th>
    <th>Title</th>
    <th>Mode</th>
    <th>Stipend</th>
    <th>Action</th>
</tr>

<?php

$query = mysqli_query($conn,"
SELECT internships.*,
companies.company_name,
domains.domain_name
FROM internships
INNER JOIN companies
ON internships.company_id = companies.id
INNER JOIN domains
ON internships.domain_id = domains.id
ORDER BY internships.id ASC
");

while($row = mysqli_fetch_assoc($query))
{

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= htmlspecialchars($row['company_name']); ?></td>

<td><?= htmlspecialchars($row['domain_name']); ?></td>

<td><?= htmlspecialchars($row['title']); ?></td>

<td><?= htmlspecialchars($row['mode']); ?></td>

<td><?= htmlspecialchars($row['stipend']); ?></td>

<td>

<a
style="color:red;"
href="?delete=<?= $row['id']; ?>"
onclick="return confirm('Delete this internship?')">

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

</div>

</body>

</html>