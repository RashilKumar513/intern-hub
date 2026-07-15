<?php
include("config/db.php");

$message = "";

if(isset($_POST['register']))
{
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $username  = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    if(empty($full_name) || empty($username) || empty($email) || empty($password))
{
    $message = "Please fill all fields.";
}
elseif($password != $confirm)
{
    $message = "Passwords do not match.";
}
elseif(strlen($password) < 8)
{
    $message = "Password must be at least 8 characters.";
}
elseif(!preg_match('/[A-Z]/', $password))
{
    $message = "Password must contain at least one uppercase letter.";
}
elseif(!preg_match('/[a-z]/', $password))
{
    $message = "Password must contain at least one lowercase letter.";
}
elseif(!preg_match('/[0-9]/', $password))
{
    $message = "Password must contain at least one number.";
}
elseif(!preg_match('/[\W_]/', $password))
{
    $message = "Password must contain at least one special character.";
}

    else
    {
        $check = mysqli_query($conn,"
        SELECT id
        FROM users
        WHERE email='$email'
        OR username='$username'
        ");

        if(mysqli_num_rows($check) > 0)
        {
            $message = "Email or Username already exists.";
        }
        else
        {
            $password = password_hash($password,PASSWORD_DEFAULT);

            mysqli_query($conn,"
            INSERT INTO users
            (
                full_name,
                username,
                email,
                password,
                role,
                is_verified
            )
            VALUES
            (
                '$full_name',
                '$username',
                '$email',
                '$password',
                'user',
                1
            )
            ");

            header("Location: login.php");
            exit();
        }
    }
}


?>

<?php include("includes/header.php"); ?>
<?php include("includes/navbar.php"); ?>

<link rel="stylesheet" href="assets/css/register.css">

<section class="register-page">

<div class="register-container">

<div class="left-side">

<div class="logo-circle">

<i class="fa-solid fa-graduation-cap"></i>

</div>

<h1>Intern Hub</h1>

<h2>Create Your Account</h2>

<p>

Join Intern Hub and discover internship opportunities from top companies.

</p>

<img
src="assets/images/hero.png"
alt="Intern Hub">

</div>

<div class="right-side">

<h2>Create Account</h2>

<p class="subtitle">

Fill your details to get started.

</p>

<?php if($message!=""){ ?>

<div class="alert">

<?= $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="input-group">

<i class="fa-solid fa-user"></i>

<input
type="text"
name="full_name"
placeholder="Full Name"
required>

</div>

<div class="input-group">

<i class="fa-solid fa-user-tag"></i>

<input
type="text"
name="username"
placeholder="Username"
required>

</div>

<div class="input-group">

<i class="fa-solid fa-envelope"></i>

<input
type="email"
name="email"
placeholder="Email Address"
required>

</div>

<div class="input-group password-box">

<i class="fa-solid fa-lock"></i>

<input
type="password"
name="password"
id="password"
placeholder="Password"
required>

<span
class="toggle-password"
onclick="togglePassword('password',this)">

<i class="fa-solid fa-eye"></i>

</span>

</div>

<div class="input-group password-box">

<i class="fa-solid fa-lock"></i>

<input
type="password"
name="confirm_password"
id="confirm"
placeholder="Confirm Password"
required>

<span
class="toggle-password"
onclick="togglePassword('confirm',this)">

<i class="fa-solid fa-eye"></i>

</span>

</div>

<label class="checkbox">

<input type="checkbox" required>

I agree to the Terms & Conditions

</label>

<button
type="submit"
name="register">

Create Account

</button>

</form>

<div class="login-link">

Already have an account?

<a href="login.php">

Login

</a>

</div>

</div>

</div>

</section>

<script src="assets/js/register.js"></script>

<?php include("includes/footer.php"); ?>