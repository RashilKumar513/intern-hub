<?php
// This script fixes the admin password by hashing it properly
include("config/db.php");

$admin_password = "admin123";
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

$update_query = mysqli_query($conn, "
    UPDATE users 
    SET password = '$hashed_password' 
    WHERE email = 'admin@internhub.com' AND role = 'admin'
");

if($update_query) {
    echo "✅ Admin password has been updated successfully!";
    echo "<br>Email: admin@internhub.com";
    echo "<br>Password: admin123";
    echo "<br><a href='login.php'>Go to Login</a>";
} else {
    echo "❌ Error updating password: " . mysqli_error($conn);
}
?>
