<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['link'])) {
        $id = $_POST['id'];
        $link = $_POST['link'];

        include 'db_connection.php';

        $stmt = $conn->prepare("UPDATE links SET link = ? WHERE id = ?");
        $stmt->bind_param("si", $link, $id);

        if ($stmt->execute()) {
            echo "Link updated successfully";
        } else {
            echo "Error updating link: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Error: Missing ID or link";
    }
}
?>
