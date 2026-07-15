<?php

session_start();

require_once("config/db.php");
require_once("config/mail.php");

$message = "";

if(isset($_POST['login']))
{

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    if(empty($email) || empty($password))
    {
        $message = "Please enter your email and password.";
    }
    else
    {

        $query = mysqli_query($conn,"
        SELECT *
        FROM users
        WHERE email='$email'
        LIMIT 1
        ");

        if(mysqli_num_rows($query)==1)
        {

            $user = mysqli_fetch_assoc($query);

            /* PASSWORD CHECK */

            if(password_verify($password,$user['password']))
            {

                /* ADMIN LOGIN */

                if($user['role']=="admin")
                {

                    $_SESSION['admin']=$user['full_name'];
                    $_SESSION['admin_id']=$user['id'];

                    header("Location: admin/dashboard.php");
                    exit();

                }

                /* USER LOGIN */

                $otp = rand(100000,999999);

                $expires_at = date(
                    "Y-m-d H:i:s",
                    strtotime("+10 minutes")
                );

                mysqli_query($conn,"
                DELETE FROM otp_codes
                WHERE user_id=".$user['id']);

                $insert = mysqli_query($conn,"
                INSERT INTO otp_codes
                (user_id,otp,expires_at)
                VALUES
                (
                ".$user['id'].",
                '$otp',
                '$expires_at'
                )
                ");

                if($insert)
                {

                    $subject = "Intern Hub - Login OTP";

                    $body = "

                    <html>

                    <head>

                    <style>

                    body{
                    font-family:Poppins,sans-serif;
                    background:#f5f7fb;
                    }

                    .box{

                    max-width:600px;

                    margin:auto;

                    background:white;

                    border-radius:12px;

                    overflow:hidden;

                    }

                    .header{

                    background:#2563EB;

                    color:white;

                    padding:25px;

                    text-align:center;

                    }

                    .content{

                    padding:35px;

                    }

                    .otp{

                    font-size:40px;

                    letter-spacing:6px;

                    color:#2563EB;

                    font-weight:bold;

                    text-align:center;

                    padding:25px;

                    background:#EEF4FF;

                    border-radius:10px;

                    margin:25px 0;

                    }

                    </style>

                    </head>

                    <body>

                    <div class='box'>

                    <div class='header'>

                    <h2>Intern Hub</h2>

                    </div>

                    <div class='content'>

                    <h3>Hello ".htmlspecialchars($user['full_name']).",</h3>

                    <p>

                    Your OTP for login is

                    </p>

                    <div class='otp'>

                    $otp

                    </div>

                    <p>

                    This OTP will expire in

                    <strong>10 minutes</strong>.

                    </p>

                    <p>

                    If you didn't request this login,

                    please ignore this email.

                    </p>

                    </div>

                    </div>

                    </body>

                    </html>

                    ";

                    if(sendMail(
                        $email,
                        $user['full_name'],
                        $subject,
                        $body
                    ))
                    {

                        $_SESSION['otp_email']=$email;

                        $_SESSION['otp_user_id']=$user['id'];

                        header("Location: verify-otp.php");
                        exit();

                    }
                    else
                    {

                        $message="Unable to send OTP email.";

                    }

                }
                else
                {

                    $message="Unable to generate OTP.";

                }

            }
            else
            {

                $message="Invalid Email or Password.";

            }

        }
        else
        {

            $message="Invalid Email or Password.";

        }

    }

}

?>

<?php
include("includes/header.php");
include("includes/navbar.php");
?>

<link rel="stylesheet" href="assets/css/register.css">

<style>

.divider{

display:flex;

align-items:center;

margin:25px 0;

}

.divider::before,
.divider::after{

content:"";

flex:1;

height:1px;

background:#ddd;

}

.divider span{

padding:0 15px;

color:#777;

font-weight:600;

}

.admin-login-btn{

display:block;

width:100%;

text-align:center;

padding:14px;

margin-top:20px;

background:#1E3A8A;

color:#fff;

text-decoration:none;

border-radius:10px;

font-size:16px;

font-weight:600;

transition:.3s;

}

.admin-login-btn:hover{

background:#163172;

}

</style>

<section class="register-page">

<div class="register-container">

<div class="left-side">

<div class="logo-circle">

<i class="fa-solid fa-user-lock"></i>

</div>

<h1>Intern Hub</h1>

<h2>Welcome Back</h2>

<p>

Login securely using your Email, Password and OTP.

</p>

<img src="assets/images/hero.png">

</div>

<div class="right-side">

<h2>User Login</h2>

<p class="subtitle">

Enter your Email and Password

</p>

<?php if($message!=""){ ?>

<div class="alert"

style="background:#fee;
color:#c33;
padding:12px;
border-radius:8px;
margin-bottom:20px;">

<?= $message ?>

</div>

<?php } ?>

<form method="POST">

<div class="input-group">

<i class="fa-solid fa-envelope"></i>

<input
type="email"
name="email"
placeholder="Enter your Email"
required>

</div>

<div class="input-group">

<i class="fa-solid fa-lock"></i>

<input
type="password"
name="password"
placeholder="Enter your Password"
required>

</div>

<button

type="submit"

name="login"

class="btn-primary"

style="width:100%;
padding:14px;
border:none;
border-radius:10px;
background:#2563EB;
color:#fff;
font-size:16px;
font-weight:600;
cursor:pointer;">

Login

</button>

</form>

<div class="divider">

<span>OR</span>

</div>

<a
href="admin/login.php"
class="admin-login-btn">

<i class="fa-solid fa-user-shield"></i>

Admin Login

</a>

<div class="login-link"

style="text-align:center;
margin-top:25px;">

Don't have an account?

<a
href="register.php"
style="color:#2563EB;
font-weight:600;
text-decoration:none;">

Register

</a>

</div>

</div>

</div>

</section>

<script src="assets/js/register.js"></script>

<?php include("includes/footer.php"); ?>