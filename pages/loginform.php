<?php Include "../connect.php";?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="./css/index.css">
  </head>
 
  <body>
    <div class="login-container">
            <div class="logo">
                <img src="../logonew.png" alt="Site Logo">
            </div>
            <form action="check-login.php" method="POST">
                <input type="text" name="Username" placeholder="Username" required>
                <input type="password" name="Password" placeholder="Password" required>
                <input type="submit" value="Login">
            </form>
            
    </div>
</body>

</html>
  
  