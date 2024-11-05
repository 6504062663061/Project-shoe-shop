<?php include "../../connect.php"; ?>

<!DOCTYPE html>
<html>
<style>
    .shoe-list {
        display: flex;                
        flex-wrap: wrap;             
        justify-content: center;      
        gap: 20px;                   
    }

    .shoe-list > div {
        flex: 0 1 calc(50% - 20px);  
        box-sizing: border-box;      
        max-width: 300px;             
    }
</style>
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
            } else {
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
            

            var url = "filter_shoes.php?min_price=" + min_price + "&max_price=" + max_price ;

            xmlHttp.open("GET", url, true);
            xmlHttp.send();
        }

        function clearFilters() {
            document.getElementById("min_price").value = '';
            document.getElementById("max_price").value = '';
            
            showAllProducts(); // Show all products again
        }

        function showAllProducts() {
            var shoeResults = document.getElementById("shoeResults");
            shoeResults.innerHTML = ''; 
            loadAllProducts(); // Load all products
        }

        function loadAllProducts(page = 1) {
            var xmlHttp = new XMLHttpRequest();
            var shoeResults = document.getElementById("shoeResults");

            xmlHttp.onreadystatechange = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    shoeResults.innerHTML = xmlHttp.responseText;
                }
            };

            var url = "load_all_shoes.php?page=" + page;
            xmlHttp.open("GET", url, true);
            xmlHttp.send();
        }


        function initFilters() {
            document.getElementById("min_price").addEventListener("input", filterShoes);
            document.getElementById("max_price").addEventListener("input", filterShoes);
           
        }

        document.addEventListener('DOMContentLoaded', function() {
            initFilters();
            loadAllProducts(1); 
        });
    </script>
</head>

<?php
include '../../Template/navbar.php';
?>

<body>
    <div >
        <div >
            <form id="filterForm">
                <label for="category">Category:</label>
                <select name="category" id="category" onchange="redirectToCategory()">
                    <option value="">All Categories</option>
                    <option value="Sneakers">Sneakers</option>
                    <option value="Sport Shoes">Sport Shoes</option>
                    <option value="Slippers">Slippers</option>
                </select>

                <label for="min_price">Min Price:</label>
                <input type="number" name="min_price" id="min_price" placeholder="0" min="0">

                <label for="max_price">Max Price:</label>
                <input type="number" name="max_price" id="max_price" placeholder="10000" min="0">

                
                
                <button type="button" onclick="clearFilters()">Clear Filters</button>
            </form>
        </div>

        <div id="shoeResults">
        </div>
    </div>
</body>
<?php include '../../Template/footer.php'; ?>
</html>
