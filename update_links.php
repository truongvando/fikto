<?php
session_start();
include 'db_connection.php';
$data = json_decode(file_get_contents('php://input'), true);

if ($_SESSION['logged_in'] === true) {
    $error = false;
    $conn->autocommit(false);

    foreach ($data as $row) {
        $id = intval($row['id']);
        $link = $conn->real_escape_string($row['link']);
        $percentage = floatval($row['percentage']);

        $sql = "UPDATE links SET link = '$link', percentage = $percentage WHERE id = $id";

        if (!$conn->query($sql)) {
            $error = true;
            break;
        }
    }

    if ($error) {
        $conn->rollback();
        echo json_encode(['status' => 'error']);
    } else {
        $conn->commit();
        echo json_encode(['status' => 'success']);
    }
} else {
    echo json_encode(['status' => 'error']);
}

$conn->close();
