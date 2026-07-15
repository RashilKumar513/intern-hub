<?php

if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}

require_once __DIR__ . "/../../config/db.php";

if(!isset($_SESSION['admin']))
{
    header("Location: login.php");
    exit();
}