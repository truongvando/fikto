<?php
session_start();
include 'db_connection.php'; // Tập tin cấu hình cơ sở dữ liệu của bạn

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo "success";
    } else {
        echo "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
} else {
    echo "Tên đăng nhập hoặc mật khẩu không đúng.";
}
$_SESSION['username'] = $user['username'];

$stmt->close();
$conn->close();
?>
