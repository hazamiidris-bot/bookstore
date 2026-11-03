<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$id = $_GET['id'];

$conn->beginTransaction();

$del1 = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
$del1->execute([$id]);

$del2 = $conn->prepare("DELETE FROM payments WHERE order_id = ?");
$del2->execute([$id]);

$del3 = $conn->prepare("DELETE FROM orders WHERE id = ?");
$del3->execute([$id]);

$conn->commit();

header("Location: pesanan.php");
exit;
