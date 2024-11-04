<?php 
  session_start();

  if (isset($_SESSION['username'])) {
    $stmt = $pdo->prepare("SELECT * FROM shoemember WHERE Username = ?");
    $stmt->bindParam(1, $_SESSION["username"]);
    $stmt->execute();
    $row = $stmt->fetch();
  }

?>


  

<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChicFoot</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/~csb6563061/Project-shoe-shop/css/index.css">
    <script>
      document.addEventListener('DOMContentLoaded', () => {

      // Get all "navbar-burger" elements
      const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

      // Add a click event on each of them
      $navbarBurgers.forEach( el => {
        el.addEventListener('click', () => {

          // Get the target from the "data-target" attribute
          const target = el.dataset.target;
          const $target = document.getElementById(target);

          // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
          el.classList.toggle('is-active');
          $target.classList.toggle('is-active');

        });
      });

      });


      function searchShoes(query) {
      var dropdown = document.getElementById("searchDropdown");

      if (query.length == 0) {
          dropdown.style.display = "none"; // Hide the dropdown if input is empty
          return;
      }

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var response = this.responseText.trim();
              if (response) {
                  dropdown.innerHTML = response; 
                  dropdown.style.display = "block"; // Show the dropdown if results are found
              } else {
                  dropdown.style.display = "none"; // Hide the dropdown if no results
              }
          }
      };

      xhr.open("GET", "/~csb6563061/Project-shoe-shop/pages/searchShoes.php?query=" + encodeURIComponent(query), true);
      xhr.send();
      }

      function goToShoeDetail(shoeId) {
      window.location.href = "/~csb6563061/Project-shoe-shop/pages/pages/shoedetail.php?Shoes_ID=" + shoeId;
      }
    </script>
</head>
<body>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/index.php">
        <img src="/~csb6563061/Project-shoe-shop/logonew.png" alt="Site Logo" style="width: 160px; height: 50px;">

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
          <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/allshoe.php">
            รองเท้าทั้งหมด

            </a>
            <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/Sneakersshoemain.php">
            Sneakers(รองเท้าผ้าใบ)

            </a>
            <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/sportshoemain.php">
            Sport (รองเท้ากีฬา)
            </a>
            <a class="navbar-item " href="/~csb6563061/Project-shoe-shop/pages/product/Flip-flopsmain.php">
            Flip-flops(รองเท้าแตะ)
            </a>
          
        </div>
      </div>

      <?php if(isset($_SESSION["username"])):?>
        <?php if($row["Status"] == "admin"):?>

          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link" href="">
            Edit

            </a>

            <div class="navbar-dropdown">
                <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/insertP.php">
                Insert product

                </a>
                <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/editP.php">
                Edit product

                </a>
                
                <a class="navbar-item " href="/~csb6563061/Project-shoe-shop/pages/member/editM.php">
                Edit member
                </a>
                <a class="navbar-item " href="/~csb6563061/Project-shoe-shop/pages/order.php">
                Orders
                </a>
              
            </div>
          </div>
        <?php endif;?>
      <?php endif;?>
    </div>


    <div class="navbar-end">
      <div class="navbar-item">

      <div class="navbar-item search">
        <form id="searchForm" onsubmit="return false;">
          <input type="text" id="searchBar" placeholder="search products" onkeyup="searchShoes(this.value)">
        </form>
        <div id="searchDropdown" class="dropdown-search-content" style="display: none;">
          
        </div>
      </div>
      
        
      <?php if (isset($_SESSION["username"])): ?>

        <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/Favorites.php">
          <i class="fas fa-heart"></i>

        </a>
        <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/cart.php">
          <i class="fas fa-shopping-cart"></i>
        </a>
        <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/history.php">
          <i class="fa fa-repeat"></i>
        </a>

        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link" href="">
             
              
              <i class="fas fa-user"></i>
              <span><?= htmlspecialchars($row["Username"]) ?></span>    
              

            </a>
            
              
            <div class="navbar-dropdown">
            
              <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/profile.php">
                Profile
              </a>
              
              <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/logout.php">
                Logout
  
              </a>
                    
            </div>
        </div>
            
      </div>
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

                  

                    
                  
           
            
                    
                  
            
            
                    
                  
