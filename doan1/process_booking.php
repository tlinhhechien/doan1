<?php
// process_booking.php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $route_id = intval($_POST['route_id']);
    $toa_id   = intval($_POST['toa_id']);
    $so_ghe   = trim($_POST['so_ghe']);
    $user_id  = $_SESSION['user_id'];

    // Lấy giá vé từ bảng toa_tau
    $sql = "SELECT gia_ve FROM toa_tau WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $toa_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $toa = $result->fetch_assoc();
    if (!$toa) {
        die("Toa không tồn tại.");
    }
    $gia_ve = $toa['gia_ve'];

    // Lưu thông tin vé vào bảng ve_tau
    $sql_insert = "INSERT INTO ve_tau (id_nguoi_dung, id_tuyen_duong, id_toa_tau, so_ghe, gia_ve, trang_thai) VALUES (?, ?, ?, ?, ?, 'chưa thanh toán')";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiisd", $user_id, $route_id, $toa_id, $so_ghe, $gia_ve);
    if ($stmt_insert->execute()) {
        echo "Đặt vé thành công! Vui lòng tiến hành thanh toán sau.";
    } else {
        echo "Có lỗi xảy ra khi đặt vé: " . $conn->error;
    }
} else {
    header("Location: index.php");
}
?>
