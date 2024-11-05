<?php include "../../connect.php"; ?>

<?php
$limit = 6; // จำนวนสินค้าต่อหน้า
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // หมายเลขหน้าที่ส่งมาจาก AJAX
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("SELECT * FROM shoes LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$extensions = ['jpg', 'png', 'jpeg'];
?>  
<div class="shoe-list">
    <?php while ($row = $stmt->fetch()) : 
        $imagePath = '';
        foreach ($extensions as $ext) {
            if (file_exists("../../sphoto/{$row['Shoes_ID']}.$ext")) {
                $imagePath = "../../sphoto/{$row['Shoes_ID']}.$ext";
                break;
            }
        }
        if ($imagePath == '') {
            $imagePath = "../pphoto/default-image.jpg";
        }
    ?>
        <div style="
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 200px;
            margin: 10px; /* Adjusted margin for spacing */
            font-family: Arial, sans-serif;
            ">
            <a href="shoedetail.php?Shoes_ID=<?=$row["Shoes_ID"]?>" style="text-decoration: none; color: inherit;">
                <img src='<?=$imagePath?>' width='120' style="border-radius: 8px; margin-bottom: 12px;">
                <h2 style="font-size: 18px; font-weight: 600; margin: 10px 0; color: #333;"><?=$row["name"]?></h2>
            </a>
            <p style="font-size: 14px; color: #666; margin: 0 0 10px;"><?=$row["title"]?></p>
            <p class="title" style="font-size: 16px; color: #e74c3c; font-weight: 600;"><?=$row["price"]?> บาท</p>
        </div>
    <?php endwhile; ?>
</div>

<?php
// นับจำนวนสินค้าทั้งหมดสำหรับคำนวณจำนวนหน้า
$countQuery = $pdo->prepare("SELECT COUNT(*) AS total FROM shoes");
$countQuery->execute();
$total = $countQuery->fetch()['total'];
$totalPages = ceil($total / $limit);
?>

<div id="pagination" style="text-align: center; margin-top: 20px;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <button onclick="loadAllProducts(<?=$i?>)" style="
            padding: 8px 12px;
            margin: 0 5px;
            border: none;
            background-color: <?=$page == $i ? '#3498db' : '#ddd'?>;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        ">
            <?=$i?>
        </button>
    <?php endfor; ?>
</div>
