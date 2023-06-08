<?php
session_start();

// Replace these values with your database's information.
$dbHost = 'localhost';
$dbName = 'u933773655_fixto';
$dbUser = 'u933773655_vipdopro02';
$dbPass = 'Dodz1997a@';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['groupName'])) {
    $groupName = $_POST['groupName'];

    $stmt = $conn->prepare("INSERT INTO groups (name) VALUES (?)");
    $stmt->bind_param('s', $groupName);

    if ($stmt->execute()) {
        echo "Group added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
