<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Kết nối tới cơ sở dữ liệu của bạn tại đây
$servername = "localhost";
$username = "u933773655_vipdopro02";
$password = "Dodz1997a@";
$dbname = "u933773655_fixto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " + $conn->connect_error);
}

$sql = "UPDATE links SET current_count = 0"; // Thay "links" với tên bảng chứa liên kết của bạn
if ($conn->query($sql) === TRUE) {
    header("Location: manage_links.php");
    exit;
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
