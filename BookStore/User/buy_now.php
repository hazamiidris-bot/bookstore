<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

$book_id = $_POST['book_id'] ?? $_GET['book_id'] ?? null;
$qty = $_POST['quantity'] ?? 1;

if(!$book_id){
    header("Location: book.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch();

if(!$book || $book['stock'] < $qty){
    die("Buku tidak tersedia atau stok tidak cukup.");
}

$total = $book['price'] * $qty;

$conn->beginTransaction();

$sql = $conn->prepare("INSERT INTO orders (user_id, total, status, created_at) VALUES (?,?, 'Pending', NOW())");
$sql->execute([$_SESSION['id'], $total]);
$order_id = $conn->lastInsertId();

$sql2 = $conn->prepare("INSERT INTO order_items (order_id, book_id, qty, price) VALUES (?,?,?,?)");
$sql2->execute([$order_id, $book_id, $qty, $book['price']]);

$sql3 = $conn->prepare("UPDATE books SET stock = stock - ? WHERE id = ?");
$sql3->execute([$qty, $book_id]);

$conn->commit();

header("Location: payment.php?order_id=" . $order_id);
exit;