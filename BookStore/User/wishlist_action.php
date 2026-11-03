<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

if(isset($_POST['add_to_wishlist'])){

    $book_id = $_POST['book_id'];
    $user_id = $_SESSION['id'];

    $check = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND book_id = ?");
    $check->execute([$user_id, $book_id]);

    if($check->rowCount() == 0){
        $sql = $conn->prepare("INSERT INTO wishlist (user_id, book_id) VALUES (?,?)");
        $sql->execute([$user_id, $book_id]);
    }
}

if(isset($_GET['remove'])){
    $sql = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
    $sql->execute([$_GET['remove'], $_SESSION['id']]);
}

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'wishlist.php'));
exit;