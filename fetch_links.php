<?php
session_start();
include 'db_connection.php';

$group_id = $_SESSION['group_id']; // Lấy group_id từ session

if ($group_id == 0) {
    // Nếu group_id là 0 (admin), lấy tất cả các liên kết
    $sql = "SELECT * FROM links";
} else {
    // Nếu không phải admin, chỉ lấy liên kết của nhóm hiện tại
    $sql = "SELECT * FROM links WHERE group_id = ?";
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing select query: " . $conn->error);
}

if ($group_id != 0) {
    $stmt->bind_param('i', $group_id);
}

$success = $stmt->execute();
if (!$success) {
    die("Error fetching links: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td><input type='text' class='link-input' data-id='".$row["id"]."' value='".$row["link"]."'/></td>
                <td>".$row["current_count"]."</td>
                <td><input type='text' class='percentage-input' step='0.01' min='0' max='100' data-id='".$row["id"]."' value='".$row["percentage"]."'/></td>
                <td>".$row["total_count"]."</td>
                <td><input type='text' class='notes-input' data-id='".$row["id"]."' value='".$row["notes"]."'/></td> <!-- Thêm vào đây -->
                <td>
                    <button class='delete-link' data-id='".$row["id"]."'>Delete</button>
                </td>
            </tr>";
    }

} else {
    echo "<tr><td colspan='5'>0 results</td></tr>";
}

$stmt->close();
$conn->close();
?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.link-input').on('change', function() {
            var id = $(this).data('id');
            var link = $(this).val();
            $.post('update_link.php', {id: id, link: link}, function(response) {
                // handle response
            });
        });
        // Xử lí ghi chú
        $('.notes-input').on('change', function() {
    var id = $(this).data('id');
    var notes = $(this).val();
    $.post('update_notes.php', {id: id, notes: notes}, function(response) {
        // handle response
    });
});


        // Thêm đoạn code để cập nhật % khi thay đổi giá trị
        $('.percentage-input').on('change', function() {
            var id = $(this).data('id');
            var percentage = $(this).val();
            $.post('update_percentage.php', {id: id, percentage: percentage}, function(response) {
                // handle response
            });
        });
    });
</script>