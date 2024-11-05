<?php include "../connect.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot - Order Summary</title>
    <link rel="stylesheet" href="../../css/index.css">
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .order-summary {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
        }

        table > th {
            background-color: #333;
            color: #fff;
            font-weight: 500;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table td {
            color: #666;
        }

        
        table td:last-child {
            font-weight: bold;
            color: #333;
        }

        
        @media (max-width: 600px) {
            .order-summary {
                padding: 10px;
            }
            
            table th, table td {
                padding: 8px;
                font-size: 14px;
            }
            
            h2 {
                font-size: 20px;
            }
        }

    </style>
</head>

<body>
    <?php include '../Template/navbar.php'; ?>
    
    <?php
       
        $stmt = $pdo->prepare("SELECT 
                                     shoeorder.Order_ID AS OrderID,
                                    shoemember.Name AS CustomerName,
                                    shoes.name AS ShoeName,
                                    shoeitem.quantity AS Quantity,
                                    shoes.price AS UnitPrice,
                                    (shoeitem.quantity * shoes.price) AS TotalPrice
                               FROM 
                                    shoes
                               JOIN 
                                    shoeitem ON shoes.Shoes_ID = shoeitem.Shoes_ID
                               JOIN 
                                    shoeorder ON shoeitem.Order_ID = shoeorder.Order_ID
                                JOIN 
                                    shoemember ON shoeorder.Username = shoemember.Username
                               ORDER BY 
                                    shoeorder.Order_ID;");
        $stmt->execute();
        $orders = $stmt->fetchAll();
    ?>

    <div class="order-summary">
        <h2>Order Summary</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Shoes Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
            <?php
            
            foreach ($orders as $order) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($order['OrderID']) . "</td>";
                echo "<td>" . htmlspecialchars($order['CustomerName']) . "</td>";
                echo "<td>" . htmlspecialchars($order['ShoeName']) . "</td>";
                echo "<td>" . htmlspecialchars($order['Quantity']) . "</td>";
                echo "<td>" . htmlspecialchars(number_format($order['UnitPrice'], 2)) . " ฿</td>";
                echo "<td>" . htmlspecialchars(number_format($order['TotalPrice'], 2)) . " ฿</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <?php include '../Template/footer.php'; ?>
</body>
</html>
