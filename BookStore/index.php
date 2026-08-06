<?php

include "config/database.php";

$books = $conn->query("
SELECT books.*, categories.name AS category
FROM books
LEFT JOIN categories
ON books.category_id = categories.id
ORDER BY books.id DESC
LIMIT 8
");

?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Zook BookStore</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>


<section class="hero">

<div class="left">

<img src="assets/img/banner.jpg">

</div>

<div class="right">

<h1>Good Bye Eri</h1>

<h3>By Tatsuki Fujimoto</h3>

<p>

Goodbye Eri menceritakan Yuta,

seorang pemuda yang kehilangan ibunya,

kemudian bertemu Eri yang

mengubah hidupnya.

</p>

<button>Read More</button>

</div>

</section>


<section class="popular">

<h2>Popular Book</h2>

<div class="book-container">

<?php foreach($books as $book){ ?>

<div class="book-card">

    <img src="uploads/books/<?= $book['cover']; ?>">

    <h3><?= htmlspecialchars($book['title']); ?></h3>

    <p><?= htmlspecialchars($book['author']); ?></p>

    <p>Rp <?= number_format($book['price'],0,',','.'); ?></p>

    <button>

<i class="fa-solid fa-cart-shopping"></i>

Add Cart

</button>
</div>

<?php } ?>

</div>

</section>


<?php include "includes/footer.php"; ?>


</body>

</html>