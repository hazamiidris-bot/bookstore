<?php
session_start();
include "../config/database.php";

$id = $_GET['id'];

$stmt = $conn->prepare("
SELECT books.*, categories.name AS category
FROM books LEFT JOIN categories ON books.category_id = categories.id
WHERE books.id = ?
");
$stmt->execute([$id]);
$book = $stmt->fetch();

if(!$book){
    die("Buku tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($book['title']) ?> - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>

.hero{
    padding-bottom:60px;
    align-items:start;
}

.hero .left{
    background:#f1f1f1;
    border-radius:15px;
    display:flex;
    align-items:center;
    justify-content:center;
    height:500px;
    overflow:hidden;
}

.hero .left img{
    width:auto;
    height:100%;
    max-width:100%;
    object-fit:contain;
    border-radius:15px;
}

.detail-actions{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    margin-bottom:16px;
}

.right .detail-actions button.btn-addcart{
    background:#222 !important;
    color:white;
    padding:12px 24px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

.right .detail-actions button.btn-buynow{
    background:#2563EB !important;
    color:white;
    padding:12px 24px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

.right .wishlist-btn{
    background:white !important;
    color:#2563EB !important;
    border:2px solid #2563EB !important;
    padding:11px 24px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

.qty-box{
    margin-bottom:16px;
}

.qty-box label{
    font-weight:600;
    margin-bottom:8px;
    display:block;
}

.qty-box input{
    width:80px;
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
}

</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<section class="hero">

<div class="left">
<img src="../uploads/books/<?= $book['cover'] ?>">
</div>

<div class="right">

<h1><?= htmlspecialchars($book['title']) ?></h1>
<h3>By <?= htmlspecialchars($book['author']) ?></h3>
<p><b>Kategori:</b> <?= htmlspecialchars($book['category'] ?? '-') ?></p>
<p style="font-size:20px; font-weight:600; color:#2563EB; margin:10px 0;">
Rp <?= number_format($book['price'],0,',','.') ?>
</p>
<p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
<p style="margin-bottom:20px;"><b>Stok:</b> <?= $book['stock'] ?></p>

<?php if(isset($_SESSION['id'])){ ?>

<div class="qty-box">
<label>Jumlah</label>
<input type="number" id="qty" value="1" min="1" max="<?= $book['stock'] ?>">
</div>

<div class="detail-actions">

<form method="POST" action="cart_action.php" id="cartForm">
<input type="hidden" name="book_id" value="<?= $book['id'] ?>">
<input type="hidden" name="quantity" id="cartQty" value="1">
<button type="submit" name="add_to_cart" class="btn-addcart">
<i class="fa-solid fa-cart-shopping"></i> Tambah ke Keranjang
</button>
</form>

<form method="POST" action="buy_now.php" id="buyForm">
<input type="hidden" name="book_id" value="<?= $book['id'] ?>">
<input type="hidden" name="quantity" id="buyQty" value="1">
<button type="submit" class="btn-buynow">Beli Sekarang</button>
</form>

</div>

<form method="POST" action="wishlist_action.php">
<input type="hidden" name="book_id" value="<?= $book['id'] ?>">
<button type="submit" name="add_to_wishlist" class="wishlist-btn">
<i class="fa-regular fa-heart"></i> Tambah ke Wishlist
</button>
</form>

<script>
document.getElementById('qty').addEventListener('input', function(){
    document.getElementById('cartQty').value = this.value;
    document.getElementById('buyQty').value = this.value;
});
</script>

<?php } else { ?>

<p><a href="login.php">Login</a> dulu untuk membeli buku ini.</p>

<?php } ?>

</div>

</section>

<?php include "../includes/footer.php"; ?>

</body>
</html>