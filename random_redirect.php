$random_url = $links[$random_key]['url'];
$link_id = $links[$random_key]['id'];

$sql = "UPDATE links SET current_count = current_count + 1, total_count = total_count + 1 WHERE id = $link_id";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error updating click count and count: " . $conn->error);
}

header("Location: $random_url");
exit();
