<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

if(isset($_POST['add_to_cart'])){

    $book_id = $_POST['book_id'];
    $qty = $_POST['quantity'];
    $user_id = $_SESSION['id'];

    $check = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND book_id = ?");
    $check->execute([$user_id, $book_id]);
    $existing = $check->fetch();

    if($existing){
        $sql = $conn->prepare("UPDATE cart SET qty = qty + ? WHERE id = ?");
        $sql->execute([$qty, $existing['id']]);
    } else {
        $sql = $conn->prepare("INSERT INTO cart (user_id, book_id, qty) VALUES (?,?,?)");
        $sql->execute([$user_id, $book_id, $qty]);
    }
}

if(isset($_POST['update_qty'])){
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['quantity'];

    if($qty > 0){
        $sql = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ? AND user_id = ?");
        $sql->execute([$qty, $cart_id, $_SESSION['id']]);
    }
}

if(isset($_GET['remove'])){
    $sql = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $sql->execute([$_GET['remove'], $_SESSION['id']]);
}

header("Location: cart.php");
exit;