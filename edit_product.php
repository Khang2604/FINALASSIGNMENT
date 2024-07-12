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

    // Truy vấn sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM san_pham WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        die("Sản phẩm không tồn tại.");
    }
} else {
    die("ID sản phẩm không hợp lệ.");
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Chỉnh sửa sản phẩm</h2>
        <a href="list_products.php" class="btn btn-primary mb-3">Quay lại</a>
        <form action="update_product.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
            <div class="form-group">
                <label for="ten_san_pham">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="ten_san_pham" name="ten_san_pham" value="<?php echo htmlspecialchars($product['ten_san_pham']); ?>" required>
            </div>
            <div class="form-group">
                <label for="gia">Giá:</label>
                <input type="number" class="form-control" id="gia" name="gia" value="<?php echo htmlspecialchars($product['gia']); ?>" required>
            </div>
            <div class="form-group">
                <label for="mo_ta">Mô tả:</label>
                <textarea class="form-control" id="mo_ta" name="mo_ta" rows="4" required><?php echo htmlspecialchars($product['mo_ta']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
