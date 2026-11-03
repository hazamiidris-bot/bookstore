<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$order_id = $_GET['order_id'];

$stmt = $conn->prepare("SELECT * FROM payments WHERE order_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$order_id]);
$payment = $stmt->fetch();

if(isset($_POST['verify'])){

    $status = $_POST['payment_status'];

    $sql = $conn->prepare("UPDATE payments SET payment_status = ? WHERE id = ?");
    $sql->execute([$status, $payment['id']]);

    if($status == 'Verified'){
        $sql2 = $conn->prepare("UPDATE orders SET status = 'Paid' WHERE id = ?");
        $sql2->execute([$order_id]);
    }

    header("Location: pesanan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Verifikasi Pembayaran</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Verifikasi Pembayaran Pesanan #<?= $order_id ?></h1>
<br>

<?php if(!$payment){ ?>

<p>Belum ada bukti pembayaran untuk pesanan ini.</p>

<?php } else { ?>

<p><b>Metode:</b> <?= htmlspecialchars($payment['payment_method']) ?></p>
<p><b>Status:</b> <?= $payment['payment_status'] ?></p>

<?php if($payment['proof_image']){ ?>
<img src="../uploads/payment/<?= $payment['proof_image'] ?>" width="300" style="border-radius:10px; margin:15px 0;">
<?php } else { ?>
<p style="color:gray; font-style:italic;">Tidak ada file bukti (kemungkinan metode COD).</p>
<?php } ?>

<form method="POST">
<select name="payment_status">
<option value="Pending" <?= $payment['payment_status']=='Pending'?'selected':'' ?>>Pending</option>
<option value="Verified" <?= $payment['payment_status']=='Verified'?'selected':'' ?>>Verified</option>
<option value="Rejected" <?= $payment['payment_status']=='Rejected'?'selected':'' ?>>Rejected</option>
</select>
<br><br>
<button class="save-btn" name="verify">Simpan Status</button>
</form>

<?php } ?>

</div>
</div>

</body>
</html>