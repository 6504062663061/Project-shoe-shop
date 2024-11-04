<?php include "../../connect.php"; ?>

<?php
    $stmt = $pdo->prepare("SELECT * FROM shoes WHERE type = 'sport'");  // ใช้ชื่อตารางตัวเล็กตามที่ระบุ
    $stmt->execute();

    $extensions = ['jpg', 'png', 'jpeg'];
?>  
<?php while ($row = $stmt->fetch()) : 
    $imagePath = '';
    foreach ($extensions as $ext) {
        if (file_exists("../../sphoto/{$row['Shoes_ID']}.$ext")) {
            $imagePath = "../../sphoto/{$row['Shoes_ID']}.$ext";
            break;
        }
    }
    if ($imagePath == '') {
        $imagePath = "../../pphoto/default-image.jpg";
    }
?>
    <div style="
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 200px;
        margin: 10px auto;
        font-family: Arial, sans-serif;
        " class="column is-one-quarter">
        <a href="shoedetail.php?Shoes_ID=<?=$row["Shoes_ID"]?>" style="text-decoration: none; color: inherit;">
            <img src='<?=$imagePath?>' width='120' style="border-radius: 8px; margin-bottom: 12px;">
            <h2 style="font-size: 18px; font-weight: 600; margin: 10px 0; color: #333;"><?=$row["name"]?></h2>
        </a>
        <p style="font-size: 14px; color: #666; margin: 0 0 10px;"><?=$row["title"]?></p>
        <p class="title" style="font-size: 16px; color: #e74c3c; font-weight: 600;"><?=$row["price"]?> บาท</p>
    </div>
<?php endwhile; ?>
