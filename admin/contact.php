<?php

session_start();

if(!isset($_SESSION['admin']))
{
    header("Location:login.php");
    exit();
}

require_once("../config/db.php");

/** @var mysqli $conn */

$result = mysqli_query($conn,"
SELECT *
FROM contact_messages
ORDER BY created_at DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contact Messages</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<meta http-equiv="refresh" content="5">

</head>

<body>

<div class="wrapper">

    <?php include("includes/sidebar.php"); ?>

    <div class="main">

        <?php include("includes/topbar.php"); ?>

        <div class="page">

            <h2 style="margin-bottom:25px;">
                Contact Messages
            </h2>

            <div class="table-box">

                <table>

                    <thead>

                        <tr>

                            <th>S.No</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Subject</th>

                            <th>Message</th>

                            <th>Date</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $sl = 1;

                    while($row = mysqli_fetch_assoc($result))
                    {

                    ?>

                    <tr>

                        <td><?= $sl++; ?></td>

                        <td><?= htmlspecialchars($row['name']); ?></td>

                        <td><?= htmlspecialchars($row['email']); ?></td>

                        <td><?= htmlspecialchars($row['subject']); ?></td>

                        <td class="message-cell">
    <?= nl2br(htmlspecialchars($row['message'])); ?>
</td>

                        <td>
                            <?= date("d M Y h:i A", strtotime($row['created_at'])); ?>
                        </td>

                        <td>

                            <a
                            href="delete-message.php?id=<?= $row['id']; ?>"
                            onclick="return confirm('Delete this message?');"
                            style="color:red;font-weight:bold;">

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