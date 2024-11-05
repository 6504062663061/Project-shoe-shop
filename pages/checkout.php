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

// Calculate subtotal
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['qty'];
}

// Retrieve discount from session (calculated in cart.php)
$discountAmount = $_SESSION['discount'] ?? 0;
$totalAfterDiscount = $subtotal - $discountAmount;

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

        // Generate a unique Receipt_ID
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

        // Store Receipt ID in session and redirect to confirmation page
        $_SESSION['receipt_id'] = $receipt_id;
        header("Location: order_confirmation.php");
        exit();
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
            background-color: #f3f4f6;
            color: #333;
        }
        .checkout-container {
            width: 60%;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            color: #000;
        }
        h2 {
            color: #2fab91;
            text-align: center;
            margin-bottom: 20px;
        }
        .user-info, .checkout-summary, .total-section {
            margin-bottom: 20px;
        }
        .user-info h3, .checkout-summary h3, .total-section h3 {
            color: #333;
        }
        .product-list {
            margin-bottom: 20px;
        }
        .product-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .product-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }
        .product-details {
            flex: 1;
            color: #333;
        }
        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
        .qr-code img {
            width: 150px;
            height: 150px;
            object-fit: contain;
        }
        .button, .button-secondary {
            display: inline-block;
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }
        .button {
            background-color: #2fab91;
            color: #000;
        }
        .button-secondary {
            background-color: #ccc;
            color: #000;
        }
    </style>
</head>
<body>

<?php include '../Template/navbar.php'; ?>

<div class="checkout-container">
    <h2>Checkout</h2>

    <div class="user-info">
        <h3>Shipping Information</h3>
        <p><strong style="color: black;">Name:</strong> <?= htmlspecialchars($user['Name']) ?></p>
        <p><strong style="color: black;">Address:</strong> <?= htmlspecialchars($user['Address']) ?></p>
        <p><strong style="color: black;">Phone:</strong> <?= htmlspecialchars($user['Phone']) ?></p>
    </div>

    <div class="checkout-summary">
        <h3>Order Summary</h3>
        <div class="product-list">
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="product-item">
                    <img src="../sphoto/<?= htmlspecialchars($item['Shoe_ID']) ?>.jpg" alt="<?= htmlspecialchars($item['name']) ?>">
                    <div class="product-details">
                        <p><strong style="color: black;"><?= htmlspecialchars($item['name']) ?></strong></p>
                        <p>Color: <?= htmlspecialchars($item['color']) ?>, Size: <?= htmlspecialchars($item['size']) ?></p>
                        <p>Qty: <?= htmlspecialchars($item['qty']) ?> - ฿<?= htmlspecialchars($item['price'] * $item['qty']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <p><strong style="color: black;">Subtotal:</strong> ฿<?= htmlspecialchars($subtotal) ?></p>
        
        <?php if ($discountAmount > 0): ?>
            <p><strong style="color: black;">Discount:</strong> -฿<?= htmlspecialchars($discountAmount) ?></p>
        <?php endif; ?>
    </div>

    <div class="total-section">
        <h3>Total Price</h3>
        <p><strong style="color: black;">Total After Discount:</strong> ฿<?= htmlspecialchars($totalAfterDiscount) ?></p>
    </div>

    <div class="qr-code">
        <h3>Scan to Pay</h3>
        <img src="../sphoto/IMG_3656.png" alt="QR Code"> <!-- Update path if needed -->
    </div>

    <form method="post">
        <button type="submit" name="confirm" class="button">Confirm Purchase</button>
        <a href="cart.php" class="button-secondary">Return to Cart</a>
    </form>
</div>

<?php include '../Template/footer.php'; ?>

</body>
</html>
