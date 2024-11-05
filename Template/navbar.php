<?php 
session_start();
include '../connect.php';

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
      function search() {
        const keyword = document.getElementById("keyword").value;
        const resultDiv = document.getElementById("result");

        if (keyword.trim() === "") {
          resultDiv.style.display = "none";
          return;
        }

        const request = new XMLHttpRequest();
        const url = "/~csb6563061/Project-shoe-shop/pages/search.php?keyword=" + encodeURIComponent(keyword);
        request.onreadystatechange = function () {
          if (request.readyState === 4 && request.status === 200) {
            resultDiv.innerHTML = request.responseText;
            resultDiv.style.display = "block";
          }
        };
        request.open("GET", url, true);
        request.send();
      }

      // Hide the search results dropdown when clicking outside
      document.addEventListener("click", function(event) {
        const resultDiv = document.getElementById("result");
        if (!event.target.closest("#keyword") && !event.target.closest("#result")) {
          resultDiv.style.display = "none";
        }
      });

      
      function goToShoeDetail(shoeId) {
        window.location.href = "/~csb6563061/Project-shoe-shop/pages/pages/shoedetail.php?Shoes_ID=" + shoeId;
      }
    </script>
    <style>
      /* Container styling to position the search input and result dropdown */
    .navbar-item.search {
      position: relative;
      width: 250px;
    }

    /* Search Input Field Styling */
    #keyword {
      padding: 8px 12px;
      border: 1px solid #ddd;
      border-radius: 20px;
      width: 100%;
      outline: none;
      font-size: 16px;
      transition: border-color 0.3s;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Input Field Hover and Focus Effects */
    #keyword:hover, #keyword:focus {
      border-color: #3273dc; /* Customize color */
    }

    /* Dropdown Result Container Styling */
    #result {
      position: absolute;
      top: 100%; /* Positions dropdown right below the input field */
      left: 0;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-height: 200px;
      overflow-y: auto;
      z-index: 1000;
      display: none;
      margin-top: 8px;
    }

    /* Dropdown Items */
    #result .item {
      padding: 10px 15px;
      cursor: pointer;
      font-size: 15px;
      color: #333;
      transition: background-color 0.3s, color 0.3s;
      border-bottom: 1px solid #eee;
    }

    /* Last Item without Border */
    #result .item:last-child {
      border-bottom: none;
    }

    /* Item Hover Effect */
    #result .item:hover {
      background-color: #f1f1f1;
      color: #3273dc; /* Customize hover color */
    }

    </style>
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
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/index.php">HOME</a>

      
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">CATEGORIES</a>
        <div class="navbar-dropdown">
          <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/allshoe.php">All Shoes</a>
          <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/Sneakersshoemain.php">Sneakers</a>
          <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/sportshoemain.php">Sport</a>
          <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/Flip-flopsmain.php">Flip-flops</a>
        </div>
      </div>

      
      <?php if(isset($_SESSION["username"]) && $row["Status"] == "admin"): ?>
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">Edit</a>
          <div class="navbar-dropdown">
            <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/insertP.php">Insert Product</a>
            <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/product/editP.php">Edit Product</a>
            <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/member/editM.php">Edit Member</a>
            <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/order.php">Orders</a>
          </div>
        </div>
      <?php endif; ?>
    </div>

    
    <div class="navbar-end">
      <div class="navbar-item">
        <!-- Search Form -->
        <div class="navbar-item search" style="position: relative; width: 250px;">
          <input type="text" id="keyword" placeholder="Search products..." onkeyup="search()">
          <div id="result"></div>
        </div>


        
        <?php if (isset($_SESSION["username"])): ?>
          <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/Favorites.php"><i class="fas fa-heart"></i></a>
          <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/cart.php"><i class="fas fa-shopping-cart"></i></a>
          <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/history.php"><i class="fa fa-repeat"></i></a>
          <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link"><i class="fas fa-user"></i> <span><?= htmlspecialchars($row["Username"]) ?></span></a>
            <div class="navbar-dropdown">
              <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/profile.php">Profile</a>
              <a class="navbar-item" href="/~csb6563061/Project-shoe-shop/pages/logout.php">Logout</a>
            </div>
          </div>
        <?php else: ?>
          <div class="buttons">
            <a class="button is-primary" href="/~csb6563061/Project-shoe-shop/pages/registerform.php"><strong>Sign up</strong></a>
            <a class="button is-light" href="/~csb6563061/Project-shoe-shop/pages/loginform.php">Log in</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>



</body>
</html>
