<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

require_once("config/db.php");
require_once("config/mail.php");

$message = "";

if(!isset($_SESSION['otp_email']) || !isset($_SESSION['otp_user_id'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['otp_email'];
$user_id = $_SESSION['otp_user_id'];

if(isset($_POST['verify_otp'])) {
    $otp = mysqli_real_escape_string($conn, trim($_POST['otp']));
    
    if(empty($otp)) {
        $message = "Please enter the OTP.";
    } else {
        // Check OTP
        $query = mysqli_query($conn, "
            SELECT otp, expires_at
            FROM otp_codes
            WHERE user_id=$user_id AND otp='$otp'
            LIMIT 1
        ");
        
        if(mysqli_num_rows($query) > 0) {
            $otp_data = mysqli_fetch_assoc($query);
            
            // Check if OTP is expired
            if(strtotime($otp_data['expires_at']) < time()) {
                $message = "OTP has expired. Please request a new one.";
            } else {
                // OTP verified, set session and redirect
                $user_query = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id LIMIT 1");
                $user = mysqli_fetch_assoc($user_query);
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                
                // Delete used OTP
                mysqli_query($conn, "DELETE FROM otp_codes WHERE user_id=$user_id");
                
                // Clear OTP session
                unset($_SESSION['otp_email']);
                unset($_SESSION['otp_user_id']);
                
                // OTP is only for normal users

header("Location: dashboard.php");
exit();
            }
        } else {
            $message = "Invalid OTP. Please try again.";
        }
    }
}

// Resend OTP
if(isset($_POST['resend_otp'])) {
    $query = mysqli_query($conn, "SELECT full_name FROM users WHERE id=$user_id LIMIT 1");
    $user = mysqli_fetch_assoc($query);
    
    $otp = rand(100000, 999999);
    $expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));
    
    mysqli_query($conn, "DELETE FROM otp_codes WHERE user_id=$user_id");
    $insert = mysqli_query($conn, "
        INSERT INTO otp_codes (user_id, otp, expires_at)
        VALUES ($user_id, '$otp', '$expires_at')
    ");
    
    if($insert) {
        $to = $email;
        $subject = "Intern Hub - Your OTP Code (Resend)";
        $body = "
        <html>
        <head>
            <style>
                body { font-family: Poppins, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #2563EB; color: white; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
                .content { background: #f4f7fc; padding: 30px; border-radius: 0 0 10px 10px; }
                .otp-box { background: white; padding: 20px; border-radius: 10px; text-align: center; margin: 20px 0; }
                .otp-code { font-size: 40px; font-weight: bold; letter-spacing: 5px; color: #2563EB; font-family: monospace; }
                .footer { text-align: center; color: #666; font-size: 12px; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Intern Hub</h2>
                </div>
                <div class='content'>
                    <p>Hi " . htmlspecialchars($user['full_name']) . ",</p>
                    <p>Your new OTP code for Intern Hub login is:</p>
                    <div class='otp-box'>
                        <div class='otp-code'>$otp</div>
                    </div>
                    <p><strong>This code will expire in 10 minutes.</strong></p>
                    <p>If you didn't request this, please ignore this email.</p>
                    <div class='footer'>
                        <p>© 2026 Intern Hub. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
        
        
        
        if(sendMail($to, $user['full_name'], $subject, $body))
{
    $message = "✅ New OTP has been sent to your email!";
}
else
{
    $message = "❌ Failed to send OTP. Please try again.";
}
    }
}

include("includes/header.php");
include("includes/navbar.php");
?>

<link rel="stylesheet" href="assets/css/register.css">

<section class="register-page">
    <div class="register-container">
        <div class="left-side">
            <div class="logo-circle">
                <i class="fa-solid fa-key"></i>
            </div>
            <h1>Intern Hub</h1>
            <h2>Verify OTP</h2>
            <p>Enter the OTP sent to your email to complete login.</p>
            <img src="assets/images/hero.png">
        </div>

        <div class="right-side">
            <h2>Verify OTP</h2>
            <p class="subtitle">Email: <?= htmlspecialchars($email) ?></p>

            <?php if($message != ""){ 
                $alert_color = strpos($message, "✅") !== false ? "#efe" : "#fee";
                $text_color = strpos($message, "✅") !== false ? "#3a3" : "#c33";
            ?>
                <div class="alert" style="background: <?= $alert_color ?>; color: <?= $text_color ?>; padding: 12px; border-radius: 6px; margin-bottom: 15px;">
                    <?= $message ?>
                </div>
            <?php } ?>

            <form method="POST">
                <div class="input-group">
                    <i class="fa-solid fa-key"></i>
                    <input
                        type="text"
                        name="otp"
                        placeholder="Enter 6-digit OTP"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        required
                        style="letter-spacing: 5px; font-size: 18px; text-align: center; font-weight: bold;">
                </div>

                <button type="submit" name="verify_otp" class="btn-primary" style="width: 100%; padding: 12px; border: none; border-radius: 8px; background: #2563EB; color: white; font-size: 16px; font-weight: 600; cursor: pointer;">
                    Verify OTP
                </button>
            </form>

            <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
                <form method="POST" style="display: inline;">
                    <button type="submit" name="resend_otp" style="background: none; border: none; color: #2563EB; cursor: pointer; text-decoration: underline; font-weight: 600;">
                        Resend OTP
                    </button>
                </form>
                <span style="color: #999;"> | </span>
                <a href="login.php" style="color: #2563EB; text-decoration: none; font-weight: 600;">
                    Try different email
                </a>
            </div>
        </div>
    </div>
</section>

<?php include("includes/footer.php"); ?>
