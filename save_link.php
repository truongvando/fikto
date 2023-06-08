<?php
session_start();
include 'db_connection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST['url']) || empty($_POST['url'])) {
    echo "Error: Missing or empty URL value.";
    exit();
}

$url = $_POST['url'];
$user_id = $_SESSION['user_id'];

// Kiểm tra xem người dùng đã có mã ngẫu nhiên chưa và tạo mã mới nếu cần
$random_code = getRandomCodeForUser($user_id);

// Lưu liên kết vào bảng links
$stmt = $conn->prepare("INSERT INTO links (user_id, url) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $url);

if ($stmt->execute()) {
    $generated_link = "https://" . $_SERVER['HTTP_HOST'] . "/relink/" . $random_code;
    echo "Link saved successfully. Your generated link is: <a href='$generated_link'>$generated_link</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
