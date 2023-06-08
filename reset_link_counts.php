<?php
// Kết nối đến cơ sở dữ liệu (thay đổi thông tin kết nối nếu cần)
$servername = "localhost";
$username = "u933773655_vipdopro02	";
$password = "Dodz1997a@";
$dbname = "u933773655_fixto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE links SET current_count = 1";
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}

$conn->close();
?>
