<?php
session_start();
include 'db_connection.php'; // Tập tin cấu hình cơ sở dữ liệu của bạn

$username = $_POST['username'];
$password = $_POST['password'];

// Kiểm tra xem tên người dùng đã tồn tại chưa
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Tên người dùng đã tồn tại";
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo "registered";
    } else {
        echo "Có lỗi xảy ra, vui lòng thử lại.";
    }
}

$stmt->close();
$conn->close();
?>
