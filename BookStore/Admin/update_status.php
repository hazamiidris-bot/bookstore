<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

if(isset($_POST['id']) && isset($_POST['status'])){

    $order_id = $_POST['id'];
    $new_status = $_POST['status'];

    $cek = $conn->prepare("SELECT status FROM orders WHERE id = ?");
    $cek->execute([$order_id]);
    $old_status = $cek->fetchColumn();

    // Kalau baru dibatalkan (sebelumnya bukan Cancelled), kembalikan stok
    if($new_status == 'Cancelled' && $old_status != 'Cancelled'){

        $items = $conn->prepare("SELECT book_id, qty FROM order_items WHERE order_id = ?");
        $items->execute([$order_id]);

        foreach($items->fetchAll() as $item){
            $restore = $conn->prepare("UPDATE books SET stock = stock + ? WHERE id = ?");
            $restore->execute([$item['qty'], $item['book_id']]);
        }
    }

    // Kalau dibatalkan lalu diubah lagi ke Paid/Pending, potong ulang stoknya
    if($old_status == 'Cancelled' && $new_status != 'Cancelled'){

        $items = $conn->prepare("SELECT book_id, qty FROM order_items WHERE order_id = ?");
        $items->execute([$order_id]);

        foreach($items->fetchAll() as $item){
            $deduct = $conn->prepare("UPDATE books SET stock = stock - ? WHERE id = ?");
            $deduct->execute([$item['qty'], $item['book_id']]);
        }
    }

    $sql = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $sql->execute([$new_status, $order_id]);
}

header("Location: pesanan.php");
exit;