<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

$stmt = $conn->prepare("
SELECT wishlist.id AS wish_id, books.*
FROM wishlist
JOIN books ON wishlist.book_id = books.id
WHERE wishlist.user_id = ?
");
$stmt->execute([$_SESSION['id']]);
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Wishlist - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="popular">

<h2>Wishlist Saya</h2>

<div class="book-container">

<?php if(count($items) == 0){ ?>
<p>Wishlist kamu masih kosong.</p>
<?php } ?>

<?php foreach($items as $book){ ?>

<div class="book-card">
<img src="../uploads/books/<?= $book['cover'] ?>" alt="">
<h3><?= $book['title'] ?></h3>
<p class="price">Rp <?= number_format($book['price']) ?></p>
<a href="detail_book.php?id=<?= $book['id'] ?>"><button>Lihat Detail</button></a>
<br><br>
<a href="wishlist_action.php?remove=<?= $book['wish_id'] ?>" onclick="return confirm('Hapus dari wishlist?')">Hapus</a>
</div>

<?php } ?>

</div>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>