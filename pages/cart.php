<?php 
include "../connect.php";
session_start(); // Start the session to manage cart data
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot - Shopping Cart</title>
    <link rel="stylesheet" href="../css/index.css">
    <style>
        .bodycart {
            background-color: #f7f8fc;
            display: flex;
            justify-content: center;
            padding: 20px;
            color: #333;
        }
        .cart-container {
            width: 70%;
            display: flex;
            gap: 30px;
        }
        .cart-items, .cart-summary {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .cart-items {
            width: 65%;
        }
        .cart-summary {
            width: 30%;
        }
        .cart-summary h3, .cart-items h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .promo-code {
            display: flex;
            margin-bottom: 15px;
        }
        .promo-code input[type="text"] {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        .promo-code button {
            padding: 8px 15px;
            border: none;
            background: #333;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .summary-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .checkout-button {
            width: 100%;
            background: #000;
            color: #fff;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: left;
            font-size: 14px;
        }
        th {
            font-weight: bold;
            color: #000;
            background-color: #f1f1f1;
        }
        .cart-item-info {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .cart-item-thumbnail {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }
        .cart-item-actions a {
            color: #e74c3c;
            font-size: 14px;
            text-decoration: none;
            margin-left: 10px;
        }
        .cart-item-actions a:hover {
            color: #c0392b;
        }
    </style>
</head>

<body>
    <?php include '../Template/navbar.php'; ?>
    
    <div class="bodycart">
        <div class="cart-container">
            <!-- Cart Items Section -->
            <div class="cart-items">
                <h2>MY SHOPPING BAG</h2>
                
                <?php
                $message = "";  // To store feedback messages

                // Check for cart actions
                if (isset($_GET["action"])) {
                    $pid = $_GET['Shoes_ID'] ?? null;
                    $color = $_GET['color'] ?? '';
                    $size = $_GET['size'] ?? '';
                    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

                    $cart_key = "{$pid}_{$color}_{$size}";

                    if ($pid) {
                        // Fetch product details from database to get price and stock
                        $stmt = $pdo->prepare("SELECT Shoes_ID, name, price, stock_data FROM shoes WHERE Shoes_ID = :Shoes_ID");
                        $stmt->execute(['Shoes_ID' => $pid]);
                        $product = $stmt->fetch();

                        if ($product) {
                            // Decode stock data to find the correct color and size stock
                            $stock_data = json_decode($product['stock_data'], true);
                            $available_stock = 0;

                            foreach ($stock_data as $stock_item) {
                                if ($stock_item['color'] === $color && $stock_item['size'] == $size) {
                                    $available_stock = $stock_item['stock'];
                                    break;
                                }
                            }

                            if ($_GET["action"] == "add") {
                                if ($qty > 0 && $qty <= $available_stock) {
                                    $_SESSION['cart'][$cart_key] = [
                                        'qty' => $qty,
                                        'price' => $product['price'],
                                        'pname' => $product['name'],
                                        'Shoes_ID' => $pid,
                                        'color' => $color,
                                        'size' => $size
                                    ];
                                    $message = "<p class='message success'>Item added to cart.</p>";
                                } else {
                                    $message = "<p class='message'>Requested quantity exceeds available stock!</p>";
                                }
                            } elseif ($_GET["action"] == "update") {
                                if ($qty <= $available_stock) {
                                    $_SESSION['cart'][$cart_key]['qty'] = $qty;
                                    $message = "<p class='message success'>Quantity updated.</p>";
                                } else {
                                    $message = "<p class='message'>Quantity exceeds stock limit!</p>";
                                }
                            } elseif ($_GET["action"] == "delete") {
                                unset($_SESSION['cart'][$cart_key]);
                                $message = "<p class='message success'>Item removed from cart.</p>";
                            }
                        } else {
                            $message = "<p class='message'>Product not found in the database!</p>";
                        }
                    } else {
                        $message = "<p class='message'>Product ID is missing!</p>";
                    }
                }

                echo $message; // Display feedback messages

                if (!empty($_SESSION["cart"])) {
                    $sum = 0;
                    ?>
                    <table>
                        <tr>
                            <th>PRODUCT</th>
                            <th>COLOR</th>
                            <th>SIZE</th>
                            <th>PRICE</th>
                            <th>QUANTITY</th>
                            <th>TOTAL</th>
                            <th>ACTIONS</th>
                        </tr>
                        <?php
                        foreach ($_SESSION["cart"] as $key => $item) {
                            $pid = explode('_', $key)[0];
                            $total = $item["price"] * $item["qty"];
                            $sum += $total;
                            
                            // Determine the image path
                            $imagePath = "../sphoto/default-image.jpg";
                            $extensions = ['jpg', 'png', 'jpeg'];
                            foreach ($extensions as $ext) {
                                if (file_exists("../sphoto/{$item['Shoes_ID']}.$ext")) {
                                    $imagePath = "../sphoto/{$item['Shoes_ID']}.$ext";
                                    break;
                                }
                            }
                            ?>
                            <tr class="cart-item">
                                <td class="cart-item-info">
                                    <img src="<?= $imagePath ?>" class="cart-item-thumbnail" alt="Product Image">
                                    <div>
                                        <?= htmlspecialchars($item["pname"]) ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($item["color"]) ?></td>
                                <td><?= htmlspecialchars($item["size"]) ?></td>
                                <td><?= htmlspecialchars(number_format($item["price"], 2)) ?> ฿</td>
                                <td>
                                    <form method="post" action="?action=update&Shoes_ID=<?= htmlspecialchars($pid) ?>&color=<?= htmlspecialchars($item["color"]) ?>&size=<?= htmlspecialchars($item["size"]) ?>">
                                        <input type="number" name="qty" value="<?= htmlspecialchars($item["qty"]) ?>" min="1">
                                        <button type="submit">Update</button>
                                    </form>
                                </td>
                                <td><?= htmlspecialchars(number_format($total, 2)) ?> ฿</td>
                                <td>
                                    <a href="?action=delete&Shoes_ID=<?= htmlspecialchars($pid) ?>&color=<?= htmlspecialchars($item["color"]) ?>&size=<?= htmlspecialchars($item["size"]) ?>">Remove</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                } else {
                    echo "<p>Your cart is empty!</p>";
                }
                ?>
            </div>

            <!-- Cart Summary Section -->
            <div class="cart-summary">
                <h3>SUMMARY</h3>
                
                <div class="promo-code">
                    <input type="text" placeholder="Do you have a promo code?">
                    <button>Apply</button>
                </div>

                <div class="summary-detail" style="font-weight: bold; font-size: 18px;">
                    <span>Subtotal</span>
                    <span><?= number_format($sum, 2) ?> ฿</span>
                </div>

                <button class="checkout-button">CHECKOUT</button>
            </div>
        </div>
    </div>
    
    <?php include '../Template/footer.php'; ?>
</body>
</html>
