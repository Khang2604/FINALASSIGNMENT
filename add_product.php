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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $ten_san_pham = $_POST['ten_san_pham'];
    $gia = $_POST['gia'];
    $mo_ta = $_POST['mo_ta'];

    // Thực hiện truy vấn để thêm sản phẩm
    $sql = "INSERT INTO san_pham (ten_san_pham, gia, mo_ta) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $ten_san_pham, $gia, $mo_ta);

    if ($stmt->execute()) {
        // Đóng kết nối
        $stmt->close();
        $conn->close();
        // Chuyển hướng về trang danh sách sản phẩm
        header("Location: list_products.php");
        exit;
    } else {
        die("Lỗi khi thêm sản phẩm: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Thêm sản phẩm</h2>
        <a href="list_products.php" class="btn btn-secondary mb-3">Quay lại danh sách sản phẩm</a>
        <form action="add_product.php" method="post">
            <div class="form-group">
                <label for="ten_san_pham">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="ten_san_pham" name="ten_san_pham" required>
            </div>
            <div class="form-group">
                <label for="gia">Giá:</label>
                <input type="number" class="form-control" id="gia" name="gia" required>
            </div>
            <div class="form-group">
                <label for="mo_ta">Mô tả:</label>
                <textarea class="form-control" id="mo_ta" name="mo_ta" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
