<?php
require_once("../connection.php");
require_once("../functionality.php");
session_start();

//Determining if the user has logging in
if(!isset($_SESSION['OGS-User-login'])){
    header("Location:../index.php");
    exit();
}

//for logging out the system
if(isset($_GET['logout'])){
    $method->logout();
}

//Getting the full name and cart-table-name of the user
$userId = $_SESSION['User Id'];
$sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`users_table` WHERE `User Id` = '$userId'";
$query = $connect->query($sql) or die ($connect->error);
$row = $query->fetch_assoc();
$name = $row['First Name']." ".$row['Last Name'];
$userCartTable = $row['Username'].$row['User Id']."_table";

$productId = $_GET['productId'];
$sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`product_table`  WHERE `Product Id` = '$productId' ";
$query = $connect->query($sql) or die ($connect->error);
$row = $query->fetch_assoc();

//count the number of items in the cart
$sql0 = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`$userCartTable`";
$query0 = $connect->query($sql0) or die ($connect->error);
$row0 = $query0->fetch_assoc();
$total0 = $query0->num_rows;
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
    <script src="js/jquery.min.js"></script>
</head>
<body>

    <!-- Navigation for computer screens -->
    <nav class="for-computer-screens">
        <ul>
            <li class="searching">
                <div class="wrapper">
                    <form id="search-form" action="" method="GET">
                        <input id="product-name" type="text" name="product-name" placeholder="Product Name">
                        <button type="submit" id="search-query" name="search-query"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                    </form>
                </div>
            </li>
            <li><a class="profile-name" href="index.php"><i class="fa-solid fa-user-large"></i><?php echo " ".$name; ?></a></li>
                <li><a class="cart-counter" href="cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart <p id="cart"><?php if($total0 > 0){echo $total0;}else{echo "0";}?></p></a></li>
                <li><a id="logout" onclick="logout()" href=""><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>          
        </ul>
    </nav>

    <!-- for mobile screens -->
    <nav class="for-mobile-screens" id="for-mobile-screens">
        <ul>
            <li class="search"><button id="search"><i class="fa-solid fa-magnifying-glass"></i></button></li>
            <li><a class="home" href="index.php">Home</a></li>
            <li><a class="cart-counter" href="cart.php"><i class="fa-solid fa-cart-shopping"></i> Cart <p id="mobile-cart"><?php if($total0 > 0){echo $total0;}else{echo "0";}?></p></a></li>
            <li><a id="mobile-logout" onclick="logout()" href=""><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
        </ul>
    </nav>

    <!-- pops-up search bar -->
    <nav id="pop-up-search-bar" class="pop-up-search-bar">
        <ul>
            <li><button class="search-back"><i class="fa-solid fa-arrow-left-long"></i></button></li>
            <li class="form-wrapper">
                <form id="search-form" action="" method="GET">
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
                <img src="../product_images/<?php echo $row['Product Image']; ?>" alt="">
            </div>
        </div>
        <div class="wrapper-2">
            <p><strong>Product Name: </strong><?php echo $row['Product Name']; ?></p>
            <p class="price"><strong>Price: </strong>&#8369;<?php echo $row['Product Price']; ?></p>
            <p><strong>Status: </strong><?php echo $row['Product Status']; ?></p>
            <p><strong>Product Description: </strong><?php echo $row['Product Details']; ?></p>
            <div class="subwrapper-1">
                    <button onclick="addToCart(<?php echo $row['Product Id']; ?>)" class="add-to-cart"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script>
        function addToCart(id){
            var tableName = "<?php echo $userCartTable; ?>";
            $(document).ready(function(){
                $.post(
                    "addToCart.php",
                    {
                        productId: id,
                        userCartTable: tableName
                    },
                    function(data){
                        var alert_data = "The item is already in the cart";
                        if(alert_data === data){
                            alert("The item is already in the cart");
                        }
                        else{
                            $('#cart').html(data);
                            $('#mobile-cart').html(data);
                        }
                    }
                );
            });
        }          

        //for logging out the system
        function logout(){
            var permission = confirm("Are you sure you want to logout?");
            console.log(permission);
            if(permission){
                document.getElementById('logout').href="productview.php?logout=";
            }
        }


        //Manipulating Menus
        $(document).ready(function(){
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


        //for logging out the system
        function logout(){
            var permission = confirm("Are you sure you want to logout?");
            console.log(permission);
            if(permission){
                document.getElementById('logout').href="productview.php?logout=";
                document.getElementById('mobile-logout').href="productview.php?logout=";
            }
        }
    </script>
    
</body>
</html>