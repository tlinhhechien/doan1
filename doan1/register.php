<?php
// register.php
session_start();
include 'config.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ho_ten          = trim($_POST['ho_ten']);
    $email           = trim($_POST['email']);
    $password        = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);

    if ($password != $password_confirm) {
        $error = "Mật khẩu không khớp.";
    } else {
        // Mã hóa mật khẩu
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO nguoi_dung (ho_ten, email, mat_khau, vai_tro) VALUES (?, ?, ?, 'khach_hang')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $ho_ten, $email, $password_hash);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Có lỗi xảy ra, vui lòng thử lại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title><link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h1>Đăng ký</h1>
    <?php if($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <label for="ho_ten">Họ tên:</label>
        <input type="text" name="ho_ten" id="ho_ten" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <label for="password_confirm">Xác nhận mật khẩu:</label>
        <input type="password" name="password_confirm" id="password_confirm" required>
        <br><br>
        <input type="submit" value="Đăng ký">
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </form>
    
</body>
</html>
