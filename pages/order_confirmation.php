<?php
session_start();

// Check if Receipt ID is set in session (from checkout confirmation process)
if (!isset($_SESSION['receipt_id'])) {
    echo "No receipt found. Please complete your purchase.";
    exit();
}

// Retrieve Receipt ID and then clear it from the session for security
$receipt_id = $_SESSION['receipt_id'];
unset($_SESSION['receipt_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../../css/index.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #333;
        }
        .confirmation-container {
            width: 50%;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }
        h2 {
            color: #2fab91;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin: 15px 0;
            color: #000;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #2fab91;
            color: #fff;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include '../Template/navbar.php'; ?>

<div class="confirmation-container">
    <h2>Thank You for Your Purchase!</h2>
    <p>Your order has been successfully completed.</p>
    <p><strong style="color: black;">Receipt ID:</strong> <?= htmlspecialchars($receipt_id) ?></p>
    <a href="../index.php" class="button">Go to Home Page</a>
</div>

<?php include '../Template/footer.php'; ?>

</body>
</html>
