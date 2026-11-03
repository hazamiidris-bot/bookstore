<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

$order_id = $_GET['order_id'];

$stmt = $conn->prepare("
SELECT orders.*, users.fullname, users.email
FROM orders
LEFT JOIN users ON orders.user_id = users.id
WHERE orders.id = ? AND orders.user_id = ?
");
$stmt->execute([$order_id, $_SESSION['id']]);
$order = $stmt->fetch();

if(!$order){
    die("Pesanan tidak ditemukan.");
}

$items = $conn->prepare("
SELECT order_items.*, books.title
FROM order_items
JOIN books ON order_items.book_id = books.id
WHERE order_items.order_id = ?
");
$items->execute([$order_id]);
$items = $items->fetchAll();

$payment = $conn->prepare("SELECT * FROM payments WHERE order_id = ? ORDER BY id DESC LIMIT 1");
$payment->execute([$order_id]);
$payment = $payment->fetch();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Pesanan #<?= $order['id'] ?> - Zook BookStore</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#f1f5f9;
    padding:40px 20px;
}

.struk-wrap{
    max-width:420px;
    margin:0 auto;
}

.struk-actions{
    display:flex;
    gap:10px;
    margin-bottom:20px;
}

.struk-actions button,
.struk-actions a{
    flex:1;
    text-align:center;
    padding:12px;
    border-radius:10px;
    border:none;
    font-weight:600;
    font-size:13px;
    cursor:pointer;
    text-decoration:none;
}

.btn-print{
    background:#2563EB;
    color:white;
}

.btn-back{
    background:#e2e8f0;
    color:#333;
}

.struk{
    background:white;
    padding:30px 25px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.struk-header{
    text-align:center;
    border-bottom:1px dashed #ccc;
    padding-bottom:16px;
    margin-bottom:16px;
}

.struk-header h1{
    font-size:22px;
    font-weight:800;
    letter-spacing:1px;
}

.struk-header p{
    font-size:11px;
    color:#888;
    margin-top:4px;
}

.struk-meta{
    font-size:12px;
    color:#444;
    margin-bottom:16px;
    line-height:1.8;
}

.struk-meta b{
    color:#111;
}

.struk-items{
    border-top:1px dashed #ccc;
    border-bottom:1px dashed #ccc;
    padding:14px 0;
    margin-bottom:14px;
}

.struk-item{
    display:flex;
    justify-content:space-between;
    font-size:13px;
    margin-bottom:8px;
}

.struk-item .name{
    flex:1;
    padding-right:10px;
}

.struk-item .qty{
    color:#888;
    font-size:11px;
    display:block;
}

.struk-total{
    display:flex;
    justify-content:space-between;
    font-size:16px;
    font-weight:700;
    margin-bottom:16px;
}

.struk-status{
    text-align:center;
    padding:10px;
    border-radius:8px;
    font-size:12px;
    font-weight:700;
    margin-bottom:16px;
}

.status-Pending{ background:#fef9c3; color:#854d0e; }
.status-Paid{ background:#dcfce7; color:#166534; }
.status-Cancelled{ background:#fee2e2; color:#991b1b; }

.struk-footer{
    text-align:center;
    font-size:11px;
    color:#999;
    border-top:1px dashed #ccc;
    padding-top:14px;
}

@media print{
    body{
        background:white;
        padding:0;
    }
    .struk-actions{
        display:none;
    }
    .struk-wrap{
        max-width:100%;
    }
    .struk{
        box-shadow:none;
        border-radius:0;
    }
}

</style>
</head>
<body>

<div class="struk-wrap">

<div class="struk-actions">
<button onclick="window.print()" class="btn-print">
🖨️ Print Struk
</button>
<a href="my_orders.php" class="btn-back">Kembali</a>
</div>

<div class="struk">

<div class="struk-header">
<h1>ZOOK BOOKSTORE</h1>
<p>Struk Bukti Pembelian</p>
</div>

<div class="struk-meta">
<b>No. Pesanan:</b> #<?= $order['id'] ?><br>
<b>Tanggal:</b> <?= date('d M Y, H:i', strtotime($order['created_at'])) ?><br>
<b>Nama:</b> <?= htmlspecialchars($order['fullname']) ?><br>
<b>Email:</b> <?= htmlspecialchars($order['email']) ?>
<?php if($payment){ ?>
<br><b>Metode Bayar:</b> <?= htmlspecialchars($payment['payment_method']) ?>
<?php } ?>
</div>

<div class="struk-items">

<?php foreach($items as $item){ ?>
<div class="struk-item">
<div class="name">
<?= htmlspecialchars($item['title']) ?>
<span class="qty"><?= $item['qty'] ?> x Rp <?= number_format($item['price']) ?></span>
</div>
<div>Rp <?= number_format($item['qty'] * $item['price']) ?></div>
</div>
<?php } ?>

</div>

<div class="struk-total">
<span>Total</span>
<span>Rp <?= number_format($order['total']) ?></span>
</div>

<div class="struk-status status-<?= $order['status'] ?>">
STATUS: <?= strtoupper($order['status']) ?>
</div>

<div class="struk-footer">
Terima kasih telah berbelanja di Zook BookStore.<br>
Simpan struk ini sebagai bukti transaksi.
</div>

</div>

</div>

</body>
</html>
