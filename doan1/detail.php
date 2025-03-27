<?php
// detail.php
session_start();
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$route_id = intval($_GET['id']);

// Lấy thông tin tuyến đường và tàu
$sql  = "SELECT tuyen_duong.*, tau.ten_tau, tau.id as tau_id FROM tuyen_duong JOIN tau ON tuyen_duong.id_tau = tau.id WHERE tuyen_duong.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $route_id);
$stmt->execute();
$result = $stmt->get_result();
$route  = $result->fetch_assoc();

if (!$route) {
    echo "Tuyến đường không tồn tại.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết tuyến đường</title>
</head>
<body>
    <h1>Chi tiết tuyến đường</h1>
    <p><strong>Điểm đi:</strong> <?php echo htmlspecialchars($route['diem_di']); ?></p>
    <p><strong>Điểm đến:</strong> <?php echo htmlspecialchars($route['diem_den']); ?></p>
    <p><strong>Thời gian đi:</strong> <?php echo htmlspecialchars($route['thoi_gian_di']); ?></p>
    <p><strong>Thời gian đến:</strong> <?php echo htmlspecialchars($route['thoi_gian_den']); ?></p>
    <p><strong>Tàu:</strong> <?php echo htmlspecialchars($route['ten_tau']); ?></p>

    <?php if(isset($_SESSION['user_id'])): ?>
        <p><a href="book_ticket.php?route_id=<?php echo $route['id']; ?>">Đặt vé</a></p>
    <?php else: ?>
        <p>Bạn cần <a href="login.php">đăng nhập</a> để đặt vé.</p>
    <?php endif; ?>

    <p><a href="index.php">Quay lại</a></p>
</body>
</html>
