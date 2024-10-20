<?php 
  session_start();
?>
  

<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="./css/index.css">
    <script src="/~csb6563061/Project-shoe-shop/script.js"></script>
</head>
<body>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="">
        <img src="/~csb6563061/Project-shoe-shop/logo.png" alt="Site Logo" style="width: 200px; height: 400px;">

    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="">
              
      </a>

      <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/index.php">
        HOME
      </a>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="">
        CATEGORIES

        </a>

        <div class="navbar-dropdown">
            <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/Sneakersshoemain.php">
            Sneakers(รองเท้าผ้าใบ)

            </a>
            <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/sportshoemain.php">
            Sport (รองเท้ากีฬา)
            </a>
            <a class="navbar-item " href="/~csb6563061/Project-shoe-shop/pages/Flip-flopsmain.php">
            Flip-flops(รองเท้าแตะ)
            </a>
          
        </div>
      </div>
    </div>


    <div class="navbar-end">
      <div class="navbar-item">
        
        <?php if (isset($_SESSION["username"])): ?>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Username = ?");
            $stmt->bindParam(1, $_SESSION["username"]);
            $stmt->execute();
            $row = $stmt->fetch();

            $image_extensions = ['jpg', 'jpeg', 'png'];
                foreach ($image_extensions as $ext) {
                    if (file_exists("/~csb6563061/Project-shoe-shop/memphoto/{$row['Username']}.$ext")) {
                        echo "<a><img src='/~csb6563061/Project-shoe-shop/memphoto/{$row['Username']}.$ext' width='50'></a>";
                        break;
                    }
                }

                
            
            ?>

        <?php else: ?>
            <div class="buttons">
            <a class="button is-primary" href="">
                <strong>Sign up</strong>
            </a>
            <a class="button is-light" href="/~csb6563061/Project-shoe-shop/pages/loginform.php">
                Log in
            </a>
            </div>

        <?php endif; ?>
      </div>
    </div>



  </div>
</nav>
    
</body>

</html>
