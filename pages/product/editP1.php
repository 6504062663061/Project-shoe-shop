<?php 
include "../../connect.php"; 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Product - ChicFoot</title>
    <link rel="stylesheet" href="../../css/index.css">
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            background-color: #fff;
            text-align: center;
        }
        .container h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        .container input[type="text"],
        .container input[type="number"],
        .container textarea,
        .container select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .container .button {
            margin-top: 20px;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }
        .container .button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
<?php include '../../Template/navbar.php'; ?>

<div class="container">
    <h2>Edit Product</h2>

    <?php
    // Check if Shoes_ID is set in URL
    if (isset($_GET['Shoes_ID'])) {
        $stmt = $pdo->prepare("SELECT * FROM shoes WHERE Shoes_ID = ?");
        $stmt->bindParam(1, $_GET['Shoes_ID']);
        $stmt->execute();
        $product = $stmt->fetch();
        
        // Display message if product is not found
        if (!$product) {
            echo "<p style='color: red;'>Product not found.</p>";
        }
    } else {
        echo "<p style='color: red;'>No product ID specified.</p>";
    }

    // Update product details if form is submitted
    if (isset($_POST['submit']) && isset($product)) {
        $name = $_POST['name'];
        $title = $_POST['title'];
        $detail = $_POST['detail'];
        $model = $_POST['Model'];
        $type = $_POST['type'];
        $price = $_POST['price'];
        
        // JSON format for stock_data
        $stock_data = json_encode([
            ["size" => $_POST['size1'], "color" => $_POST['color1'], "stock" => $_POST['stock1']],
            ["size" => $_POST['size2'], "color" => $_POST['color2'], "stock" => $_POST['stock2']]
        ]);

        $stmt = $pdo->prepare("UPDATE shoes SET name = ?, title = ?, detail = ?, Model = ?, type = ?, price = ?, stock_data = ? WHERE Shoes_ID = ?");
        $stmt->execute([$name, $title, $detail, $model, $type, $price, $stock_data, $_GET['Shoes_ID']]);

        echo "<p style='color: green;'>Product updated successfully!</p>";
    }
    ?>

    <?php if (isset($product) && $product): ?>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label for="title">Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($product['title']) ?>" required>

        <label for="detail">Detail:</label>
        <textarea name="detail" required><?= htmlspecialchars($product['detail']) ?></textarea>

        <label for="Model">Model:</label>
        <input type="text" name="Model" value="<?= htmlspecialchars($product['Model']) ?>" required>

        <label for="type">Type:</label>
        <select name="type" required>
            <option value="sneakers" <?= $product['type'] == 'sneakers' ? 'selected' : '' ?>>Sneakers</option>
            <option value="sport" <?= $product['type'] == 'sport' ? 'selected' : '' ?>>Sport Shoes</option>
            <option value="slippers" <?= $product['type'] == 'slippers' ? 'selected' : '' ?>>Slippers</option>
        </select>

        <label for="price">Price:</label>
        <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

        <h3>Stock Information</h3>
        <?php 
            $stock_data = json_decode($product['stock_data'], true);
            for ($i = 1; $i <= 2; $i++):
                $stock = isset($stock_data[$i - 1]) ? $stock_data[$i - 1] : ["size" => "", "color" => "", "stock" => ""];
        ?>
        <label for="size<?= $i ?>">Size <?= $i ?>:</label>
        <input type="number" name="size<?= $i ?>" value="<?= htmlspecialchars($stock['size']) ?>" required>

        <label for="color<?= $i ?>">Color <?= $i ?>:</label>
        <input type="text" name="color<?= $i ?>" value="<?= htmlspecialchars($stock['color']) ?>" required>

        <label for="stock<?= $i ?>">Stock <?= $i ?>:</label>
        <input type="number" name="stock<?= $i ?>" value="<?= htmlspecialchars($stock['stock']) ?>" required>
        <?php endfor; ?>

        <button type="submit" name="submit" class="button">Update Product</button>
    </form>
    <?php endif; ?>
</div>

<?php include '../../Template/footer.php'; ?>
</body>
</html>
