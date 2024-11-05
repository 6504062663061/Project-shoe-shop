<?php include "../../connect.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="../../css/index.css">
    
    <style>
        .button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            color: white;
            margin : 10px;
        }

        .is-success {
            background-color: #28a745;
        }

        .is-success:hover {
            background-color: #218838;
        }

        .is-info {
            background-color: #17a2b8;
        }

        .is-info:hover {
            background-color: #138496;
        }

        .qty-input {
            width: 60px;
            padding: 5px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include '../../Template/navbar.php'; ?>
    
    <?php
        if (isset($_GET['Shoes_ID'])) {
            $stmt = $pdo->prepare("SELECT * FROM shoes WHERE Shoes_ID = ?");
            $stmt->bindParam(1, $_GET['Shoes_ID']);
            $stmt->execute();
            $row = $stmt->fetch();

            // Decode stock_data JSON
            if ($row) {
                $stock_data = json_decode($row['stock_data'], true);
            }
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
                
                <form method="post" action="../cart.php?action=add&Shoes_ID=<?=$row["Shoes_ID"]?>">
                    <input type="hidden" name="pname" value="<?=htmlspecialchars($row["name"])?>">
                    <input type="hidden" name="price" value="<?=htmlspecialchars($row["price"])?>">

                    <label for="color">Color:</label>
                    <select name="color" id="color" required>
                        <option value="">Select Color</option>
                        <?php
                            $colors = array_unique(array_column($stock_data, 'color'));
                            foreach ($colors as $color) {
                                echo "<option value='$color'>$color</option>";
                            }
                        ?>
                    </select>
                    
                    <label for="size">Size:</label>
                    <select name="size" id="size" required>
                        <option value="">Select Size</option>
                        <?php
                            $sizes = array_unique(array_column($stock_data, 'size'));
                            foreach ($sizes as $size) {
                                echo "<option value='$size'>$size</option>";
                            }
                        ?>
                    </select>

                    <label for="qty">Quantity:</label>
                    <input type="number" name="qty" value="1" min="1" class="qty-input" required>

                    <div class="button-container">
                        <input class="button is-success" type="submit" value="Add to Cart">
                    </div>
                </form>

                <form method="post" action="../Favorites.php?action=add&Shoes_ID=<?=$row["Shoes_ID"]?>" style="display: inline;">
                    <input class="button is-info" type="submit" value="Add to Favorites">
                </form>
            </section>
        </div>
        
        <section class="section is-medium">
            <h3 class="title">รายละเอียดสินค้า</h3>
            <h4 class="subtitle"><?=htmlspecialchars($row["detail"])?></h4>
        </section>
    
    <?php else: ?>
        <p>ไม่พบรายละเอียดสินค้า</p>
    <?php endif; ?>

    <?php include '../../Template/footer.php'; ?>
</body>
</html>
