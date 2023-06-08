<?php
session_start();
include 'db_connection.php';

$link = $_POST['link'];
$user_id = $_SESSION['user_id']; // Lấy user_id từ session

// Tìm ID lớn nhất trong bảng
$sql = "SELECT MAX(id) as max_id FROM links";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$new_id = $row['max_id'] + 1;

// Chèn liên kết mới với ID mới và user_id
$sql = "INSERT INTO links (id, link, percentage, user_id) VALUES (?, ?, 0, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing insert query: " . $conn->error);
}

$stmt->bind_param('isi', $new_id, $link, $user_id);
$success = $stmt->execute();
if ($success) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
