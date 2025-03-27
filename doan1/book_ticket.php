<?php
// book_ticket.php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['route_id'])) {
    header("Location: index.php");
    exit;
}

$route_id = intval($_GET['route_id']);

// Lấy thông tin tuyến đường và tàu
$sql  = "SELECT tuyen_duong.*, tau.id as tau_id, tau.ten_tau FROM tuyen_duong JOIN tau ON tuyen_duong.id_tau = tau.id WHERE tuyen_duong.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $route_id);
$stmt->execute();
$result = $stmt->get_result();
$route  = $result->fetch_assoc();

if (!$route) {
    echo "Tuyến đường không tồn tại.";
    exit;
}

// Lấy danh sách các toa của tàu được chọn
$sql_toa = "SELECT * FROM toa_tau WHERE id_tau = ?";
$stmt_toa = $conn->prepare($sql_toa);
$stmt_toa->bind_param("i", $route['tau_id']);
$stmt_toa->execute();
$toas = $stmt_toa->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt vé</title>
</head>
<body>
    <h1>Đặt vé cho tuyến đường</h1>
    <p><strong>Điểm đi:</strong> <?php echo htmlspecialchars($route['diem_di']); ?></p>
    <p><strong>Điểm đến:</strong> <?php echo htmlspecialchars($route['diem_den']); ?></p>
    <p><strong>Thời gian đi:</strong> <?php echo htmlspecialchars($route['thoi_gian_di']); ?></p>
    <p><strong>Tàu:</strong> <?php echo htmlspecialchars($route['ten_tau']); ?></p>

    <form action="process_booking.php" method="post">
        <input type="hidden" name="route_id" value="<?php echo $route['id']; ?>">
        <label for="toa_id">Chọn toa:</label>
        <select name="toa_id" id="toa_id" required>
            <?php while($toa = $toas->fetch_assoc()): ?>
                <option value="<?php echo $toa['id']; ?>">
                    <?php echo htmlspecialchars($toa['loai_toa']); ?> - Giá vé: <?php echo $toa['gia_ve']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br><br>
        <label for="so_ghe">Số ghế:</label>
        <input type="text" name="so_ghe" id="so_ghe" required>
        <br><br>
        <input type="submit" value="Đặt vé">
    </form>
    <p><a href="detail.php?id=<?php echo $route['id']; ?>">Quay lại</a></p>
</body>
</html>
