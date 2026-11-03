<?php
if(!isset($_SESSION)){ session_start(); }

$cartCount = 0;
$wishCount = 0;

if(isset($_SESSION['id'])){
    include_once __DIR__ . "/../config/database.php";

    $cartCount = $conn->prepare("SELECT COALESCE(SUM(qty),0) FROM cart WHERE user_id = ?");
    $cartCount->execute([$_SESSION['id']]);
    $cartCount = $cartCount->fetchColumn();

    $wishCount = $conn->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ?");
    $wishCount->execute([$_SESSION['id']]);
    $wishCount = $wishCount->fetchColumn();
}
?>

<nav>

<div class="logo">Zook</div>

<div class="search">
<form action="/bookstore/User/book.php" method="GET">
<input type="text" name="q" placeholder="Search Book...">
<button type="submit" style="border:none;background:none;">
<i class="fa-solid fa-magnifying-glass"></i>
</button>
</form>
</div>

<ul>
<li><a href="/bookstore/index.php">Home</a></li>
<li><a href="/bookstore/User/book.php">Book</a></li>
<li><a href="/bookstore/User/wishlist.php">Wishlist (<?= $wishCount ?>)</a></li>
<li><a href="/bookstore/Community/index.php">Community</a></li>
<li><a href="/bookstore/About/index.php">About Us</a></li>
</ul>

<div class="menu-right">

<a href="/bookstore/User/cart.php" style="color:inherit;">
<i class="fa-solid fa-cart-shopping"></i> (<?= $cartCount ?>)
</a>

<?php if(isset($_SESSION['id'])){ ?>
<a href="/bookstore/User/my_orders.php" style="color:inherit; text-decoration:none;">
<i class="fa-solid fa-receipt"></i> Pesanan Saya
</a>
<a href="/bookstore/User/profile.php" style="color:inherit; text-decoration:none;">
Hai, <?= htmlspecialchars($_SESSION['fullname']) ?>
</a>
<a href="/bookstore/User/logout.php" class="login-btn">Logout</a>
<?php } else { ?>
<a href="/bookstore/User/login.php" class="login-btn">Login</a>
<?php } ?>

</div>

</nav>