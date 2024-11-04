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
    $sql = "INSERT INTO shoes (name, title, detail, Model, type, price, stock_data) 
            VALUES ('$name', '$title', '$detail', '$model', '$type', $price, '$stock_data')";

    if (mysqli_query($conn, $sql)) {
        echo "<p>New product added successfully!</p>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<?php include '../../Template/footer.php'; ?>
</body>
</html>
