<?php
// config.php
$servername = "localhost";
$username   = "root";       // Thay đổi theo cấu hình của bạn
$password   = "";           // Thay đổi theo cấu hình của bạn
$dbname     = "ban_ve_tau";   // Tên cơ sở dữ liệu đã tạo

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
