<?php 
include "../connect.php"; 

// Read the JSON data for branches
$jsonData = '[
    {"branch_id": 1, "branch_name": "ChicFoot Central Plaza", "location": "Bangkok", "contact_number": "02-123-4567"},
    {"branch_id": 2, "branch_name": "ChicFoot Siam Square", "location": "Bangkok", "contact_number": "02-234-5678"},
    {"branch_id": 3, "branch_name": "ChicFoot EmQuartier", "location": "Bangkok", "contact_number": "02-345-6789"},
    {"branch_id": 4, "branch_name": "ChicFoot Mega Bangna", "location": "Samut Prakan", "contact_number": "02-456-7890"},
    {"branch_id": 5, "branch_name": "ChicFoot Central Festival", "location": "Chiang Mai", "contact_number": "053-123-456"},
    {"branch_id": 6, "branch_name": "ChicFoot Central Phuket", "location": "Phuket", "contact_number": "076-123-456"},
    {"branch_id": 7, "branch_name": "ChicFoot Central Pattaya", "location": "Chonburi", "contact_number": "038-123-456"},
    {"branch_id": 8, "branch_name": "ChicFoot Central Korat", "location": "Nakhon Ratchasima", "contact_number": "044-123-456"},
    {"branch_id": 9, "branch_name": "ChicFoot Terminal 21", "location": "Bangkok", "contact_number": "02-567-8901"},
    {"branch_id": 10, "branch_name": "ChicFoot Central WestGate", "location": "Nonthaburi", "contact_number": "02-678-9012"},
    {"branch_id": 11, "branch_name": "ChicFoot Fashion Island", "location": "Bangkok", "contact_number": "02-789-0123"},
    {"branch_id": 12, "branch_name": "ChicFoot Central Chonburi", "location": "Chonburi", "contact_number": "038-234-567"},
    {"branch_id": 13, "branch_name": "ChicFoot Robinson Surat Thani", "location": "Surat Thani", "contact_number": "077-123-456"},
    {"branch_id": 14, "branch_name": "ChicFoot Robinson Sriracha", "location": "Chonburi", "contact_number": "038-345-678"},
    {"branch_id": 15, "branch_name": "ChicFoot Central Rayong", "location": "Rayong", "contact_number": "038-456-789"}
]';

// Decode JSON data
$branches = json_decode($jsonData, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Background */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #333;
        }

        /* Branch Container */
        .branch-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            padding: 20px;
            margin: auto;
            margin-top: 40px;
        }

        /* Branch Title */
        .branch-container h2 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Two-column layout */
        .branch-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            list-style: none;
            padding: 0;
            justify-content: center;
        }

        /* Branch Item */
        .branch-item {
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 45%;
            box-sizing: border-box;
        }

        .branch-item h3 {
            color: #007bff;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .branch-item p {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>

    <?php include '../Template/navbar.php'; ?>

    <div class="branch-container">
        <h2>Our Branches</h2>
        
        <ul class="branch-list">
            <?php foreach ($branches as $branch): ?>
                <li class="branch-item">
                    <h3><?= htmlspecialchars($branch['branch_name']); ?></h3>
                    <p>Location: <?= htmlspecialchars($branch['location']); ?></p>
                    <p>Contact: <?= htmlspecialchars($branch['contact_number']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php include '../Template/footer.php'; ?>

</body>
</html>
