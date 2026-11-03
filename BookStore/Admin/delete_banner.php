<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT image FROM banners WHERE id = ?");
$stmt->execute([$id]);
$banner = $stmt->fetch();

if($banner && $banner['image'] && file_exists("../uploads/banners/".$banner['image'])){
    unlink("../uploads/banners/".$banner['image']);
}

$sql = $conn->prepare("DELETE FROM banners WHERE id = ?");
$sql->execute([$id]);

header("Location: banner.php");
exit;