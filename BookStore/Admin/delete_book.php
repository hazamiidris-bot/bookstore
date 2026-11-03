<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT cover FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if($book && $book['cover'] && file_exists("../uploads/books/".$book['cover'])){
    unlink("../uploads/books/".$book['cover']);
}

$sql = $conn->prepare("DELETE FROM books WHERE id = ?");
$sql->execute([$id]);

header("Location: books.php");
exit;