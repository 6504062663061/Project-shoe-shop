<?php Include "../../connect.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChicFoot</title>
    <link rel="stylesheet" href="../../css/index.css">
    <script>
        function redirectToCategory() {
            var category = document.getElementById("category").value;

            if (category === "Sneakers") {
                window.location.href = "Sneakersshoemain.php";
            } else if (category === "Sport Shoes") {
                window.location.href = "sportshoemain.php";
            } else if (category === "Slippers") {
                window.location.href = "Flip-flopsmain.php";
            } else if (category === "all"){
                window.location.href = "allshoe.php"; 
            }
        }

        function filterShoes() { 
            var xmlHttp = new XMLHttpRequest();
            var shoeResults = document.getElementById("shoeResults");
            shoeResults.innerHTML = ''; 

            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    shoeResults.innerHTML = xmlHttp.responseText; 
                }
            };

            var min_price = document.getElementById("min_price").value;
            var max_price = document.getElementById("max_price").value;
            var color = document.getElementById("color").value;

            var url = "filter_sport.php?min_price=" + min_price + "&max_price=" + max_price + "&color=" + color;

            xmlHttp.open("GET", url, true);
            xmlHttp.send();
        }

        function clearFilters() {
            document.getElementById("min_price").value = '';
            document.getElementById("max_price").value = '';
            document.getElementById("color").selectedIndex = 0; // Select first option (All Colors)
            showAllProducts(); // Show all products again
        }

        function showAllProducts() {
            var shoeResults = document.getElementById("shoeResults");
            shoeResults.innerHTML = ''; 
            loadAllProducts(); // Load all products
        }

        function loadProducts() {
            var xmlHttp = new XMLHttpRequest();
            var shoeResults = document.getElementById("shoeResults");

            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    shoeResults.innerHTML = xmlHttp.responseText; // Load all products
                }
            };

            xmlHttp.open("GET", "load_sport_shoes.php", true); 
            xmlHttp.send();
        }

        function initFilters() {
            document.getElementById("min_price").addEventListener("input", filterShoes);
            document.getElementById("max_price").addEventListener("input", filterShoes);
            document.getElementById("color").addEventListener("change", filterShoes);
        }

        document.addEventListener('DOMContentLoaded', function() {
            initFilters();
            loadProducts(); 
        });
    </script>
</head>

<?php
include '../../Template/navbar.php';
?>

<body>
    <div  class="fixed-grid">
        <div  class="grid">
            <form id="filterForm" class="cell">
                
                <label for="category">Category:</label>
                <select name="category" id="category" onchange="redirectToCategory()">
                    <option value="all" >All Categories</option>
                    <option value="Sneakers">Sneakers</option>
                    <option value="Sport Shoes" selected>Sport Shoes</option>
                    <option value="Slippers">Slippers</option>
                </select>

              
                <label for="min_price">Min Price:</label>
                <input type="number" name="min_price" id="min_price" placeholder="0" min="0">

                <label for="max_price">Max Price:</label>
                <input type="number" name="max_price" id="max_price" placeholder="10000" min="0">

                
                <label for="color">Color:</label>
                <select name="color" id="color">
                    <option value="">All Colors</option>
                    <option value="Red">Red</option>
                    <option value="Blue">Blue</option>
                    <option value="Black">Black</option>
                    <option value="White">White</option>
                    <option value="Green">Green</option>
                    <option value="Yellow">Yellow</option>
                    <option value="Purple">Purple</option>
                </select>
                
                
                <button type="button" onclick="clearFilters()">Clear Filters</button>
            </form>
        </div>

        
        <div id="shoeResults" class="cell columns is-multiline is-2">
            
        </div>
    </div>
</body>
<?php include '../../Template/footer.php'; ?>
</html>
