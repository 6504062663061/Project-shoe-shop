<?php
include "../connect.php";


$stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Email = ? ");
$stmt->bindParam(1, $_GET["email"]);
$stmt->execute();
$row = $stmt->fetch();

if(!$row){
    echo "";
}else{
    echo "This email has already been used.";
}

?>