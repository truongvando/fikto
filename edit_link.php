<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Link Percentages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        input[type="number"] {
            width: 100%;
        }

        #update-btn {
    background-color: #4CAF50;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    cursor: pointer;
    border: none;
}
    </style>
    <script>
       function updateTotalPercentage() {
    const percentageInputs = document.querySelectorAll('.percentage-input');
    let totalPercentage = 0;

    percentageInputs.forEach(input => {
        totalPercentage += parseFloat(input.value);
    });

    const updateBtn = document.getElementById('update-btn');
    if (totalPercentage === 100) {
        updateBtn.removeAttribute('disabled');
    } else {
        updateBtn.setAttribute('disabled', 'true');
    }
}

function updatePercentages() {
    const percentageInputs = document.querySelectorAll('.percentage-input');
    const linkInputs = document.querySelectorAll('.link-input');
    let data = [];

    for (let i = 0; i < percentageInputs.length; i++) {
        data.push({
            id: percentageInputs[i].dataset.id,
            link: linkInputs[i].value,
            percentage: percentageInputs[i].value
        });
    };
    // Add AJAX request to update the percentages in the database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_links.php', true); // changed to the new file
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === 'success') {
                location.reload();
            } else {
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            }
        }
    };
    xhr.send(JSON.stringify(data));
}

        window.onload = function() {
            document.querySelectorAll('.percentage-input').forEach(input => {
                input.addEventListener('input', updateTotalPercentage);
            });

            document.getElementById('update-btn').addEventListener('click', updatePercentages);
        };
    </script>
</head>
<body>
    <h1>Edit Link Percentages</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Link</th>
            <th>Percentage</th>
        </tr>
        <?php
            include 'db_connection.php';

            $sql = "SELECT * FROM access_counts";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["id"]."</td>
                            <td><input type='text' class='link-input' data-id='".$row["id"]."' value='".$row["link"]."'></td>
                            <td>
                                <input type='number' min='0' max='100' step='0.01' class='percentage-input' data-id='".$row["id"]."' value='".$row["percentage"]."'>
                            </td>
</tr>";
}
} else {
echo "<tr><td colspan='3'>0 results</td></tr>";
}
        $conn->close();
    ?>
</table>
<button id="update-btn" onclick="updatePercentages();" disabled>Cập nhật phần trăm</button>

</body>
</html>
