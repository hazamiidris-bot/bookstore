<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

$stmt = $conn->prepare("
SELECT cart.*, books.title, books.price, books.cover, books.stock
FROM cart
JOIN books ON cart.book_id = books.id
WHERE cart.user_id = ?
");
$stmt->execute([$_SESSION['id']]);
$items = $stmt->fetchAll();

$total = 0;
foreach($items as $i){ $total += $i['price'] * $i['qty']; }
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Keranjang - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>

.cart-page{
    min-height:75vh;
    padding:50px 20px;
    background:#f5f7fb;
}

.cart-wrap{
    max-width:750px;
    margin:0 auto;
}

.cart-wrap h1{
    font-size:28px;
    margin-bottom:25px;
}

.cart-empty{
    background:white;
    border-radius:20px;
    padding:50px 30px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
}

.cart-empty i{
    font-size:40px;
    color:#cbd5e1;
    margin-bottom:15px;
    display:block;
}

.cart-empty a{
    color:#2563EB;
    font-weight:600;
    text-decoration:none;
}

.cart-item{
    background:white;
    border-radius:18px;
    padding:20px;
    display:flex;
    gap:20px;
    align-items:center;
    box-shadow:0 8px 22px rgba(0,0,0,.06);
    margin-bottom:16px;
}

.cart-item img{
    width:80px;
    height:105px;
    object-fit:cover;
    border-radius:10px;
    flex-shrink:0;
}

.cart-item-info{
    flex:1;
}

.cart-item-info h3{
    font-size:17px;
    margin-bottom:6px;
}

.cart-item-info .price{
    color:#2563EB;
    font-weight:700;
    margin-bottom:12px;
}

.qty-form{
    display:flex;
    gap:10px;
    align-items:center;
}

.qty-form input[type=number]{
    width:60px;
    padding:8px;
    border:1px solid #e2e8f0;
    border-radius:8px;
    text-align:center;
}

.qty-form button{
    padding:8px 16px;
    background:#1e293b;
    color:white;
    border:none;
    border-radius:8px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
}

.remove-link{
    color:#dc2626;
    font-size:13px;
    text-decoration:none;
    margin-top:8px;
    display:inline-block;
}

.cart-summary{
    background:white;
    border-radius:18px;
    padding:24px;
    box-shadow:0 8px 22px rgba(0,0,0,.06);
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:10px;
}

.cart-summary .total-label{
    font-size:14px;
    color:#666;
}

.cart-summary .total-value{
    font-size:24px;
    font-weight:700;
    color:#111;
}

.checkout-btn{
    background:#2563EB;
    color:white;
    border:none;
    padding:14px 32px;
    border-radius:12px;
    font-weight:700;
    font-size:15px;
    cursor:pointer;
    text-decoration:none;
    transition:.2s;
}

.checkout-btn:hover{
    background:#1d4ed8;
}

</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="cart-page">
<div class="cart-wrap">

<h1>Keranjang Belanja</h1>

<?php if(count($items) == 0){ ?>

<div class="cart-empty">
<i class="fa-solid fa-cart-shopping"></i>
<p>Keranjang kamu masih kosong.</p>
<br>
<a href="book.php">Yuk mulai belanja buku</a>
</div>

<?php } else { ?>

<?php foreach($items as $item){ ?>

<div class="cart-item">

<img src="../uploads/books/<?= $item['cover'] ?>" alt="">

<div class="cart-item-info">
<h3><?= htmlspecialchars($item['title']) ?></h3>
<div class="price">Rp <?= number_format($item['price']) ?></div>

<form method="POST" action="cart_action.php" class="qty-form">
<input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
<input type="number" name="quantity" value="<?= $item['qty'] ?>" min="1" max="<?= $item['stock'] ?>">
<button type="submit" name="update_qty">Update</button>
</form>

<a href="cart_action.php?remove=<?= $item['id'] ?>" class="remove-link" onclick="return confirm('Hapus dari keranjang?')">
<i class="fa-solid fa-trash"></i> Hapus
</a>

</div>

</div>

<?php } ?>

<div class="cart-summary">
<div>
<div class="total-label">Total Belanja</div>
<div class="total-value">Rp <?= number_format($total) ?></div>
</div>
<a href="checkout.php" class="checkout-btn">Checkout</a>
</div>

<?php } ?>

</div>
</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>