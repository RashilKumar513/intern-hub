<?php

$conn = mysqli_connect(
    "sql200.infinityfree.com",
    "if0_42391549",
    "Rashil2006",
    "if0_42391549_internhub"
);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>