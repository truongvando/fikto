<?php
session_start();
include 'db_connection.php';

$link = $_POST['link'];
$user_id = $_SESSION['user_id']; // Lấy user_id từ session

// Chèn liên kết mới với user_id
$sql = "INSERT INTO links (link, percentage, user_id) VALUES (?, 0, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing insert query: " . $conn->error);
}

$stmt->bind_param('si', $link, $user_id);
$success = $stmt->execute();
if ($success) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
