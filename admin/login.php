<?php
session_start();

$databaseConfig = __DIR__ . '/../config/db.php';
if (!file_exists($databaseConfig)) {
    die("Database configuration file not found.");
}

require_once $databaseConfig;

/** @var mysqli $conn */
if (!isset($conn) || !$conn) {
    die("Database connection failed.");
}

$error = "";

if(isset($_POST['login']))
{

    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    $query = mysqli_query($conn,"
    SELECT *
    FROM users
    WHERE username='$username'
    AND role='admin'
    LIMIT 1
    ");

    if(mysqli_num_rows($query)==1)
    {

        $admin = mysqli_fetch_assoc($query);

        if(password_verify($password, $admin['password']))
        {

            session_regenerate_id(true);

            $_SESSION['admin'] = $admin['username'];
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['role'] = "admin";

            header("Location: dashboard.php");
            exit();

        }
        else
        {

            $error = "Invalid Username or Password";

        }

    }
    else
    {

        $error = "Invalid Username or Password";

    }

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Login</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins,sans-serif;
}

body{

display:flex;
justify-content:center;
align-items:center;

height:100vh;

background:#f5f7fb;

}

.login-box{

width:420px;

background:white;

padding:40px;

border-radius:20px;

box-shadow:0 15px 35px rgba(0,0,0,.08);

}

.login-box h2{

text-align:center;

margin-bottom:30px;

color:#2563EB;

}

.input-box{

margin-bottom:20px;

}

.input-box input{

width:100%;

padding:14px;

border:1px solid #ddd;

border-radius:10px;

outline:none;

}

button{

width:100%;

padding:15px;

background:#2563EB;

color:white;

border:none;

border-radius:10px;

cursor:pointer;

font-size:16px;

}

button:hover{

background:#1d4ed8;

}

.error{

color:red;

text-align:center;

margin-bottom:20px;

}

</style>

</head>

<body>

<div class="login-box">

<h2>
<i class="fa-solid fa-user-shield"></i>
Admin Login
</h2>
<div style="margin-top:20px;text-align:center;">

<a href="../login.php"
style="text-decoration:none;color:#2563EB;font-weight:600;">

← Back to User Login

</a>

</div>

<?php

if($error!="")
{
echo "<div class='error'>$error</div>";
}

?>

<form method="POST">

<div class="input-box">

<input
type="text"
name="username"
placeholder="Username"
required>

</div>

<div class="input-box">

<input
type="password"
name="password"
placeholder="Password"
required>

</div>

<button
type="submit"
name="login">

Login

</button>

</form>

</div>

</body>

</html>