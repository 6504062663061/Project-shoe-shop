<?php Include "../../connect.php"; ?>

<?php
    $stmt = $pdo->prepare("SELECT * FROM Shoes");
    $stmt->execute();

    $extensions = ['jpg','png','jpeg'];
?>  
<?php while ($row = $stmt->fetch()) : 
    $imagePath = '';
    foreach ($extensions as $ext){
        if(file_exists("../../sphoto/{$row['Shoes_ID']}.$ext")){
            $imagePath = "../../sphoto/{$row['Shoes_ID']}.$ext";
            break;
        }
    }
    if($imagePath == ''){
        $imagePath = "../pphoto/default-image.jpg";
    }
?>
    <div class="column is-4">
        <div class="card">
            <div class="card-image">
                <figure class="image is-4by3">
                    <a href="shoedetail.php?Shoes_ID=<?=$row["Shoes_ID"]?>">
                        <img src='<?=$imagePath?>' width='100'>
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
