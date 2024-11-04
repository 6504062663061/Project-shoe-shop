<?php Include "../../connect.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="../../css/index.css">
    
    <style>
        /* General styles for buttons */
        .button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            color: white;
        }

        /* Specific button styles */
        .is-success {
            background-color: #28a745; /* Green for Add to Cart */
        }

        .is-success:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .is-info {
            background-color: #17a2b8; /* Blue for Add to Favorites */
        }

        .is-info:hover {
            background-color: #138496; /* Darker blue on hover */
        }

        /* Input styles for quantity */
        .qty-input {
            width: 60px;
            padding: 5px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Button container styles */
        .button-container {
            display: flex;
            align-items: center;
            gap: 10px; /* Space between buttons */
            margin-top: 10px; /* Space above buttons */
        }
    </style>
</head>
<body>
    <?php include '../../Template/navbar.php'; ?>
    
    <?php
        if (isset($_GET['Shoes_ID'])) {
            $stmt = $pdo->prepare("SELECT * FROM Shoes WHERE Shoes_ID = ?");
            $stmt->bindParam(1, $_GET['Shoes_ID']);
            $stmt->execute();
            $row = $stmt->fetch();
        }
    ?>
    
    <?php if ($row): ?>
        <?php 
            $extensions = ['jpg', 'png', 'jpeg'];
            $imagePath = '';

            foreach ($extensions as $ext) {
                if (file_exists("../../sphoto/{$row['Shoes_ID']}.$ext")) {
                    $imagePath = "../../sphoto/{$row['Shoes_ID']}.$ext";
                    break;
                }
            }
        ?>
        
        <!-- Display Shoe -->
        <div class="columns">
            <div class="product column is-half" style="margin: 15px;">
                <?php if ($imagePath): ?>
                    <img src='<?=$imagePath?>' width='1000' alt="<?=$row['name']?>">
                <?php else: ?>
                    <p style="color: red;">Image not available.</p>
                <?php endif; ?>
                <br>
            </div>
            
            <section class="section is-large column is-half">
                <h1 class="title"><?=$row["name"]?></h1>
                <h2 class="subtitle"><?=$row["title"]?></h2>
                <h2><?=$row["price"]?><span> บาท</span></h2>
                
                <?php if (!isset($_SESSION['username'])): ?>
                    <h5 style="color: red;">กรุณาเข้าสู่ระบบเพื่อซื้อสินค้า</h5>
                <?php else: ?>
                    <div class="button-container">
                        <form method="post" action="../cart.php?action=add&Shoes_ID=<?=$row["Shoes_ID"]?>&pname=<?=$row["name"]?>&price=<?=$row["price"]?>">
                            <input type="number" name="qty" value="1" min="1" max="<?=$row["stock"]?>" class="qty-input">
                            <input class="button is-success" type="submit" value="Add to Cart">
                        </form>
                        
                        <form method="post" action="../Favorites.php?action=add&Shoes_ID=<?=$row["Shoes_ID"]?>" style="display: inline;">
                            <input class="button is-info" type="submit" value="Add to Favorites">
                        </form>
                    </div>
                <?php endif; ?>
            </section>
        </div>
        
        <section class="section is-medium">
            <h3 class="title">รายละเอียดสินค้า</h3>
            <h4 class="subtitle"><?=$row["detail"]?></h4>
        </section>
    
    <?php else: ?>
        <p>ไม่พบรายละเอียดสินค้า</p>
    <?php endif; ?>

    <?php include '../../Template/footer.php'; ?>
</body>
</html>
