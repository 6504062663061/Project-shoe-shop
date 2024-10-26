<?php include "../connect.php"; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot - Profile</title>
    <link rel="stylesheet" href="../css/index.css">
    <style>
      
      body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
      }

      .profile-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        text-align: center;
      }

      .profile-image {
        border-radius: 50%;
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .profile-name {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin: 10px 0;
      }

      .profile-info {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        margin: 10px 0;
      }

      .edit-btn {
        display: inline-block;
        padding: 8px 20px;
        margin-top: 20px;
        font-size: 14px;
        color: #fff;
        background-color: #3498db;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
      }

      .edit-btn:hover {
        background-color: #2980b9;
      }
    </style>
  </head>
  <body>
    <?php include '../Template/navbar.php'; ?>

    <div class="profile-container">
      
        
        
        <?php
        $stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Username = :username");
        $stmt->bindParam(':username', $_SESSION["username"]); 
        $stmt->execute();
        $user = $stmt->fetch();

        $extensions = ['jpg','png','jpeg'];

        $imagePath = '';
        foreach ($extensions as $ext){
            if(file_exists("../memphoto/{$user['Username']}.$ext")){
                $imagePath = "../memphoto/{$user['Username']}.$ext";
                break;
            }
        }
        if($imagePath == ''){
            $imagePath = " ";
        }
        ?>

        <img src="../memphoto/<?=$imagePath?>" alt="Profile Picture" class="profile-image">
      <div class="profile-name"><?= htmlspecialchars($user['Name']); ?></div>
      <div class="profile-info">Email: <?= htmlspecialchars($user['Email']); ?></div>
      <div class="profile-info">Phone: <?= htmlspecialchars($user['Phone']); ?></div>

      
      <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
    </div>

    <?php include '../Template/footer.php'; ?>
  </body>
</html>
