<?php
session_start();

// Database connection with $pdo
try {
    $pdo = new PDO("mysql:host=localhost; dbname=sec1_22; charset=utf8", "Wstd22", "oopFBiFc");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    echo "Please log in to proceed to checkout.";
    exit();
}

// Get user information
$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User information not found.";
    exit();
}

// Calculate total price
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['qty'];
}

// Example discount application
if (!isset($_SESSION['discount'])) {
    // Check for a promo code and apply discount if needed
    $promoCode = $_SESSION['promo_code'] ?? ''; // Assuming the promo code is stored here
    if ($promoCode === 'DISCOUNT10') {
        $_SESSION['discount'] = $subtotal * 0.1; // 10% discount
    } else {
        $_SESSION['discount'] = 0; // No discount
    }
}

// Calculate total after discount
$totalAfterDiscount = $subtotal - $_SESSION['discount'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    // Start transaction
    $pdo->beginTransaction();
    try {
        // Insert into `shoeorder`
        $stmt = $pdo->prepare("INSERT INTO shoeorder (Username, Order_Status) VALUES (:username, 'Completed')");
        $stmt->execute(['username' => $username]);
        $order_id = $pdo->lastInsertId();

        // Insert each item into `shoeitem`
        foreach ($_SESSION['cart'] as $item) {
            $stmt = $pdo->prepare("INSERT INTO shoeitem (Order_ID, Shoes_ID, quantity) VALUES (:order_id, :shoes_id, :quantity)");
            $stmt->execute([
                'order_id' => $order_id,
                'shoes_id' => $item['Shoe_ID'],
                'quantity' => $item['qty']
            ]);
        }

        // Generate a unique Receipt_ID using time()
        $receipt_id = time();

        // Insert into `receipt` with generated Receipt_ID
        $stmt = $pdo->prepare("INSERT INTO receipt (Receipt_ID, Order_ID, Time, DATE_Bill) VALUES (:receipt_id, :order_id, :time, :date)");
        $stmt->execute([
            'receipt_id' => $receipt_id,
            'order_id' => $order_id,
            'time' => date('H:i:s'),
            'date' => date('Y-m-d')
        ]);

        // Commit transaction
        $pdo->commit();

        // Clear cart
        unset($_SESSION['cart']);
        echo "<p style='color:green;'>Order confirmed! Your Receipt ID is $receipt_id.</p>";
    } catch (Exception $e) {
        // Rollback on error
        $pdo->rollBack();
        echo "<p style='color:red;'>Error processing order: " . $e->getMessage() . "</p>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="../../css/index.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .checkout-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        h2 {
            color: #2fab91;
        }
        .checkout-summary, .user-info, .total-section {
            margin-bottom: 20px;
        }
        .button {
            background-color: #2fab91;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            display: inline-block;
        }
        .button-secondary {
            background-color: #ccc;
            color: #000;
            text-align: center;
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>Checkout</h2>

    <div class="user-info">
        <h3>Shipping Information</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['Name']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($user['Address']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['Phone']) ?></p>
    </div>

    <div class="checkout-summary">
        <h3>Order Summary</h3>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <p><?= htmlspecialchars($item['name']) ?> (Color: <?= htmlspecialchars($item['color']) ?>, Size: <?= htmlspecialchars($item['size']) ?>) - Qty: <?= htmlspecialchars($item['qty']) ?> - ฿<?= htmlspecialchars($item['price'] * $item['qty']) ?></p>
        <?php endforeach; ?>
        <p><strong>Subtotal:</strong> ฿<?= htmlspecialchars($subtotal) ?></p>
        <?php if ($_SESSION['discount'] > 0): ?>
            <p><strong>Discount:</strong> ฿<?= htmlspecialchars($_SESSION['discount']) ?></p>
        <?php endif; ?>
    </div>

    <div class="total-section">
        <h3>Total Price</h3>
        <p><strong>Total After Discount:</strong> ฿<?= htmlspecialchars($totalAfterDiscount) ?></p>
    </div>

    <form method="post">
        <button type="submit" name="confirm" class="button">Confirm Purchase</button>
        <a href="cart.php" class="button-secondary">Return to Cart</a>
    </form>
</div>

</body>
</html>
