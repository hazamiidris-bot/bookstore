<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$id = $_GET['id'];

$sql = $conn->prepare("DELETE FROM categories WHERE id = ?");
$sql->execute([$id]);

header("Location: category.php");
exit;