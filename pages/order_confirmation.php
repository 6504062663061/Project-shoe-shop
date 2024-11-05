<?php
include "../connect.php";
session_start();

$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    echo "Order ID not provided.";
    exit;
}

// Retrieve order details
$order_stmt = $pdo->prepare("SELECT * FROM shoeorder WHERE order_id = :order_id");
$order_stmt->execute(['order_id' => $order_id]);
$order_details = $order_stmt->fetch();

// Retrieve items for this order
$item_stmt = $pdo->prepare("SELECT si.*, s.name AS product_name, s.color, s.size FROM shoeitem si 
                            JOIN shoes s ON si.shoe_id = s.shoe_id
                            WHERE si.order_id = :order_id");
$item_stmt->execute(['order_id' => $order_id]);
$order_items = $item_stmt->fetchAll();

// Retrieve receipt details
$receipt_stmt = $pdo->prepare("SELECT * FROM receipt WHERE order_id = :order_id");
$receipt_stmt->execute(['order_id' => $order_id]);
$receipt_details = $receipt_stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - ChicFoot</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <?php include '../Template/navbar.php'; ?>

    <div class="confirmation-container">
        <h2>Order Confirmation</h2>
        <p>Thank you for your purchase!</p>
        <p><strong>Order ID:</strong> <?= htmlspecialchars($order_id) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($order_details['status']) ?></p>

        <h3>Order Details</h3>
        <table>
            <tr>
                <th>Product</th>
                <th>Color</th>
                <th>Size</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php foreach ($order_items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= htmlspecialchars($item['color']) ?></td>
                <td><?= htmlspecialchars($item['size']) ?></td>
                <td><?= number_format($item['price'], 2) ?> ฿</td>
                <td><?= htmlspecialchars($item['quantity']) ?></td>
                <td><?= number_format($item['price'] * $item['quantity'], 2) ?> ฿</td>
            </tr>
            <?php endforeach; ?>
        </table>

        <p><strong>Subtotal:</strong> <?= number_format($receipt_details['total_amount'] + $receipt_details['discount'], 2) ?> ฿</p>
        <p><strong>Discount:</strong> -<?= number_format($receipt_details['discount'], 2) ?> ฿</p>
        <p><strong>Total:</strong> <?= number_format($receipt_details['total_amount'], 2) ?> ฿</p>

        <a href="index.php" class="back-button">Back to Home</a>
    </div>

    <?php include '../Template/footer.php'; ?>
</body>
</html>
