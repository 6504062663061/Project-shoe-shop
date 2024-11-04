<?php
include '/~csb6563061/Project-shoe-shop/connect.php'; 

if (isset($_GET['query'])) {
    $search = "%" . $_GET['query'] . "%";
    
    $stmt = $pdo->prepare("SELECT * FROM Shoes WHERE name LIKE ?");
    $stmt->bindParam(1, $search);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($results) > 0) {
        foreach ($results as $row) {
            echo "<div class='shoe-result' style='display:flex; '>";
            echo "<img src='/~csb6563061/Project-shoe-shop/sphoto" . $row["Shoes_ID"] . "' alt='" . htmlspecialchars($row['name']) . "' style='width: 100px;'>";
            echo "<p>" . htmlspecialchars($row['name']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No results found</p>";
    }
}
?>
