<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

$setting = $conn->query("SELECT * FROM payment_settings ORDER BY id DESC LIMIT 1")->fetch();

if(!$setting){
    $conn->exec("INSERT INTO payment_settings (bank_name, bank_account_number, bank_account_name) VALUES ('', '', '')");
    $setting = $conn->query("SELECT * FROM payment_settings ORDER BY id DESC LIMIT 1")->fetch();
}

$success = "";

if(isset($_POST['save'])){

    $bank_name = $_POST['bank_name'];
    $bank_account_number = $_POST['bank_account_number'];
    $bank_account_name = $_POST['bank_account_name'];
    $ewallet_info = $_POST['ewallet_info'];

    $qris_image = $setting['qris_image'];

    if(isset($_FILES['qris_image']) && $_FILES['qris_image']['error'] == 0){
        $qris_image = time()."_".$_FILES['qris_image']['name'];
        move_uploaded_file(
            $_FILES['qris_image']['tmp_name'],
            "../uploads/qris/".$qris_image
        );
    }

    $sql = $conn->prepare("UPDATE payment_settings SET
        bank_name=?, bank_account_number=?, bank_account_name=?, qris_image=?, ewallet_info=?
        WHERE id=?");

    $sql->execute([
        $bank_name, $bank_account_number, $bank_account_name, $qris_image, $ewallet_info, $setting['id']
    ]);

    $success = "Pengaturan pembayaran berhasil disimpan.";

    $setting = $conn->query("SELECT * FROM payment_settings ORDER BY id DESC LIMIT 1")->fetch();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengaturan Pembayaran</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Pengaturan Pembayaran</h1>
<br>

<?php if($success){ ?>
<p style="background:#dcfce7; color:#166534; padding:12px; border-radius:8px; margin-bottom:15px;"><?= $success ?></p>
<?php } ?>

<form method="POST" enctype="multipart/form-data" class="book-form">

<label>Nama Bank</label>
<input type="text" name="bank_name" value="<?= htmlspecialchars($setting['bank_name']) ?>" placeholder="Contoh: BCA">

<label>Nomor Rekening</label>
<input type="text" name="bank_account_number" value="<?= htmlspecialchars($setting['bank_account_number']) ?>" placeholder="Contoh: 1234567890">

<label>Atas Nama</label>
<input type="text" name="bank_account_name" value="<?= htmlspecialchars($setting['bank_account_name']) ?>" placeholder="Contoh: Zook BookStore">

<label>Gambar QRIS</label>
<?php if($setting['qris_image']){ ?>
<br>
<img src="../uploads/qris/<?= $setting['qris_image'] ?>" width="150" style="border-radius:8px; margin:10px 0;">
<?php } ?>
<input type="file" name="qris_image" accept="image/*">

<label>Info Tambahan / E-Wallet</label>
<textarea name="ewallet_info" rows="4" placeholder="Contoh: DANA/OVO/GoPay ke nomor 08xxxxx"><?= htmlspecialchars($setting['ewallet_info']) ?></textarea>

<br><br>

<button class="save-btn" name="save">Simpan Pengaturan</button>

</form>

</div>
</div>

</body>
</html>
