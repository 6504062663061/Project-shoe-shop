<?php
include "../connect.php";
session_start();

$stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Username = ? AND Password = ?");
$stmt->bindParam(1, $_POST["Username"]);
$stmt->bindParam(2, $_POST["Password"]);
$stmt->execute();
$row = $stmt->fetch();

if (!empty($row)) { 
    $_SESSION["fullname"] = $row["Name"];   
    $_SESSION["username"] = $row["Username"];
    $_SESSION["usertype"] = $row["Status"];
    header("Location: ../index.php"); 
    exit();
} else {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login Failed - ChicFoot</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #2fab91, #63e0ac);
            }

            .message-container {
                width: 100%;
                max-width: 400px;
                padding: 40px;
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 10px;
                box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
                text-align: center;
            }

            .error-text {
                color: red;
                font-size: 18px;
                margin-bottom: 20px;
            }

            .button {
                width: 100%;
                padding: 15px;
                background-color: #2fab91;
                color: white;
                font-size: 16px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                box-sizing: border-box;
            }

            .button:hover {
                background-color: #63e0ac;
            }
        </style>
    </head>
    <body>
        <div class="message-container">
            <p class="error-text">ไม่สำเร็จ ชื่อหรือรหัสผ่านไม่ถูกต้อง</p>
            <a href="loginform.php" class="button">เข้าสู่ระบบอีกครั้ง</a>
        </div>
    </body>
    </html>';
    exit();
}
?>
