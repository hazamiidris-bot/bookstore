<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

$order_id = $_GET['order_id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $_SESSION['id']]);
$order = $stmt->fetch();

if(!$order){ die("Pesanan tidak ditemukan."); }

$setting = $conn->query("SELECT * FROM payment_settings ORDER BY id DESC LIMIT 1")->fetch();

if(isset($_POST['pay'])){

    $method = $_POST['method'];
    $proof = "";

    if(isset($_FILES['proof']) && $_FILES['proof']['error'] == 0){
        $proof = time()."_".$_FILES['proof']['name'];
        move_uploaded_file(
            $_FILES['proof']['tmp_name'],
            "../uploads/payment/".$proof
        );
    }

    $sql = $conn->prepare("INSERT INTO payments (order_id, proof_image, payment_method, payment_status, created_at) VALUES (?,?,?, 'Pending', NOW())");
    $sql->execute([$order_id, $proof, $method]);

    header("Location: payment_success.php?order_id=" . $order_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembayaran - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>

.payment-page{
    min-height:80vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 20px;
    background:#f5f7fb;
}

.payment-modal{
    background:white;
    width:100%;
    max-width:560px;
    border-radius:24px;
    box-shadow:0 20px 50px rgba(0,0,0,.1);
    overflow:hidden;
}

.payment-modal-header{
    background:linear-gradient(135deg,#2563EB,#1d4ed8);
    color:white;
    padding:30px;
}

.payment-modal-header p{
    opacity:.85;
    font-size:13px;
    margin-bottom:6px;
}

.payment-modal-header h2{
    font-size:24px;
    margin-bottom:14px;
}

.payment-total{
    font-size:28px;
    font-weight:700;
}

.payment-modal-body{
    padding:30px;
}

.method-label{
    font-weight:600;
    margin-bottom:14px;
    display:block;
    color:#333;
}

.method-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:12px;
    margin-bottom:10px;
}

.method-option{
    position:relative;
}

.method-option input{
    position:absolute;
    opacity:0;
    width:100%;
    height:100%;
    top:0;
    left:0;
    cursor:pointer;
    margin:0;
}

.method-card{
    border:2px solid #e5e9f2;
    border-radius:14px;
    padding:16px 12px;
    text-align:center;
    transition:.2s;
    cursor:pointer;
}

.method-card i{
    font-size:22px;
    color:#94a3b8;
    margin-bottom:8px;
    display:block;
    transition:.2s;
}

.method-card span{
    font-size:13px;
    font-weight:600;
    color:#555;
}

.method-option input:checked + .method-card{
    border-color:#2563EB;
    background:#eff4ff;
}

.method-option input:checked + .method-card i,
.method-option input:checked + .method-card span{
    color:#2563EB;
}

.method-info{
    display:none;
    background:#f8fafc;
    border:1px dashed #cbd5e1;
    border-radius:14px;
    padding:18px;
    margin:18px 0;
    animation:fadeIn .25s ease;
}

.method-info.active{
    display:block;
}

@keyframes fadeIn{
    from{ opacity:0; transform:translateY(-6px); }
    to{ opacity:1; transform:translateY(0); }
}

.method-info-row{
    display:flex;
    justify-content:space-between;
    padding:6px 0;
    font-size:14px;
    border-bottom:1px solid #e5e9f2;
}

.method-info-row:last-child{
    border-bottom:none;
}

.method-info-row b{
    color:#111;
}

.method-info img{
    max-width:170px;
    border-radius:10px;
    display:block;
    margin-top:10px;
}

.upload-box{
    margin-top:20px;
}

.upload-box label{
    font-weight:600;
    display:block;
    margin-bottom:8px;
    font-size:14px;
    color:#333;
}

.upload-box input[type=file]{
    width:100%;
    padding:12px;
    border:2px dashed #cbd5e1;
    border-radius:12px;
    font-size:13px;
    cursor:pointer;
}

.pay-btn{
    width:100%;
    margin-top:24px;
    padding:16px;
    background:#2563EB;
    color:white;
    border:none;
    border-radius:12px;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    transition:.2s;
}

.pay-btn:hover{
    background:#1d4ed8;
    transform:translateY(-1px);
}

</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="payment-page">

<div class="payment-modal">

<div class="payment-modal-header">
<p>Pesanan #<?= $order['id'] ?></p>
<h2>Selesaikan Pembayaran</h2>
<div class="payment-total">Rp <?= number_format($order['total']) ?></div>
</div>

<div class="payment-modal-body">

<form method="POST" enctype="multipart/form-data" id="paymentForm">

<span class="method-label">Pilih Metode Pembayaran</span>

<div class="method-grid">

<label class="method-option">
<input type="radio" name="method" value="Transfer Bank" required onclick="showInfo('Transfer Bank')">
<div class="method-card">
<i class="fa-solid fa-building-columns"></i>
<span>Transfer Bank</span>
</div>
</label>

<label class="method-option">
<input type="radio" name="method" value="QRIS" onclick="showInfo('QRIS')">
<div class="method-card">
<i class="fa-solid fa-qrcode"></i>
<span>QRIS</span>
</div>
</label>

<label class="method-option">
<input type="radio" name="method" value="E-Wallet" onclick="showInfo('E-Wallet')">
<div class="method-card">
<i class="fa-solid fa-wallet"></i>
<span>E-Wallet</span>
</div>
</label>

<label class="method-option">
<input type="radio" name="method" value="COD" onclick="showInfo('COD')">
<div class="method-card">
<i class="fa-solid fa-truck"></i>
<span>COD</span>
</div>
</label>

</div>

<div class="method-info" id="info-Transfer Bank">
<div class="method-info-row"><span>Bank</span><b><?= htmlspecialchars($setting['bank_name'] ?? '-') ?></b></div>
<div class="method-info-row"><span>No. Rekening</span><b><?= htmlspecialchars($setting['bank_account_number'] ?? '-') ?></b></div>
<div class="method-info-row"><span>Atas Nama</span><b><?= htmlspecialchars($setting['bank_account_name'] ?? '-') ?></b></div>
</div>

<div class="method-info" id="info-QRIS">
<?php if(!empty($setting['qris_image'])){ ?>
<p style="font-size:13px; color:#555;">Scan kode QRIS berikut untuk membayar:</p>
<img src="../uploads/qris/<?= $setting['qris_image'] ?>" alt="QRIS">
<?php } else { ?>
<p style="font-size:13px; color:#999;">QRIS belum tersedia, silakan pilih metode lain.</p>
<?php } ?>
</div>

<div class="method-info" id="info-E-Wallet">
<p style="font-size:14px; color:#333;"><?= nl2br(htmlspecialchars($setting['ewallet_info'] ?? '-')) ?></p>
</div>

<div class="method-info" id="info-COD">
<p style="font-size:14px; color:#333;">Bayar tunai langsung ke kurir saat barang sampai di alamat kamu.</p>
</div>

<div class="upload-box">
<label>Upload Bukti Pembayaran (kosongkan jika COD)</label>
<input type="file" name="proof" accept="image/*">
</div>

<button type="submit" name="pay" class="pay-btn">Kirim Pembayaran</button>

</form>

</div>

</div>

</div>

<script>
function showInfo(value){
    document.querySelectorAll('.method-info').forEach(el => el.classList.remove('active'));
    var el = document.getElementById('info-' + value);
    if(el){ el.classList.add('active'); }
}
</script>

<?php include "../includes/footer.php"; ?>

</body>
</html>