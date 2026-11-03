<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

$stmt = $conn->prepare("
SELECT cart.*, books.title, books.price, books.stock
FROM cart JOIN books ON cart.book_id = books.id
WHERE cart.user_id = ?
");
$stmt->execute([$_SESSION['id']]);
$items = $stmt->fetchAll();

if(count($items) == 0){
    header("Location: cart.php");
    exit;
}

$total = 0;
foreach($items as $i){ $total += $i['price'] * $i['qty']; }

if(isset($_POST['place_order'])){

    $conn->beginTransaction();

    $sql = $conn->prepare("INSERT INTO orders (user_id, total, status, created_at) VALUES (?,?, 'Pending', NOW())");
    $sql->execute([$_SESSION['id'], $total]);
    $order_id = $conn->lastInsertId();

    foreach($items as $item){
        $sql2 = $conn->prepare("INSERT INTO order_items (order_id, book_id, qty, price) VALUES (?,?,?,?)");
        $sql2->execute([$order_id, $item['book_id'], $item['qty'], $item['price']]);

        $sql3 = $conn->prepare("UPDATE books SET stock = stock - ? WHERE id = ?");
        $sql3->execute([$item['qty'], $item['book_id']]);
    }

    $del = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $del->execute([$_SESSION['id']]);

    $conn->commit();

    header("Location: payment.php?order_id=" . $order_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Checkout - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>

.checkout-page{
    min-height:75vh;
    padding:50px 20px;
    background:#f5f7fb;
    display:flex;
    justify-content:center;
}

.checkout-card{
    background:white;
    width:100%;
    max-width:560px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
    overflow:hidden;
    height:fit-content;
}

.checkout-header{
    padding:26px 30px;
    border-bottom:1px solid #eee;
}

.checkout-header h1{
    font-size:22px;
}

.checkout-body{
    padding:24px 30px;
}

.checkout-line{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    border-bottom:1px solid #f1f1f1;
    font-size:14px;
}

.checkout-line .item-name{
    color:#333;
}

.checkout-line .item-price{
    font-weight:600;
    color:#111;
}

.checkout-total{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding-top:20px;
    margin-top:8px;
}

.checkout-total .label{
    color:#666;
    font-size:14px;
}

.checkout-total .value{
    font-size:24px;
    font-weight:700;
    color:#2563EB;
}

.checkout-btn{
    width:100%;
    margin-top:24px;
    padding:15px;
    background:#2563EB;
    color:white;
    border:none;
    border-radius:12px;
    font-size:15px;
    font-weight:700;
    cursor:pointer;
    transition:.2s;
}

.checkout-btn:hover{
    background:#1d4ed8;
}

</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="checkout-page">

<div class="checkout-card">

<div class="checkout-header">
<h1>Ringkasan Pesanan</h1>
</div>

<div class="checkout-body">

<?php foreach($items as $item){ ?>
<div class="checkout-line">
<span class="item-name"><?= htmlspecialchars($item['title']) ?> &times; <?= $item['qty'] ?></span>
<span class="item-price">Rp <?= number_format($item['price'] * $item['qty']) ?></span>
</div>
<?php } ?>

<div class="checkout-total">
<span class="label">Total Pembayaran</span>
<span class="value">Rp <?= number_format($total) ?></span>
</div>

<form method="POST">
<button type="submit" name="place_order" class="checkout-btn">Buat Pesanan</button>
</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>