<?php include "../connect.php"; ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="../css/index.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        .bodycart {
            background-color: #f7f8fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .cart-container {
            max-width: 600px;
            width: 100%;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            color: #555;
            font-weight: bold;
        }
        td {
            color: #333;
            border-top: 1px solid #ddd;
        }
        .cart-item-quantity input[type="number"] {
            width: 50px;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        .cart-item-actions a {
            color: #3498db;
            font-size: 14px;
            text-decoration: none;
            margin-left: 10px;
        }
        .cart-item-actions a:hover {
            color: #1d6fa5;
        }
        .cart-total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-top: 15px;
        }
        .message {
            text-align: center;
            margin-bottom: 10px;
            color: red;
        }
        .success {
            color: green;
        }
    </style>
  </head>
 
  <body>
    <?php include '../Template/navbar.php'; ?>
    <div class="bodycart">
        <div class="cart-container">
            <h2>Shopping Cart</h2>

            <?php
            session_start();

            $message = "";  // To store feedback messages

            // Check for action
            if (isset($_GET["action"])) {
                $pid = $_GET['Shoes_ID'] ;
                $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 0;

                if ($pid) {
                    // Fetch stock of selected item
                    $stmt = $pdo->prepare("SELECT stock FROM Shoes WHERE Shoes_ID = :Shoes_ID");
                    $stmt->execute(['Shoes_ID' => $pid]);
                    $product = $stmt->fetch();
                    $stock = $product['stock'] ?? 0;

                    if ($_GET["action"] == "add") {
                        if ($qty > 0 && $qty <= $stock) {
                            $_SESSION['cart'][$pid]['qty'] += $qty;
                            $message = "<p class='message success'>Item added to cart.</p>";
                        } else {
                            $message = "<p class='message'>Invalid quantity or exceeds stock!</p>";
                        }
                    } elseif ($_GET["action"] == "update") {
                        if ($qty <= $stock) {
                            $_SESSION['cart'][$pid]['qty'] = $qty;
                            $message = "<p class='message success'>Quantity updated.</p>";
                        } else {
                            $message = "<p class='message'>Exceeds stock limit!</p>";
                        }
                    } elseif ($_GET["action"] == "delete") {
                        unset($_SESSION['cart'][$pid]);
                        $message = "<p class='message success'>Item removed from cart.</p>";
                    }
                }
            }
            
            echo $message;  // Display any messages

            if (!empty($_SESSION["cart"])) {
                $sum = 0;
                ?>
                <table border="1">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    foreach ($_SESSION["cart"] as $item) {
                        $sum += $item["price"] * $item["qty"];
                        ?>
                        <tr class="cart-item">
                            <td><?= htmlspecialchars($item["pname"]) ?></td>
                            <td><?= htmlspecialchars($item["price"]) ?> ฿</td>
                            <td>
                                <form method="post" action="?action=update&Shoes_ID=<?= htmlspecialchars($item["pid"]) ?>">
                                    <input type="number" name="qty" value="<?= htmlspecialchars($item["qty"]) ?>" min="1" max="<?= htmlspecialchars($stock) ?>">
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                            <td>
                                <a href="?action=delete&Shoes_ID=<?= htmlspecialchars($item["pid"]) ?>">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="4" align="right" class="cart-total">Total: <?= $sum ?> บาท</td>
                    </tr>
                </table>
                <?php
            } else {
                echo "<p>Your cart is empty!</p>";
            }
            ?>
        </div>
    </div>
    <?php include '../Template/footer.php'; ?>
  </body>
</html>
