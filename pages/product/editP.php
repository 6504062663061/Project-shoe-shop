<?php 
include "../../connect.php"; 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Products - ChicFoot</title>
    <link rel="stylesheet" href="../../css/index.css">
    <style>
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        td {
            background-color: #f9f9f9;
        }
        .edit-button {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .edit-button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
<?php include '../../Template/navbar.php'; ?>

<div class="container">
    <h2>All Products</h2>

    <?php
    // Fetch all products from the database
    $stmt = $pdo->prepare("SELECT Shoes_ID, name, title, type, price FROM shoes");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <?php if ($products): ?>
        <table>
            <thead>
                <tr>
                    <th>Shoes ID</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['Shoes_ID']) ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['title']) ?></td>
                        <td><?= htmlspecialchars($product['type']) ?></td>
                        <td><?= htmlspecialchars($product['price']) ?> บาท</td>
                        <td>
                            <a href="editP1.php?Shoes_ID=<?= $product['Shoes_ID'] ?>">
                                <button class="edit-button">Edit</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>

<?php include '../../Template/footer.php'; ?>
</body>
</html>
