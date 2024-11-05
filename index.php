<?php 
include "connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot - Best Sellers</title>
    <link rel="stylesheet" href="./css/index.css">
    <style>
        
        .card {
            margin: 10px;
        }

        /* desktop */
        @media (min-width: 1024px) {
            .card {
                margin: 15px;
            }
        }
    </style>
</head>

<?php 
include './Template/navbar.php';
include './Template/header.php';
?>
<script src="//code.tidio.co/uv6n4xqgtgthacrt0mxm7hgghnyn3fbc.js" async></script>
<body>
<section class="section">
    <div class="container has-text-centered">
        <h1 class="title">BEST SELLER</h1>
        <br>
    </div>
    
    <div class="columns is-multiline is-mobile">
        <?php
            // Query to get the top 6 best-selling shoes based on the quantity sold
            $stmt = $pdo->prepare("
                SELECT p.*, SUM(i.quantity) as total_sold
                FROM shoeitem i
                JOIN shoes p ON i.Shoes_ID = p.Shoes_ID
                GROUP BY i.Shoes_ID
                ORDER BY total_sold DESC
                LIMIT 6
            ");
            $stmt->execute();

            // Supported image extensions
            $extensions = ['jpg','png','jpeg'];
        ?>
        
        <?php while ($row = $stmt->fetch()) : 
            $imagePath = '';

            // Check if an image file exists for the shoe
            foreach ($extensions as $ext) {
                if(file_exists("./sphoto/{$row['Shoes_ID']}.$ext")) {
                    $imagePath = "./sphoto/{$row['Shoes_ID']}.$ext";
                    break;
                }
            }

            // Set a default image if none found
            if($imagePath == '') {
                $imagePath = "./sphoto/default-image.jpg";
            }
        ?>
        
        <div class="column is-12-mobile is-6-tablet is-3-desktop">
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <a href="./pages/product/shoedetail.php?Shoes_ID=<?=$row["Shoes_ID"]?>">
                            <img src="<?=$imagePath?>" alt="<?=htmlspecialchars($row["name"])?>">
                        </a>
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-4"><?= htmlspecialchars($row["name"]) ?></p>
                        </div>
                    </div>

                    <div class="content">
                        <?= htmlspecialchars($row["title"]) ?>
                        <br>
                        <p class="title"><?= number_format($row["price"]) ?> บาท</p>
                        <p>Total Sold: <?= $row["total_sold"] ?></p>
                    </div>
                </div>
            </div>
        </div>    
        
        <?php endwhile; ?>
    </div>
</section>
<?php include './Template/footer.php'; ?>
</body>
</html>
