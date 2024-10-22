<?php Include "../connect.php";?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="../css/index.css">
  </head>
  <?php
  include '../Template/navbar.php';
  
  ?>
  <body>
        <?php
            if (isset($_GET['Shoes_ID'])) {
                $stmt = $pdo->prepare("SELECT * FROM Shoes WHERE Shoes_ID = ?");
                $stmt->bindParam(1, $_GET['Shoes_ID']);
                $stmt->execute();
                $row = $stmt->fetch();
            }
        ?>
        
        <?php if ($row): ?>
            <?php 
                $extensions = ['jpg','png','jpeg'];
                
                $imagePath = '';

                foreach ($extensions as $ext){
                    if(file_exists("../sphoto/{$row['Shoes_ID']}.$ext")){
                        $imagePath = "../sphoto/{$row['Shoes_ID']}.$ext";
                        break;
                    }
                }

               
            ?>
            <!-- display shoe-->
            <div class="columns ">

                <div style="margin: 15px;" class="product column is-half">
                     <a href="shoedetail.php?Shoes_ID=<?=$row["Shoes_ID"]?>">
                         <img src='../sphoto/<?=$imagePath?>' width='1000'>
                     </a><br>
                     
                </div>
                <section class="section is-large column is-half">
                    <h1 class="title"><?=$row["name"]?></h1><br>
                    <h2 class="subtitle"><?=$row["title"]?></h2><br>
                    <h2><?=$row["price"]?><span> บาท</span></h2><br>
                    <form method="post" action="cart.php?action=add&Shoes_ID=<?=$row["Shoes_ID"]?>&pname=<?=$row["name"]?>&price=<?=$row["price"]?>">
                        <input type="number" name="qty" value="1" min="1" max="9">
                        <input class="button is-success" type="submit" value="Add to Cart">	   
                    </form>
                </section>
                    


                
                    
            </div>
             <section class="section is-medium">
                <h3 class="title">รายละเอียดสินค้า</h3><br>
                <h4 class="subtitle"><?=$row["detail"]?></h4>

             </section>
        <?php else: ?>
            <p>ไม่พบรายละเอียดสินค้า</p>
        <?php endif; ?>
        </div>
  
  
  </body>
  <?php include '../Template/footer.php'; ?>
</html>