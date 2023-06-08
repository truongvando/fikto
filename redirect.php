<?php
include 'db_connection.php';

$group_id = $_GET['group_id'];

$stmt = $conn->prepare("SELECT * FROM links WHERE group_id = ?");
$stmt->bind_param("i", $group_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $links = array();

    while ($row = $result->fetch_assoc()) {
        for ($i = 0; $i < $row['percentage']; $i++) { 
            $links[] = $row;
        }
    }

    $selected_row = $links[array_rand($links)];
    $selected_link = $selected_row['link'];
    $link_id = $selected_row['id'];

    // Update click counts
    $stmt = $conn->prepare("UPDATE links SET current_count = current_count + 1, total_count = total_count + 1 WHERE id = ?");
    $stmt->bind_param("i", $link_id);
    $stmt->execute();

    // Redirect to the selected link
        header("Location: " . $selected_link);
    exit();
} else {
    // No links found for the specified group
    echo "No links available for this group.";
}

$stmt->close();
$conn->close();
?>
