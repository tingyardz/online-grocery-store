<?php
require_once("connection.php");

$productId = $_GET['productId'];

$sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`product_table`  WHERE `Product Id` = '$productId' ";
$query = $connect->query($sql) or die ($connect->error);
$row = $query->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-Yardz Online Store</title>
    <link rel="stylesheet" href="css/productview.style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="shortcut icon" href="icon/logo.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Gothic&family=Teko:wght@500&display=swap" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
</head>
<body>

    <!-- Navigation for computer screens -->
    <nav id="for-computer-screens" class="for-computer-screens">
        <ul>
            <li class = "shop-name"><p><a href="index.php">T-Yardz Online Store</a></p></li>
            <li class="searching">
                    <div class="wrapper">
                        <form id="search-form" action="index.php" method="GET">
                            <input id="product-name" type="text" name="product-name" placeholder="Product Name">
                            <button type="submit" id="search-query" name="search-query"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </form>
                    </div>
            </li>
            <li><a href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a></li>
            <li><a href="signup.php"><i class="fa-solid fa-right-to-bracket"></i> Sign Up</a></li>
        </ul>
    </nav>

    <!-- Navigation for mobile phones -->
    <nav id="for-mobile-screens" class="for-mobile-screens">
        <ul>
            <li><button id="menu-bar"><i class="fa-solid fa-bars"></i></button></li>
            <li class = "shop-name"><a href="index.php">T-Yardz Online Store</a></li>
            <li class="search"><button id="search"><i class="fa-solid fa-magnifying-glass"></i></button></li>
        </ul>
    </nav>

    <!-- pop-up menu -->
    <div class="menu">
        <ul>
            <li class="close"><button id="close"><i class="fa-solid fa-xmark"></i></button></li>
            <li><a href="login.php"><button class="login"><i class="fa-solid fa-right-to-bracket"></i>Login</button></a></li>
            <li><a href="signup.php"><button class="signup"><i class="fa-solid fa-right-to-bracket"></i> Sign Up</button></a></li>
        </ul>
    </div>

    <!-- pop-up search bar -->
    <nav id="pop-up-search-bar" class="pop-up-search-bar">
        <ul>
            <li><button class="search-back"><i class="fa-solid fa-arrow-left-long"></i></button></li>
            <li class="form-wrapper">
                <form id="search-form" action="index.php" method="GET">
                    <input class="search-input" id="product-name" type="text" name="product-name" placeholder="Product Name">
                    <button class="search-submit" type="submit" id="search-query" name="search-query"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h6><?php echo $row['Product Name']; ?></h6>
        <div class="wrapper-1">
            <div class="subwrapper-1">
                <img src="product_images/<?php echo $row['Product Image']; ?>" alt="">
            </div>
        </div>
        <div class="wrapper-2">
            <p><strong>Product Name: </strong><?php echo $row['Product Name']; ?></p>
            <p class="price"><strong>Price: </strong>&#8369;<?php echo $row['Product Price']; ?></p>
            <p><strong>Status: </strong><?php echo $row['Product Status']; ?></p>
            <p><strong>Product Description: </strong><?php echo $row['Product Details']; ?></p>
            <div class="subwrapper-1">
                    <button onclick="addToCart()"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script>
        //Manipulating Menus
        $(document).ready(function(){
            $('#menu-bar').click(function(){
                $('.menu').fadeIn();
            });
            $('#close').click(function(){
                $('.menu').fadeOut();
            });
            $('#search').click(function(){
                $('#for-mobile-screens').hide();
                $('#pop-up-search-bar').fadeIn(function(){
                    $('.search-input').focus();
                });

            });
            $('.search-back').click(function(){
                $('#for-mobile-screens').show();
                $('#pop-up-search-bar').hide();
            });
        });


        //adding item to the cart       
        function addToCart(){
            alert("Please login your account!");
        }      
    </script>

    
</body>
</html>