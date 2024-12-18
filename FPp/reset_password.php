<?php
require 'fungsi/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Update password di database.
    $stmt = $conn->prepare("UPDATE akun SET kata_sandi = ? WHERE email = ?");
    $stmt->bind_param('ss', $new_password, $email);

    if ($stmt->execute()) {
        $success = "Password berhasil diubah. Silakan login.";
    } else {
        $error = "Terjadi kesalahan. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cyborg/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Reset Password</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Masukkan Email Anda</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="new_password">Password Baru</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
</body>
</html>
