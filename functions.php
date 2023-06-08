<?php
include 'db_connection.php';

function register($username, $password)
{
    global $conn;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function login($username, $password)
{
    global $conn;

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];

            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function create_random_link($user_id)
{
    global $conn;

    $random_code = generate_random_string(16);

    $stmt = $conn->prepare("INSERT INTO user_random_links (user_id, random_code) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $random_code);

    if ($stmt->execute()) {
        return $random_code;
    } else {
        return false;
    }
}

function generate_random_string($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = '';

    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }

    return $random_string;
}
?>
