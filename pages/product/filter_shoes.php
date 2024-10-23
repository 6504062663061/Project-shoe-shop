<?php
include '../../connect.php';

// Initialize parameters and query
$params = [];
$query = "SELECT * FROM Shoes"; // Fetch all products by default

// Handle price filter
if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
    $min_price = $_GET['min_price'];
    if (strpos($query, 'WHERE') === false) {
        $query .= " WHERE price >= :min_price";  
    } else {
        $query .= " AND price >= :min_price";
    }
    $params[':min_price'] = $min_price;
}

if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $max_price = $_GET['max_price'];
    if (strpos($query, 'WHERE') === false) {
        $query .= " WHERE price <= :max_price"; 
    } else {
        $query .= " AND price <= :max_price"; 
    }
    $params[':max_price'] = $max_price;
}

// Handle color filter
if (isset($_GET['color']) && !empty($_GET['color'])) {
    $color = $_GET['color'];
    if (strpos($query, 'WHERE') === false) {
        $query .= " WHERE color = :color"; 
    } else {
        $query .= " AND color = :color"; 
    }
    $params[':color'] = $color;
}

// Prepare the statement
$stmt = $pdo->prepare($query);

// Bind parameters, if they exist
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

// Execute the statement
$stmt->execute();

// Fetch all results into an array
$shoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if (!empty($shoes)) : ?>
    <?php foreach ($shoes as $shoe) : ?>  
        <div class="column is-4">
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <a href="shoedetail.php?Shoes_ID=<?= htmlspecialchars($shoe['Shoes_ID']) ?>"> <!-- Use $shoe instead of $row -->
                            <img src='../../sphoto/<?= htmlspecialchars($shoe['Shoes_ID']) ?>' width='100'> <!-- Use $shoe instead of $row -->
                        </a>
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-4"><?= htmlspecialchars($shoe['name']) ?></p> <!-- Use $shoe instead of $row -->
                        </div>
                    </div>

                    <div class="content">
                        <?= htmlspecialchars($shoe['title']) ?> <!-- Use $shoe instead of $row -->
                        <br />
                        <p class="title"><?= htmlspecialchars($shoe['price']) ?> บาท</p> <!-- Use $shoe instead of $row -->
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <h2>No shoes found matching the filter criteria.</h2>
<?php endif; ?>
