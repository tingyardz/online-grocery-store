<?php
require_once("connection.php");

if(isset($_POST['productName'])){
    $product = $_POST['productName'];
    $newItemCounts = $_POST['newItemCounts'];
    $sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`product_table` WHERE `Product Name` LIKE '%$product%' LIMIT $newItemCounts";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total_product = $query->num_rows;

    if($total_product > 0){
        
        do{

            $productId = $row['Product Id'];
            $productImage = $row['Product Image'];
            $productName = $row['Product Name'];
            $productPrice = $row['Product Price'];
            $productStatus = $row['Product Status'];
    
            $product = "
                <div class='sub-wrapper'>
                <div class='mini-wrapper-1'><a href='productview.php?productId=$productId'><img src='product_images/$productImage'></a></div>
                <div class='mini-wrapper-2'><label><strong><a href='productview.php?productId=$productId'>$productName</a></strong></label></div>
                <div class='mini-wrapper-3'><label><em>&#8369;$productPrice</em></label></div>
                <div class='mini-wrapper-4'><label><small>Status: $productStatus</small></label></div>
                <div class='mini-wrapper-5'><button class='add-to-cart 'onclick='addToCart()'><i class='fa-solid fa-cart-shopping'></i> Add to Cart</button></div>
                </div>
                ";

    
            echo $product;
        
        }while($row = $query->fetch_assoc());
    }
}
else{
    $newItemCounts = $_POST['newItemCounts'];
    $sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`product_table` LIMIT $newItemCounts";
    $query = $connect->query($sql) or die ($connect->error);
    $row = $query->fetch_assoc();
    $total_product = $query->num_rows;

    if($total_product > 0){

        do{

            $productId = $row['Product Id'];
            $productImage = $row['Product Image'];
            $productName = $row['Product Name'];
            $productPrice = $row['Product Price'];
            $productStatus = $row['Product Status'];
    
            $product = "
                <div class='sub-wrapper'>
                <div class='mini-wrapper-1'><a href='productview.php?productId=$productId'><img src='product_images/$productImage'></a></div>
                <div class='mini-wrapper-2'><label><strong><a href='productview.php?productId=$productId'>$productName</a></strong></label></div>
                <div class='mini-wrapper-3'><label><em>&#8369;$productPrice</em></label></div>
                <div class='mini-wrapper-4'><label><small>Status: $productStatus</small></label></div>
                <div class='mini-wrapper-5'><button class='add-to-cart 'onclick='addToCart()'><i class='fa-solid fa-cart-shopping'></i> Add to Cart</button></div>
                </div>
                ";

    
            echo $product;
        
        }while($row = $query->fetch_assoc());
    }
}


?>

