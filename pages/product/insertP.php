<?php 
include "../../connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="../../css/index.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        textarea {
            resize: vertical; /* อนุญาตให้ปรับขนาดตามแนวตั้งเท่านั้น */
        }

        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #4cae4c; 
        }

        h3 {
            margin-top: 20px;
            margin-bottom: 10px;
            color: #555;
        }
    </style>
</head>
<body>
<?php include '../../Template/navbar.php'; ?>

<div class="container">
    <h2>Add New Shoe</h2>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" maxlength="20" required><br>

        <label for="title">Title:</label>
        <input type="text" name="title" maxlength="255" required><br>

        <label for="detail">Detail:</label>
        <textarea name="detail" required></textarea><br>

        <label for="Model">Model:</label>
        <input type="text" name="Model" maxlength="11" required><br>

        <label for="type">Type:</label>
        <input type="text" name="type" maxlength="10" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" required><br>

        <h3>Stock Information</h3>
        <label for="size">Size:</label>
        <input type="number" name="size" required><br>

        <label for="color">Color:</label>
        <input type="text" name="color" maxlength="50" required><br>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" required><br>

        <button type="submit" name="submit">Add Product</button>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $detail = $_POST['detail'];
    $model = $_POST['Model'];
    $type = $_POST['type'];
    $price = $_POST['price'];

    $size = $_POST['size'];
    $color = $_POST['color'];
    $stock = $_POST['stock'];

    // Create JSON format for stock_data
    $stock_data = json_encode([["size" => $size, "color" => $color, "stock" => $stock]]);

    // Insert data into database
    $stmt = $pdo->prepare("INSERT INTO shoes (name, title, detail, Model, type, price, stock_data) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1,$name);
    $stmt->bindParam(2,$title);
    $stmt->bindParam(3,$detail);
    $stmt->bindParam(4,$model);
    $stmt->bindParam(5,$type);
    $stmt->bindParam(6,$price);
    $stmt->bindParam(7,$stock_data);
    $stmt->execute();

    
}
?>

<?php include '../../Template/footer.php'; ?>
</body>
</html>
