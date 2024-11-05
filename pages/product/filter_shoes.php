<?php
include '../../connect.php';

$params = [];
$query = "SELECT * FROM shoes"; 

// Filter by minimum price
if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
    $min_price = $_GET['min_price'];
    if (strpos($query, 'WHERE') === false) {
        $query .= " WHERE price >= :min_price";  
    } else {
        $query .= " AND price >= :min_price";
    }
    $params[':min_price'] = $min_price;
}

// Filter by maximum price
if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $max_price = $_GET['max_price'];
    if (strpos($query, 'WHERE') === false) {
        $query .= " WHERE price <= :max_price"; 
    } else {
        $query .= " AND price <= :max_price"; 
    }
    $params[':max_price'] = $max_price;
}



$stmt = $pdo->prepare($query);

// Bind parameters
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->execute();
$shoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$extensions = ['jpg','png','jpeg'];
?>
<?php if (!empty($shoes)) : ?>
    <?php foreach ($shoes as $shoe) : 
        $imagePath = '';
        foreach ($extensions as $ext) {
            if(file_exists("../../sphoto/{$shoe['Shoes_ID']}.$ext")){
                $imagePath = "../../sphoto/{$shoe['Shoes_ID']}.$ext";
                break;
            }
        }
        if($imagePath == ''){
            $imagePath = "../../sphoto/default-image.jpg";
        }        
    ?>  
        <div style="
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 200px;
        margin: 10px auto;
        font-family: Arial, sans-serif;
        ">
        <a href="shoedetail.php?Shoes_ID=<?=$shoe["Shoes_ID"]?>" style="text-decoration: none; color: inherit;">
            <img src='<?=$imagePath?>' width='120' style="border-radius: 8px; margin-bottom: 12px;">
            <h2 style="font-size: 18px; font-weight: 600; margin: 10px 0; color: #333;"><?=$shoe["name"]?></h2>
        </a>
        <p style="font-size: 14px; color: #666; margin: 0 0 10px;"><?=$shoe["title"]?></p>
        <p class="title" style="font-size: 16px; color: #e74c3c; font-weight: 600;"><?=$shoe["price"]?> บาท</p>
    </div>
    <?php endforeach; ?>
<?php else : ?>
    <h2>No shoes found matching the filter criteria.</h2>
<?php endif; ?>
