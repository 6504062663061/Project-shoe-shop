<?php Include "connect.php";?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="./css/index.css">
  </head>
  <?php
  include '../Template/navbar.php';
  include '../Template/header.php';
  ?>
  <body>
    <div class="login-container">
            <div class="logo">
                <img src="../logo.png" alt="Site Logo">
            </div>
            <form action="check-login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login">
            </form>
            
    </div>
</body>
<?php include '../Template/footer.php'; ?>
</html>
  
  