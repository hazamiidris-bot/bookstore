
<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

$orders = $conn->prepare("
SELECT * FROM orders
WHERE user_id = ?
ORDER BY id DESC
");
$orders->execute([$_SESSION['id']]);
$orders = $orders->fetchAll();

function getItems($conn, $order_id){
    $stmt = $conn->prepare("
    SELECT order_items.*, books.title, books.cover
    FROM order_items
    JOIN books ON order_items.book_id = books.id
    WHERE order_items.order_id = ?
    ");
    $stmt->execute([$order_id]);
    return $stmt->fetchAll();
}

function getPayment($conn, $order_id){
    $stmt = $conn->prepare("SELECT * FROM payments WHERE order_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$order_id]);
    return $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Pesanan - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
.orders-wrap{ max-width:800px; margin:40px auto; padding:0 20px; }
.order-card{ background:white; padding:25px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,.08); margin-bottom:25px; }
.order-head{ display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; padding-bottom:15px; border-bottom:1px solid #eee; }
.order-head h3{ margin:0; }
.status-badge{ padding:6px 14px; border-radius:20px; font-size:13px; font-weight:600; }
.status-Pending{ background:#fef9c3; color:#854d0e; }
.status-Paid{ background:#dcfce7; color:#166534; }
.status-Cancelled{ background:#fee2e2; color:#991b1b; }
.order-item{ display:flex; gap:15px; align-items:center; margin-bottom:12px; }
.order-item img{ width:50px; height:65px; object-fit:cover; border-radius:6px; }
.order-total{ text-align:right; font-weight:600; margin-top:15px; padding-top:15px; border-top:1px solid #eee; }
.proof-section{ margin-top:20px; padding-top:15px; border-top:1px solid #eee; display:flex; gap:20px; flex-wrap:wrap; }
.proof-box{ flex:1; min-width:200px; }
.proof-box h4{ margin-bottom:10px; font-size:14px; color:#666; }
.proof-box img{ width:100%; max-width:200px; border-radius:10px; }
.proof-empty{ color:#999; font-size:13px; font-style:italic; }
.print-link{ display:inline-block; font-size:12px; color:#2563EB; text-decoration:none; margin-bottom:10px; font-weight:600; }
</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="orders-wrap">

<h2>Riwayat Pesanan Saya</h2>
<br>

<?php if(count($orders) == 0){ ?>

<p>Kamu belum punya pesanan. <a href="book.php">Yuk belanja buku!</a></p>

<?php } ?>

<?php foreach($orders as $order){

    $items = getItems($conn, $order['id']);
    $payment = getPayment($conn, $order['id']);

?>

<div class="order-card">

<div class="order-head">
<h3>Pesanan #<?= $order['id'] ?></h3>
<span class="status-badge status-<?= $order['status'] ?>"><?= $order['status'] ?></span>
</div>

<a href="struk.php?order_id=<?= $order['id'] ?>" class="print-link">🖨️ Cetak Struk</a>

<p style="color:gray; font-size:13px; margin-bottom:15px;"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>

<?php foreach($items as $item){ ?>
<div class="order-item">
<img src="../uploads/books/<?= $item['cover'] ?>" alt="">
<div>
<b><?= htmlspecialchars($item['title']) ?></b><br>
<span style="color:gray; font-size:13px;"><?= $item['qty'] ?> x Rp <?= number_format($item['price']) ?></span>
</div>
</div>
<?php } ?>

<div class="order-total">
Total: Rp <?= number_format($order['total']) ?>
</div>

<div class="proof-section">

<div class="proof-box">
<h4>Bukti Pembayaran</h4>
<?php if($payment && $payment['proof_image']){ ?>
<img src="../uploads/payment/<?= $payment['proof_image'] ?>" alt="">
<p style="font-size:12px; color:gray; margin-top:5px;">Status: <?= $payment['payment_status'] ?></p>
<?php } else { ?>
<p class="proof-empty">Belum ada bukti pembayaran.</p>
<?php } ?>
</div>

<div class="proof-box">
<h4>Bukti Pengiriman</h4>
<?php if($order['shipping_proof']){ ?>
<img src="../uploads/shipping/<?= $order['shipping_proof'] ?>" alt="">
<?php } else { ?>
<p class="proof-empty">Pesanan belum dikirim.</p>
<?php } ?>
</div>

</div>

</div>

<?php } ?>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>