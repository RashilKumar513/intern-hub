<?php

session_start();
include("config/db.php");

$success = "";
$error = "";

if(isset($_POST['send']))
{
    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $subject = mysqli_real_escape_string($conn,$_POST['subject']);
    $message = mysqli_real_escape_string($conn,$_POST['message']);

    $insert = mysqli_query($conn,"
        INSERT INTO contact_messages
        (name,email,subject,message)
        VALUES
        ('$name','$email','$subject','$message')
    ");

    if($insert)
    {
        $success="Your message has been sent successfully.";
    }
    else
    {
        $error=mysqli_error($conn);
    }
}

include("includes/header.php");
include("includes/navbar.php");

?>

<section class="register-page">

<div class="register-box">

<h2>Contact Us</h2>

<?php if($success!=""){ ?>

<div class="success-message">
<?= $success; ?>
</div>

<?php } ?>

<?php if($error!=""){ ?>

<div class="error-message">
<?= $error; ?>
</div>

<?php } ?>

<form method="POST">

<input
type="text"
name="name"
placeholder="Your Name"
required>

<input
type="email"
name="email"
placeholder="Email Address"
required>

<input
type="text"
name="subject"
placeholder="Subject"
required>

<textarea
name="message"
rows="6"
placeholder="Write your message..."
required></textarea>

<button
type="submit"
name="send"
class="btn-primary">

Send Message

</button>

</form>

</div>

</section>

<?php include("includes/footer.php"); ?>

<?php include("includes/footer.php"); ?>