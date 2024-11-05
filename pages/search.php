<?php
include '../connect.php'; 

$keyword = $_GET['keyword'];

$query = $pdo->prepare("SELECT * FROM shoes WHERE name LIKE ?");
$query->execute(["%$keyword%"]);
$results = $query->fetchAll();

if (count($results) > 0) {
    foreach ($results as $row) {
        // Use single quotes around the href and proper concatenation
        echo "<a href='/~csb6563061/Project-shoe-shop/pages/product/shoedetail.php?Shoes_ID=" . htmlspecialchars($row["Shoes_ID"]) . "'>";
        echo "<div class='item' >" . htmlspecialchars($row['name']) . "</div>";
        echo "</a>";
    }
} else {
    echo "<div class='item'>No results found</div>";
}
?>
