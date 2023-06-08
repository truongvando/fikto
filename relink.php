<?php
include 'db_connection.php';

if (isset($_GET['random_code'])) {
    $random_code = $_GET['random_code'];

    $sql = "SELECT user_id FROM user_random_links WHERE random_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $random_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        $sql = "SELECT * FROM links WHERE user_id = ? AND percentage > 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $links = [];
            $total_percentage = 0;

            while ($row = $result->fetch_assoc()) {
                $links[] = $row;
                $total_percentage += $row['percentage'];
            }

            $rand = mt_rand(0, $total_percentage);
            $selected_link = null;

            foreach ($links as $link) {
                if ($rand <= $link['percentage']) {
                    $selected_link = $link;
                    break;
                }
                $rand -= $link['percentage'];
            }

            if ($selected_link) {
    // Cập nhật số lượt chuyển hướng (total_count) cho liên kết được chọn
    $update_total_count_sql = "UPDATE links SET total_count = total_count + 1 WHERE id = ?";
    $update_total_count_stmt = $conn->prepare($update_total_count_sql);
    $update_total_count_stmt->bind_param('i', $selected_link['id']);
    $update_total_count_stmt->execute();
    $update_total_count_stmt->close();
    
    // Cập nhật số lượt chuyển hướng hiện tại (current_count) cho liên kết được chọn
    $update_current_count_sql = "UPDATE links SET current_count = current_count + 1 WHERE id = ?";
    $update_current_count_stmt = $conn->prepare($update_current_count_sql);
    $update_current_count_stmt->bind_param('i', $selected_link['id']);
    $update_current_count_stmt->execute();
    $update_current_count_stmt->close();

    header("Location: " . $selected_link['link']);
} else {
    echo "Không tìm thấy liên kết phù hợp";
}

        } else {
            echo "Không có liên kết nào trong tài khoản này";
        }
    } else {
        echo "Mã ngẫu nhiên không hợp lệ";
    }
} else {
    echo "Mã ngẫu nhiên không được cung cấp";
}

$conn->close();
?>
