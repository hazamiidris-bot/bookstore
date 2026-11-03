<?php
session_start();
include "../config/database.php";

$kategori = $conn->query("SELECT * FROM categories ORDER BY name ASC");

$where = "1=1";
$params = [];

if(isset($_GET['q']) && $_GET['q'] != ""){
    $where .= " AND books.title LIKE ?";
    $params[] = "%".$_GET['q']."%";
}

if(isset($_GET['category']) && $_GET['category'] != ""){
    $where .= " AND books.category_id = ?";
    $params[] = $_GET['category'];
}

$stmt = $conn->prepare("
SELECT books.*, categories.name AS category
FROM books LEFT JOIN categories ON books.category_id = categories.id
WHERE $where
ORDER BY books.id DESC
");
$stmt->execute($params);
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Semua Buku - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
.book-card-actions{
    display:flex;
    gap:8px;
    margin-top:8px;
}
.book-card-actions form{
    flex:1;
}
.book-card-actions button{
    width:100%;
    padding:10px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:13px;
    font-weight:600;
}
.btn-addcart{
    background:#222;
    color:white;
}
.btn-buynow{
    background:#2563EB;
    color:white;
}
</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="popular">

<h2>Semua Buku</h2>

<form method="GET" style="margin:20px 0; display:flex; gap:15px;">
<input type="text" name="q" placeholder="Cari judul buku..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" style="padding:10px 15px; border-radius:20px; border:1px solid #ddd; flex:1;">
<select name="category" onchange="this.form.submit()" style="padding:10px 15px; border-radius:20px; border:1px solid #ddd;">
<option value="">Semua Kategori</option>
<?php foreach($kategori as $k){ ?>
<option value="<?= $k['id'] ?>" <?= (isset($_GET['category']) && $_GET['category']==$k['id']) ? 'selected' : '' ?>>
<?= htmlspecialchars($k['name']) ?>
</option>
<?php } ?>
</select>
<button type="submit" style="padding:10px 20px; border-radius:20px; border:none; background:#2563EB; color:white; cursor:pointer;">Cari</button>
</form>

<div class="book-container">

<?php if(count($books) == 0){ ?>
<p>Buku tidak ditemukan.</p>
<?php } ?>

<?php foreach($books as $book){ ?>

<div class="book-card">

<a href="detail_book.php?id=<?= $book['id'] ?>">
<img src="../uploads/books/<?= $book['cover'] ?>" alt="">
</a>

<h3><?= htmlspecialchars($book['title']) ?></h3>
<p class="author"><?= htmlspecialchars($book['author']) ?></p>
<p class="price">Rp <?= number_format($book['price'],0,',','.') ?></p>

<?php if(isset($_SESSION['id'])){ ?>

<div class="book-card-actions">

<form method="POST" action="cart_action.php">
<input type="hidden" name="book_id" value="<?= $book['id']; ?>">
<input type="hidden" name="quantity" value="1">
<button type="submit" name="add_to_cart" class="btn-addcart">
<i class="fa-solid fa-cart-shopping"></i> Add Cart
</button>
</form>

<form method="POST" action="buy_now.php">
<input type="hidden" name="book_id" value="<?= $book['id']; ?>">
<input type="hidden" name="quantity" value="1">
<button type="submit" class="btn-buynow">
Beli Sekarang
</button>
</form>

</div>

<?php } else { ?>

<div class="book-card-actions">
<a href="login.php" style="flex:1;">
<button type="button" class="btn-addcart">
<i class="fa-solid fa-cart-shopping"></i> Add Cart
</button>
</a>
<a href="login.php" style="flex:1;">
<button type="button" class="btn-buynow">
Beli Sekarang
</button>
</a>
</div>

<?php } ?>

</div>

<?php } ?>

</div>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>