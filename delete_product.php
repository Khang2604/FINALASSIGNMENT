<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db_connect.php';

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Kiểm tra và lấy ID sản phẩm từ URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Xóa sản phẩm khỏi cơ sở dữ liệu
    $sql = "DELETE FROM san_pham WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Đóng kết nối
        $stmt->close();
        $conn->close();
        // Chuyển hướng về trang danh sách sản phẩm
        header("Location: list_products.php");
        exit; // Ngừng thực thi mã sau khi chuyển hướng
    } else {
        // Đóng kết nối và hiển thị lỗi
        $stmt->close();
        $conn->close();
        die("Lỗi khi xóa sản phẩm: " . $stmt->error);
    }
} else {
    die("ID sản phẩm không hợp lệ.");
}

// Đoạn mã sau sẽ không bao giờ được thực thi do lệnh die hoặc exit
// Bạn có thể xóa đoạn mã này để tránh cảnh báo
?>
