<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$order_id = $_GET['order_id'];

$stmt = $conn->prepare("
SELECT orders.*, users.fullname
FROM orders LEFT JOIN users ON orders.user_id = users.id
WHERE orders.id = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if(!$order){
    die("Pesanan tidak ditemukan.");
}

if(isset($_POST['save'])){

    $proof = $order['shipping_proof'];

    if(isset($_FILES['proof']) && $_FILES['proof']['error'] == 0){
        $proof = time()."_".$_FILES['proof']['name'];
        move_uploaded_file(
            $_FILES['proof']['tmp_name'],
            "../uploads/shipping/".$proof
        );
    }

    $sql = $conn->prepare("UPDATE orders SET shipping_proof = ? WHERE id = ?");
    $sql->execute([$proof, $order_id]);

    header("Location: pesanan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Bukti Pengiriman</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Bukti Pengiriman Pesanan #<?= $order['id'] ?></h1>
<br>

<p><b>Customer:</b> <?= htmlspecialchars($order['fullname'] ?? '-') ?></p>
<p><b>Status Pesanan:</b> <?= $order['status'] ?></p>

<br>

<?php if($order['shipping_proof']){ ?>
<p><b>Bukti Pengiriman Saat Ini:</b></p>
<img src="../uploads/shipping/<?= $order['shipping_proof'] ?>" width="300" style="border-radius:10px; margin:10px 0;">
<?php } else { ?>
<p>Belum ada bukti pengiriman.</p>
<?php } ?>

<form method="POST" enctype="multipart/form-data" class="book-form">

<label>Upload Bukti Pengiriman / Resi</label>
<input type="file" name="proof" accept="image/*">

<br><br>

<button class="save-btn" name="save">Simpan</button>

</form>

</div>
</div>

</body>
</html>
