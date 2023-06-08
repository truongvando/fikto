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

$sql = "SELECT * FROM groups";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "No groups found.";
}

$conn->close();
?>
