<?php
include '/~csb6563061/Project-shoe-shop/connect.php';

if(isset($_GET['query'])){
    $search = $_GET['query'];

    //  search for shoe name
    $query = "SELECT * FROM Shoes WHERE LOWER(name) LIKE LOWER(?)";
    $stmt = $conn->prepare($query);
    $searchTerm = "%$search%";
    $stmt->bind_param(1, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<div class='dropdown-search-item' onclick='goToShoeDetail(" . $row['Shoes_ID'] . ")'>";
            echo $row['name'];
            echo "</div>";
        }
    } else {
        echo ""; 
        
    }
}
?>
