<?php
session_start();
include 'db_connection.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

function create_random_link($user_id, $conn) {
    $sql = "SELECT random_code FROM user_random_links WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $random_code = $row['random_code'];

        $random_link = "https://" . $_SERVER['HTTP_HOST'] . "/" . $random_code;
        return $random_link;
    }

    return false;
}

function generateRandomCode($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    $errors = false;

    $conn->begin_transaction();

    $user_id = $_SESSION['user_id'];

    $random_link = create_random_link($user_id, $conn);

    if (!$random_link) {
        $random_code = generateRandomCode();
        $sql = "INSERT INTO user_random_links (user_id, random_code) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $user_id, $random_code);
        if (!$stmt->execute()) {
            $errors = true;
        } else {
            $random_link = "https://" . $_SERVER['HTTP_HOST'] . "/" . $random_code;
        }
    }

    foreach ($data as $row) {
        $id = $row['id'];
        $percentage = $row['percentage'];

        $sql = "UPDATE links SET percentage = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('dii', $percentage, $id, $user_id);

        if (!$stmt->execute()) {
            $errors = true;
            break;
        }
    }

    if (!$errors) {
        $sql_reset_counts = "UPDATE links SET current_count = 1 WHERE user_id = ?";
        $stmt_reset_counts = $conn->prepare($sql_reset_counts);
        $stmt_reset_counts->bind_param('i', $user_id);

        if (!$stmt_reset_counts->execute()) {
            $errors = true;
        }
    }

    if ($errors) {
        $conn->rollback();
        echo json_encode(['status' => 'error']);
    } else {
        $conn->commit();
        echo json_encode(['status' => 'success', 'random_link' => $random_link]);
    }
}
$conn->close();
?>
