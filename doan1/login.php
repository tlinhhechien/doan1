<?php
// login.php
session_start();
include 'config.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Lấy thông tin người dùng từ bảng nguoi_dung
    $sql = "SELECT id, ho_ten, mat_khau FROM nguoi_dung WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result  = $stmt->get_result();
    $user    = $result->fetch_assoc();
    
    // So sánh mật khẩu dạng plain text
    if ($user && $password === $user['mat_khau']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ho_ten']  = $user['ho_ten'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Email hoặc mật khẩu không đúng.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</head>
<body>
    <h1>Đăng nhập</h1>
    <?php if($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="checkbox" id="show_password" onclick="togglePassword()">
        <label for="show_password">Hiển thị mật khẩu</label>
        <br><br>
        <input type="submit" value="Đăng nhập">
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
    </form>
</body>
</html>
