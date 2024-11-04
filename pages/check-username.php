<?php
include "../connect.php";

if (isset($_GET['Username'])) {
    $username = $_GET['Username'];
    $stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Username = ?");
    $stmt->bindParam(1, $username);
    $stmt->execute();
    $row = $stmt->fetch();

    if (!$row) {
        echo "okay";
    } else {
        echo "no";
    }

    
}
?>