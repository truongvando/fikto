<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: linear-gradient(to right, #2980b9, #6dd5ed);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .content {
            text-align: center;
            max-width: 600px;
            padding: 30px;
            background-color: rgba(44, 62, 80, 0.75);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .logo {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        button {
            padding: 12px 25px;
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            background-color: #ecf0f1;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            transition: all 0.3s;
        }

        button:hover {
            background-color: #3498db;
            color: white;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="logo">Trang web của một con gà</div>
        <div class="buttons-container">
            <button onclick="window.location.href='login.php';">Đăng nhập</button>
            <button onclick="window.location.href='register.php';">Đăng ký</button>
        </div>
    </div>
</body>
</html>
