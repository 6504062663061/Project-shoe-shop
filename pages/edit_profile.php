<?php
include "../connect.php";
session_start();



$stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Username = :username");
$stmt->bindParam(':username', $_SESSION["username"]); 
$stmt->execute();
$user = $stmt->fetch();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $updateStmt = $pdo->prepare("UPDATE shoemember SET Name = :name, Email = :email, Phone = :phone WHERE Username = :username");
    $updateStmt->bindParam(':name', $name);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':phone', $phone);
    $updateStmt->bindParam(':username', $_SESSION['username']);
    $updateStmt->execute();

    
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - ChicFoot</title>
    <link rel="stylesheet" href="../css/index.css">
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
      }
      .edit-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
      }
      h2 {
        text-align: center;
        color: #333;
      }
      label {
        font-weight: bold;
        display: block;
        margin: 15px 0 5px;
        color: #555;
      }
      input[type="text"], input[type="email"], input[type="tel"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
      }
      .save-btn {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        color: #fff;
        background-color: #3498db;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
      }
      .save-btn:hover {
        background-color: #2980b9;
      }
    </style>
</head>
<body>
    <?php include '../Template/navbar.php'; ?>

    <div class="edit-container">
        <h2>Edit Profile</h2>
        <form method="POST" action="edit_profile.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?=htmlspecialchars($user['Name'])?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?=htmlspecialchars($user['Email'])?>" required>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="<?=$user['Phone']?>">

            <button type="submit" class="save-btn">Save Changes</button>
        </form>
    </div>

    <?php include '../Template/footer.php'; ?>
</body>
</html>
