<?php
include "../connect.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['confirmPassword']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone = "000-000-0000"; 
    $address = ""; 
    $status = "cus";

    

    

    
    $insertStmt = $pdo->prepare("INSERT INTO shoemember (Username, Password, Name, Address, Phone, Email, Status)
                                  VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    try {
        
        $insertStmt->execute([$username, $password, "$firstname $lastname", $address, $phone, $email, $status]);
        
        
        session_start();
        $_SESSION["fullname"] = "$firstname $lastname";   
        $_SESSION["username"] = $username;
        $_SESSION["usertype"] = $status;

        
        header("Location: ./profile.php");
        exit();
    } catch (PDOException $e) {
        
        echo "Error during registration: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request method.";
}
?>
