<?php
session_start();
include 'db_connection.php';

$link_id = $_POST['id'];
$notes = $_POST['notes'];

$sql = "UPDATE links SET notes = ? WHERE id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing update query: " . $conn->error);
}

$stmt->bind_param('si', $notes, $link_id);

$success = $stmt->execute();
if (!$success) {
    die("Error updating notes: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
