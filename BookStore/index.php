<?php
session_start();
include "config/database.php";

$banners = $conn->query("SELECT * FROM banners ORDER BY id ASC")->fetchAll();


// Daftar buku populer
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

.hero-carousel{
    position:relative;
    max-width:1200px;
    margin:30px auto;
    padding:0 20px;
    overflow:hidden;
    border-radius:15px;
}

.hero-track{
    display:flex;
    transition:transform .5s ease;
}

.hero-slide{
    min-width:100%;
    position:relative;
}

.hero-slide img{
    width:100%;
    height:400px;
    object-fit:cover;
    display:block;
}

.hero-slide-caption{
    position:absolute;
    bottom:0;
    left:0;
    right:0;
    background:linear-gradient(transparent, rgba(0,0,0,.75));
    color:white;
    padding:40px 30px 25px;
}

.hero-slide-caption h2{
    font-size:26px;
    margin-bottom:8px;
}

.hero-slide-caption p{
    font-size:14px;
    max-width:600px;
    opacity:.9;
}

.hero-dot{
    width:9px;
    height:9px;
    border-radius:50%;
    background:rgba(255,255,255,.5);
    cursor:pointer;
    border:none;
}

.hero-dot.active{
    background:white;
    width:22px;
    border-radius:5px;
    transition:.3s;
}

.hero-arrow{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    background:rgba(255,255,255,.85);
    border:none;
    width:38px;
    height:38px;
    border-radius:50%;
    cursor:pointer;
    font-size:16px;
    z-index:10;
}

.hero-dots{
    position:absolute;
    bottom:15px;
    right:25px;
    display:flex;
    gap:8px;
    z-index:10;
}

.hero-arrow.prev{ left:15px; }
.hero-arrow.next{ right:15px; }

</style>

</head>

<body>

<?php include "includes/navbar.php"; ?>

<?php if(count($banners) > 0){ ?>

<div class="hero-carousel">

<div class="hero-track" id="heroTrack">

<?php foreach($banners as $b){ ?>
<div class="hero-slide">
<?php if(!empty($b['book_id'])){ ?>
<a href="User/detail_book.php?id=<?= $b['book_id'] ?>" style="display:block;">
<?php } ?>
<img src="uploads/banners/<?= $b['image'] ?>" alt="">
<div class="hero-slide-caption">
<h2><?= htmlspecialchars($b['title']) ?></h2>
<?php if(!empty($b['author'])){ ?>
<p style="font-weight:600; opacity:.85; margin-bottom:6px;">By <?= htmlspecialchars($b['author']) ?></p>
<?php } ?>
<p><?= htmlspecialchars($b['description']) ?></p>
</div>
<?php if(!empty($b['book_id'])){ ?>
</a>
<?php } ?>
</div>
<?php } ?>

</div>

<?php if(count($banners) > 1){ ?>

<button class="hero-arrow prev" onclick="moveSlide(-1)">&#10094;</button>
<button class="hero-arrow next" onclick="moveSlide(1)">&#10095;</button>

<div class="hero-dots" id="heroDots">
<?php foreach($banners as $i => $b){ ?>
<button class="hero-dot <?= $i==0?'active':'' ?>" onclick="goToSlide(<?= $i ?>)"></button>
<?php } ?>
</div>

<?php } ?>

</div>

<script>
let slideIndex = 0;
const totalSlides = <?= count($banners) ?>;
const track = document.getElementById('heroTrack');
const dots = document.querySelectorAll('.hero-dot');

function updateSlide(){
    track.style.transform = `translateX(-${slideIndex * 100}%)`;
    dots.forEach((d,i) => d.classList.toggle('active', i === slideIndex));
}

function moveSlide(dir){
    slideIndex = (slideIndex + dir + totalSlides) % totalSlides;
    updateSlide();
}

function goToSlide(i){
    slideIndex = i;
    updateSlide();
}

<?php if(count($banners) > 1){ ?>
setInterval(() => moveSlide(1), 4000);
<?php } ?>
</script>

<?php } else { ?>

<section class="hero">
<div class="left">
<img src="assets/img/banner.jpg">
</div>
<div class="right">
<h1>Selamat Datang di Zook BookStore</h1>
<p>Temukan koleksi buku terbaik untuk kamu.</p>
<a href="User/book.php"><button>Lihat Semua Buku</button></a>
</div>
</section>

<?php } ?>


<section class="popular">

<h2>Popular Book</h2>

<div class="book-container">

<?php foreach($books as $book){ ?>

<div class="book-card">

    <a href="User/detail_book.php?id=<?= $book['id']; ?>">
    <img src="uploads/books/<?= $book['cover']; ?>">
    </a>

    <h3><?= htmlspecialchars($book['title']); ?></h3>

    <p><?= htmlspecialchars($book['author']); ?></p>

    <p>Rp <?= number_format($book['price'],0,',','.'); ?></p>

<?php if(isset($_SESSION['id'])){ ?>

    <div class="book-card-actions">

    <form method="POST" action="User/cart_action.php">
    <input type="hidden" name="book_id" value="<?= $book['id']; ?>">
    <input type="hidden" name="quantity" value="1">
    <button type="submit" name="add_to_cart" class="btn-addcart">
    <i class="fa-solid fa-cart-shopping"></i> Add Cart
    </button>
    </form>

    <form method="POST" action="User/buy_now.php">
    <input type="hidden" name="book_id" value="<?= $book['id']; ?>">
    <input type="hidden" name="quantity" value="1">
    <button type="submit" class="btn-buynow">
    Beli Sekarang
    </button>
    </form>

    </div>

<?php } else { ?>

    <div class="book-card-actions">
    <a href="User/login.php" style="flex:1;">
    <button type="button" class="btn-addcart">
    <i class="fa-solid fa-cart-shopping"></i> Add Cart
    </button>
    </a>
    <a href="User/login.php" style="flex:1;">
    <button type="button" class="btn-buynow">
    Beli Sekarang
    </button>
    </a>
    </div>

<?php } ?>

</div>

<?php } ?>

</div>

</section>


<?php include "includes/footer.php"; ?>

</body>

</html>