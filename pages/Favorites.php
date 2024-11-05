<?php
session_start();
include "../connect.php";

// อ่าน favorites จาก Cookies (ถ้ามี)
$favorites = [];
if (isset($_COOKIE['favorites'])) {
    $favorites = json_decode($_COOKIE['favorites'], true) ?? [];
}

// ตรวจสอบ action
if (isset($_GET["action"])) {
    $Shoes_ID = $_GET['Shoes_ID'];
    $name = $_GET['name'] ?? '';  

    if ($Shoes_ID) {
        if ($_GET["action"] == "add") {
            $favorites[$Shoes_ID] = ['name' => $name];
            $message = "<p class='message success'>Item added to favorites.</p>";
        } elseif ($_GET["action"] == "delete") {
            unset($favorites[$Shoes_ID]);
            $message = "<p class='message success'>Item removed from favorites.</p>";
        }

        // ตั้งค่า favorites ลงใน Cookies ด้วยการตั้งค่าข้อมูลอย่างละเอียด
        setcookie('favorites', json_encode($favorites), [
            'expires' => time() + (86400 * 30), // 30 วัน
            'path' => '/',
            'secure' => isset($_SERVER['HTTPS']), // ถ้าใช้ HTTPS ให้ตั้งค่าเป็น secure
            'httponly' => true, 
            'samesite' => 'Lax',
        ]);

        // รีเฟรชหน้าเพื่อให้ Cookies ถูกอ่านอีกครั้ง
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot - Favorites</title>
    <link rel="stylesheet" href="../css/index.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        .bodycart {
            background-color: #f7f8fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
            padding: 20px;
        }
        .favorites-container {
            max-width: 1000px;
            width: 100%;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .favorite-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 280px; /* Set a fixed height for consistency */
        }
        .favorite-card img {
            max-width: 100%;
            height: 150px; /* Set a fixed height for images */
            object-fit: cover; /* Crop to fit within the defined area */
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .favorite-card h3 {
            font-size: 18px;
            color: #333;
            margin: 10px 0;
            flex-grow: 1;
        }
        .favorite-card .actions {
            margin-top: 10px;
            display: flex;
            justify-content: center;
        }
        .favorite-card .actions a {
            color: #3498db;
            font-size: 14px;
            text-decoration: none;
            border: 1px solid #3498db;
            border-radius: 4px;
            padding: 6px 12px;
            transition: all 0.3s ease;
        }
        .favorite-card .actions a:hover {
            background-color: #3498db;
            color: #fff;
        }
        .message {
            text-align: center;
            margin-bottom: 10px;
            color: red;
        }
        .success {
            color: green;
        }
        .logo {
            display: block; 
            margin: 0 auto 20px; 
            width: 250px; 
            height: auto; 
        }
    </style>
</head>
<body>
    <?php include '../Template/navbar.php'; ?>
    <div class="bodycart">
        <div class="favorites-container">
            <img src="../logonew.png" alt="ChicFoot Logo" class="logo"> 
            <h2>Favorites</h2>

            <?php
            echo $message ?? "";  // แสดงข้อความ

            // ตรวจสอบว่ามีรายการโปรดหรือไม่
            if (!empty($favorites)) {
                ?>
                <div class="favorites-grid">
                    <?php
                    foreach ($favorites as $Shoes_ID => $item) {
                        $extensions = ['jpg', 'png', 'jpeg'];
                        $imagePath = '../sphoto/default-image.jpg';  
                        $foundImage = false;

                        foreach ($extensions as $ext) {
                            $tempPath = "../sphoto/{$Shoes_ID}.$ext";
                            if (file_exists($tempPath)) {
                                $imagePath = $tempPath;
                                $foundImage = true;
                                break;
                            }
                        }

                        if (!$foundImage) {
                            echo "<p class='message'>Image not found for Shoe ID: " . htmlspecialchars($Shoes_ID) . "</p>";
                        }
                        ?>
                        <div class="favorite-card">
                            <a href="./product/shoedetail.php?Shoes_ID=<?= $Shoes_ID ?>">
                                <img src="<?= htmlspecialchars($imagePath) ?>" alt="Favorite Product Image">
                            </a>

                            <h3><?= htmlspecialchars($item["name"]) ?></h3>
                            <div class="actions">
                                <a href="?action=delete&Shoes_ID=<?= htmlspecialchars($Shoes_ID) ?>">Remove from Favorites</a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                echo "<p class='message'>Your favorites list is empty!</p>";
            }
            ?>
        </div>
    </div>
    <?php include '../Template/footer.php'; ?>
</body>
</html>
