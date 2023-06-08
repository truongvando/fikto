<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db_connection.php';

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo "Error: Missing or empty ID value.";
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy user_id từ session

// Sử dụng prepared statements để tránh SQL injection
$stmt = $conn->prepare("DELETE FROM links WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
