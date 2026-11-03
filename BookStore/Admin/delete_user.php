<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$id = $_GET['id'];

if($id != $_SESSION['id']){
    $sql = $conn->prepare("DELETE FROM users WHERE id = ?");
    $sql->execute([$id]);
}

header("Location: user.php");
exit;