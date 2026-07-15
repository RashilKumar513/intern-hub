<?php

$pageTitle = "Manage Companies";

include("includes/auth_check.php");
/** @var mysqli $conn */


/* ---------- ADD COMPANY ---------- */

if(isset($_POST['add_company']))
{
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $website = mysqli_real_escape_string($conn, $_POST['website']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $logo = "";

    // Handle logo upload
    if(!empty($_FILES['logo']['name'])) {
        $upload_dir = "../assets/uploads/company-logos/";
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_name = basename($_FILES['logo']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = array("jpg", "jpeg", "png", "gif");

        if(in_array($file_ext, $allowed_ext)) {
            $new_file_name = uniqid() . "." . $file_ext;
            $upload_path = $upload_dir . $new_file_name;

            if(move_uploaded_file($_FILES['logo']['tmp_name'], $upload_path)) {
                $logo = "assets/uploads/company-logos/" . $new_file_name;
            }
        }
    }

    mysqli_query($conn,"
        INSERT INTO companies
        (company_name, location, website, description, logo)
        VALUES
        ('$company_name','$location','$website','$description','$logo')
    ");

    header("Location: companies.php");
    exit();
}

/* ---------- DELETE COMPANY ---------- */

if(isset($_GET['delete']))
{
    $id = (int)$_GET['delete'];

    mysqli_query($conn,"DELETE FROM companies WHERE id=$id");

    header("Location: companies.php");
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>

<title>Manage Companies</title>

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

<h2>Add Company</h2>

<form method="POST" enctype="multipart/form-data">

<input type="text"
name="company_name"
placeholder="Company Name"
required>

<input type="text"
name="location"
placeholder="Location"
required>

<input type="url"
name="website"
placeholder="Website">

<textarea
name="description"
rows="4"
placeholder="Description"></textarea>

<div style="margin-bottom: 15px;">
    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Company Logo</label>
    <input type="file" 
           name="logo" 
           accept="image/*"
           style="padding: 10px; border: 1px solid #ddd; border-radius: 6px; width: 100%;">
    <small style="color: #666;">Supported formats: JPG, PNG, GIF</small>
</div>

<button
type="submit"
name="add_company">

Add Company

</button>

</form>

</div>

<div class="table-box">

<h2 style="margin-bottom:20px;">Company List</h2>

<table>

<tr>

<th>ID</th>

<th>Company</th>

<th>Location</th>

<th>Website</th>

<th>Action</th>

</tr>

<?php

$result=mysqli_query($conn,"SELECT * FROM companies ORDER BY id DESC");

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= htmlspecialchars($row['company_name']); ?></td>

<td><?= htmlspecialchars($row['location']); ?></td>

<td>

<?php
if(!empty($row['website']))
{
?>

<a href="<?= htmlspecialchars($row['website']); ?>"
target="_blank">

Visit

</a>

<?php
}
else
{
echo "-";
}
?>

</td>

<td>

<a
style="color:red;"
href="?delete=<?= $row['id']; ?>"
onclick="return confirm('Delete Company?')">

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