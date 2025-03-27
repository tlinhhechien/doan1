<?php
// index.php
session_start();
include 'config.php';

// Lấy danh sách tuyến đường và thông tin tàu
$sql    = "SELECT tuyen_duong.*, tau.ten_tau FROM tuyen_duong JOIN tau ON tuyen_duong.id_tau = tau.id ORDER BY thoi_gian_di ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Bán vé ga tàu</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h1>Danh sách tuyến đường tàu</h1>

    <?php if(isset($_SESSION['user_id'])): ?>
      <p>Chào bạn, <?php echo htmlspecialchars($_SESSION['ho_ten'] ?? ''); ?> | <a href="logout.php">Đăng xuất</a></p>
    <?php else: ?>
      <p><a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a></p>
    <?php endif; ?>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Điểm đi</th>
                <th>Điểm đến</th>
                <th>Thời gian đi</th>
                <th>Thời gian đến</th>
                <th>Tàu</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php if($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['diem_di']); ?></td>
                    <td><?php echo htmlspecialchars($row['diem_den']); ?></td>
                    <td><?php echo htmlspecialchars($row['thoi_gian_di']); ?></td>
                    <td><?php echo htmlspecialchars($row['thoi_gian_den']); ?></td>
                    <td><?php echo htmlspecialchars($row['ten_tau']); ?></td>
                    <td><a href="detail.php?id=<?php echo $row['id']; ?>">Xem chi tiết</a></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Không có tuyến đường nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
