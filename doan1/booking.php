<?php
include '../includes/header.php';
include '../config.php';

if (!isset($_GET['tuyen_id'])) {
    echo "<p>Không xác định được tuyến đường</p>";
    exit;
}

$tuyen_id = intval($_GET['tuyen_id']);

// Lấy thông tin tuyến đường
$sql    = "SELECT * FROM tuyen_duong WHERE id = $tuyen_id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo "<p>Tuyến đường không tồn tại</p>";
    exit;
}
$tuyen = $result->fetch_assoc();
?>

<h2>Đặt vé cho tuyến: <?php echo $tuyen['diem_di'] . " - " . $tuyen['diem_den']; ?></h2>
<p><strong>Thời gian đi:</strong> <?php echo $tuyen['thoi_gian_di']; ?></p>
<p><strong>Thời gian đến:</strong> <?php echo $tuyen['thoi_gian_den']; ?></p>

<!-- Form đặt vé -->
<form action="../process_booking.php" method="post">
    <input type="hidden" name="tuyen_id" value="<?php echo $tuyen['id']; ?>">
    <label for="id_toa">Chọn toa tàu:</label>
    <select name="id_toa" id="id_toa">
        <?php
        // Lấy danh sách toa thuộc tàu chạy tuyến đường
        $id_tau = intval($tuyen['id_tau']);
        $sql_toa    = "SELECT * FROM toa_tau WHERE id_tau = $id_tau";
        $result_toa = $conn->query($sql_toa);
        if ($result_toa->num_rows > 0) {
            while ($toa = $result_toa->fetch_assoc()) {
                echo "<option value='" . $toa['id'] . "'>Toa số: " . $toa['so_toa'] . " - " . $toa['loai_toa'] . " - Giá vé: " . $toa['gia_ve'] . "</option>";
            }
        } else {
            echo "<option>Không có toa tàu</option>";
        }
        ?>
    </select>
    <br>
    <label for="so_ghe">Số ghế:</label>
    <input type="text" name="so_ghe" id="so_ghe" required>
    <br>
    <input type="submit" value="Đặt vé">
</form>

<?php include '../includes/footer.php'; ?>
