<?php 
Include "connect.php";



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<?php 

include './Template/navbar.php';
include './Template/header.php';
?>
<body>



<section class="section">
    <div class="container has-text-centered">
        <h1 class="title">BEST SELLER</h1>
        <br>
        <br>
    </div>
    <div>
        <!-- display best seller -->
    <div class="columns is-multiline is-2">
        <?php
            $stmt = $pdo->prepare("SELECT p.*, SUM(i.quantity) as total_sold
                                            FROM shoeitem i
                                            JOIN Shoes p ON i.Shoes_ID = p.Shoes_ID
                                            GROUP BY i.Shoes_ID
                                            ORDER BY total_sold DESC
                                            LIMIT 6");
            $stmt->execute();

            $extensions = ['jpg','png','jpeg'];
        ?>
        <?php while ($row = $stmt->fetch()) : 
            
            $imagePath = '';

            foreach ($extensions as $ext){
                if(file_exists("./sphoto/{$row['Shoes_ID']}.$ext")){
                    $imagePath = "./sphoto/{$row['Shoes_ID']}.$ext";
                    break;
                }
            }

            if($imagePath == ''){
                $imagePath = "./sphoto/default-image.jpg";
            }
        ?>
        <div class="column is-4">
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <a href="./pages/product/shoedetail.php?Shoes_ID=<?=$row["Shoes_ID"]?>">
                            <img src="<?=$imagePath?>" width='100'>
                        </a>
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media">
                    
                        <div class="media-content">
                            <p class="title is-4"><?=$row["name"]?></p>
                            
                        </div>
                    </div>

                    <div class="content">
                        <?=$row["title"]?>
                        <br />
                        <p class="title"><?=$row["price"]?> บาท</p>
                        
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
