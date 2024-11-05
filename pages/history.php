<?php
session_start();  


if (!isset($_SESSION['username'])) {
    echo "<p class='message'>Please log in to view your order history.</p>";
    exit();
}

include "../connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        .bodycart {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        .order-container {
            max-width: 700px;
            width: 100%;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }
        .order-container img {
            width: 250px;
            margin-bottom: 15px;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 25px;
            color: #2c3e50;
            font-weight: bold;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }
        table {
            color: black;
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            color: black;
            padding: 15px;
            text-align: center;
            font-size: 16px;
        }
        th {
            color: black;
            font-weight: bold;
            border-bottom: 2px solid #e0e0e0;
            background-color: #f9f9f9;
        }
        td {
            color: #34495e;
            font-weight: 500;
            border-bottom: 1px solid #eaeaea;
            cursor: pointer; 
        }
        td:hover {
            background-color: #e8f6f3; 
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            color: #c0392b;
            font-weight: bold;
            font-size: 18px;
        }
        .order-item:nth-child(even) {
            background-color: #f7f7f7;
        }
        .order-item:hover {
            background-color: #f0f8ff;
        }

        
        .filter-button {
            background-color: #3498db; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            padding: 10px 15px; 
            font-size: 16px; 
            margin: 5px; 
            cursor: pointer; 
            transition: background-color 0.3s; 
        }

        .filter-button:hover {
            background-color: #2980b9; 
        }

        .filter-button:focus {
            outline: none; 
            box-shadow: 0 0 5px rgba(0, 151, 219, 0.5); 
        }
    </style>
    <script>
        // Function to filter orders based on status
        function filterOrders(status) {
            const rows = document.querySelectorAll(".order-item");
            rows.forEach(row => {
                if (status === "all" || row.cells[1].textContent === status) {
                    row.style.display = ""; // Show row
                } else {
                    row.style.display = "none"; // Hide row
                }
            });
        }

        // Function to highlight the selected row
        function highlightRow(event) {
            const rows = document.querySelectorAll(".order-item");
            rows.forEach(row => row.style.backgroundColor = ""); // Reset all rows
            event.currentTarget.style.backgroundColor = "#d1e7dd"; // Highlight selected row
        }
    </script>
</head>

<body>
    <?php include '../Template/navbar.php'; ?>
    <div class="bodycart">
        <div class="order-container">
           
            <img src="../logonew.png" alt="ChicFoot Logo">  
            <h2>Order History</h2>

            <div>
                
                <button class="filter-button" onclick="filterOrders('all')">All Orders</button>
                <button class="filter-button" onclick="filterOrders('Pending')">Pending Orders</button>
                <button class="filter-button" onclick="filterOrders('Completed')">Completed Orders</button>
            </div>

            <?php
            
            $username = $_SESSION['username'];

            
            $sql = "SELECT shoeorder.Order_ID, shoeorder.Order_Status, receipt.Time, receipt.DATE_Bill 
                    FROM shoeorder
                    JOIN receipt ON shoeorder.Order_ID = receipt.Order_ID
                    WHERE shoeorder.Username = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username]);
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($orders) {
                echo '<table>
                        <tr>
                            <th>Order ID</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>Date</th>
                        </tr>';
                
                
                foreach ($orders as $order) {
                    echo '<tr class="order-item" onclick="highlightRow(event)">
                            <td>' . htmlspecialchars($order["Order_ID"]) . '</td>
                            <td>' . htmlspecialchars($order["Order_Status"]) . '</td>
                            <td>' . htmlspecialchars($order["Time"]) . '</td>
                            <td>' . htmlspecialchars($order["DATE_Bill"]) . '</td>
                          </tr>';
                }
                echo '</table>';
            } else {
                echo "<p class='message'>Your order history is empty!</p>";
            }
            ?>
        </div>
    </div>
    <?php include '../Template/footer.php'; ?>
</body>
</html>
