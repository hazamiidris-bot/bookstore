<?php
session_start();
if(!isset($_SESSION['id'])){ header("Location: login.php"); exit; }

include "../config/database.php";

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();

$success = "";
$error = "";

if(isset($_POST['save'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];

    $check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $check->execute([$email, $_SESSION['id']]);

    if($check->rowCount() > 0){
        $error = "Email sudah digunakan akun lain.";
    } else {

        $photo = $user['photo'];

        if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
            $photo = time()."_".$_FILES['photo']['name'];
            move_uploaded_file(
                $_FILES['photo']['tmp_name'],
                "../uploads/profile/".$photo
            );
        }

        $sql = $conn->prepare("UPDATE users SET fullname = ?, email = ?, photo = ? WHERE id = ?");
        $sql->execute([$fullname, $email, $photo, $_SESSION['id']]);

        $_SESSION['fullname'] = $fullname;

        $stmt->execute([$_SESSION['id']]);
        $user = $stmt->fetch();

        $success = "Profil berhasil diperbarui.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Profil Saya - Zook BookStore</title>
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
.profile-wrap{ max-width:500px; margin:40px auto; padding:0 20px; }
.profile-card{ background:white; padding:30px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,.08); text-align:center; }
.profile-card img{ width:120px; height:120px; object-fit:cover; border-radius:50%; margin-bottom:20px; border:3px solid #2563EB; }
.profile-card form{ text-align:left; margin-top:20px; }
.profile-card label{ display:block; margin-top:15px; margin-bottom:6px; font-weight:600; }
.profile-card input[type=text],
.profile-card input[type=email]{ width:100%; padding:12px; border:1px solid #ddd; border-radius:10px; }
.profile-card button{ margin-top:20px; width:100%; padding:12px; background:#2563EB; color:white; border:none; border-radius:10px; cursor:pointer; font-weight:600; }
.msg-success{ background:#dcfce7; color:#166534; padding:10px; border-radius:8px; margin-bottom:15px; }
.msg-error{ background:#fee2e2; color:#991b1b; padding:10px; border-radius:8px; margin-bottom:15px; }
</style>
</head>
<body>

<?php include "../includes/navbar.php"; ?>

<div class="profile-wrap">

<div class="profile-card">

<?php if($user['photo']){ ?>
<img src="../uploads/profile/<?= $user['photo'] ?>" alt="">
<?php } else { ?>
<img src="https://ui-avatars.com/api/?name=<?= urlencode($user['fullname']) ?>&background=2563EB&color=fff" alt="">
<?php } ?>

<h2><?= htmlspecialchars($user['fullname']) ?></h2>
<p style="color:gray;"><?= htmlspecialchars($user['email']) ?></p>

<?php if($success){ ?>
<div class="msg-success"><?= $success ?></div>
<?php } ?>

<?php if($error){ ?>
<div class="msg-error"><?= $error ?></div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

<label>Nama Lengkap</label>
<input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required>

<label>Email</label>
<input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

<label>Foto Profil</label>
<input type="file" name="photo" accept="image/*">

<button type="submit" name="save">Simpan Perubahan</button>

</form>

</div>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>
