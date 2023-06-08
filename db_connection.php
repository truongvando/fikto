<?php
$servername = "localhost";
$username = "u933773655_vipdopro02";
$password = "Dodz1997a@";
$dbname = "u933773655_fixto";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function getRandomCodeForUser($user_id) {
    global $conn;
    $sql = "SELECT random_code FROM user_random_links WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['random_code'];
    } else {
        // Generate a new random code
        $new_random_code = generateRandomCode(); // Replace this with your own random code generation function

        // Insert the new random code into the database
        $sql_insert = "INSERT INTO user_random_links (user_id, random_code) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("is", $user_id, $new_random_code);
        $stmt_insert->execute();

        return $new_random_code;
    }
}


?>
