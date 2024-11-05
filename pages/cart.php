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

// Initialize cart session if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['Shoes_ID'])) {
    $shoe_id = $_GET['Shoes_ID'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $qty = $_POST['qty'];

    // Fetch shoe details using $pdo
    $stmt = $pdo->prepare("SELECT name, price FROM shoes WHERE Shoes_ID = :shoe_id");
    $stmt->execute(['shoe_id' => $shoe_id]);
    $shoe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($shoe) {
        // Add item to cart session
        $item = [
            'Shoe_ID' => $shoe_id,
            'name' => $shoe['name'],
            'price' => $shoe['price'],
            'color' => $color,
            'size' => $size,
            'qty' => $qty
        ];

        $_SESSION['cart'][] = $item;

        // Redirect to prevent form resubmission
        header("Location: cart.php");
        exit();
    }
}

// Remove item from cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['index'])) {
    $index = $_GET['index'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
    header("Location: cart.php");
    exit();
}

// Update item quantity
if (isset($_GET['action']) && ($_GET['action'] == 'increase' || $_GET['action'] == 'decrease') && isset($_GET['index'])) {
    $index = $_GET['index'];
    if ($_GET['action'] == 'increase') {
        $_SESSION['cart'][$index]['qty'] += 1;
    } elseif ($_GET['action'] == 'decrease' && $_SESSION['cart'][$index]['qty'] > 1) {
        $_SESSION['cart'][$index]['qty'] -= 1;
    }
    header("Location: cart.php");
    exit();
}

// Calculate subtotal
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['qty'];
}

// Apply Promotion Code and Discounts
$discount = 0;
$promoMessage = ""; // Message to show if promo is successfully applied
$promoCode = $_POST['promo_code'] ?? '';
$totalQuantity = array_sum(array_column($_SESSION["cart"], 'qty'));

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_code'])) {
    if ($promoCode === 'DISCOUNT10' && $totalQuantity >= 2) {
        $discount = 0.1 * $subtotal; // 10% off
        $_SESSION['discount'] = $discount;
        $promoMessage = "<p style='color:green;'>Promo Code Applied: 10% discount on subtotal</p>";
    } else {
        $promoMessage = "<p style='color:red;'>Invalid or inapplicable promo code.</p>";
    }
}

// Special Dates Discount (30% off)
$today = date('j/n');
$specialDates = ['1/1', '2/2', '3/3', '4/4', '5/5', '6/6', '7/7', '8/8', '9/9', '10/10', '11/11', '12/12'];
if (in_array($today, $specialDates)) {
    $discount += 0.3 * $subtotal;
    $promoMessage .= "<p style='color:green;'>Special Discount: 30% off on today's date!</p>";
}

// Buy 3 pairs, get 2 free pairs of socks
$freeItemsMessage = "";
if ($totalQuantity >= 3) {
    $freeItemsMessage = "<p style='color:green;'>Special Offer: Buy 3 pairs, get 2 free pairs of socks!</p>";
}

// Calculate final total
$totalAfterDiscount = $subtotal - $discount;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="../../css/index.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .cart-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 20px;
            margin: 30px;
        }
        .cart-items, .cart-summary {
            width: 45%;
            background: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
        }
        .cart-items h2, .cart-summary h2, .cart-items p, .cart-summary p {
            color: #000;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            align-items: center;
        }
        .cart-item img {
            width: 80px;
            border-radius: 5px;
        }
        .item-details {
            flex-grow: 1;
            margin-left: 15px;
        }
        .remove-button, .qty-button {
            background: #d9534f;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .promo-code {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }
        .promo-code input[type="text"] {
            width: 60%;
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .promo-code button {
            background: #2fab91;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .checkout-button {
            background: #2fab91;
            color: #fff;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include '../Template/navbar.php'; ?>

<div class="cart-container">
    <div class="cart-items">
        <h2>Shopping Cart</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <div class="cart-item">
                    <div>
                        <img src="../sphoto/<?= htmlspecialchars($item['Shoe_ID']) ?>.jpg" alt="<?= htmlspecialchars($item['name']) ?>">
                    </div>
                    <div class="item-details">
                        <p><strong style="color: black;"><?= htmlspecialchars($item['name']) ?></strong></p>
                        <p>Color: <?= htmlspecialchars($item['color']) ?>, Size: <?= htmlspecialchars($item['size']) ?></p>
                        <p>
                            Qty: <?= htmlspecialchars($item['qty']) ?>
                            <form method="get" action="cart.php" style="display:inline;">
                                <input type="hidden" name="action" value="increase">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button type="submit" class="qty-button">+</button>
                            </form>
                            <form method="get" action="cart.php" style="display:inline;">
                                <input type="hidden" name="action" value="decrease">
                                <input type="hidden" name="index" value="<?= $index ?>">
                                <button type="submit" class="qty-button">-</button>
                            </form>
                        </p>
                    </div>
                    <div>
                        <p>฿ <?= htmlspecialchars($item['price'] * $item['qty']) ?></p>
                    </div>
                    <form method="get" action="cart.php">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <button type="submit" class="remove-button">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <div class="cart-summary">
        <h2>Order Summary</h2>
        <p>Subtotal: ฿ <?= htmlspecialchars($subtotal) ?></p>

        <!-- Promo Code Form -->
        <form method="post" class="promo-code">
            <input type="text" name="promo_code" placeholder="Enter promo code">
            <button type="submit" name="apply_code">Apply</button>
        </form>

        <!-- Display promo and free item messages -->
        <?= $promoMessage ?>
        <?= $freeItemsMessage ?>

        <!-- Show Discount Amount -->
        <?php if ($discount > 0): ?>
            <p><strong style="color: black;">Discount:</strong> -฿ <?= htmlspecialchars($discount) ?></p>
        <?php endif; ?>

        <h3><strong style="color: black;">Total After Discount:฿ <?= htmlspecialchars($totalAfterDiscount) ?></strong> </h3>

        <form method="post" action="checkout.php">
            <button type="submit" class="checkout-button">Proceed to Checkout</button>
        </form>
    </div>
</div>

<?php include '../Template/footer.php'; ?>

</body>
</html>
