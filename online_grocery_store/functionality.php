<?php
    class Programs{

    public $connect;

    public function __construct($connect){

        $this->connect = $connect;
    }

    public function submitOrder(){

        $date = $_POST['date'];
        $time = $_POST['time'];
        $userCartTable = $_POST['user-cart-table'];
        $specificAddress = $_POST['address'];
        $contactNumber = $_POST['contact-number'];
        $userFullName = $_POST['user-fullname'];
        $purchaseUserTable = "purchase_".$userCartTable;

        $sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`$userCartTable`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $row = $query->fetch_assoc();
        
        do{
            $productName = $row['Product Name'];
            $productQuantity = $row['Product Quantity'];
            $productPrice = $row['Product Price'];
            $productImage = $row['Product Image'];
            $amount = $productPrice * $productQuantity;

            //add to user purchase table
            $sql2 = "INSERT INTO `ezyro_30763974_tyardz_online_store`.`$purchaseUserTable`(`Product Name`, `Product Quantity`, `Product Price`, `Product Image`, `Amount`) 
                     VALUES ('$productName','$productQuantity','$productPrice','$productImage','$amount')";
            $query2 = $this->connect->query($sql2) or die ($this->connect->error);


        }while($row = $query->fetch_assoc());

        //add to order admin management table
        $sql1 = "INSERT INTO `ezyro_30763974_tyardz_online_store`.`admin_order_table`(`Customer Name`, `Contact Number`, `Specific Address`, `Date`, `Time`, `Purchase User Table`) 
                 VALUES ('$userFullName','$contactNumber','$specificAddress','$date','$time','$purchaseUserTable')";
        $query1 = $this->connect->query($sql1) or die ($this->connect->error);

        $sql3 = "TRUNCATE `ezyro_30763974_tyardz_online_store`.`$userCartTable`";
        $query3 = $this->connect->query($sql3) or die ($this->connect->error);

        echo '<script>alert("Your order has been successfully sent to the seller...\nJust wait for the delivery within 24 hours! ");
            window.location.href="cart.php";
        </script>';
        exit();
    }

    public function adminOrderTable(){

        $sql = "CREATE TABLE IF NOT EXISTS `ezyro_30763974_tyardz_online_store`.`admin_order_table`(
            `Order No` int (11) auto_increment PRIMARY KEY,
            `Status` varchar (50),
            `Purchase User Table` varchar (100),
            `Customer Name` varchar (100),
            `Contact Number` varchar (50),
            `Specific Address` text,
            `Date` varchar (50),
            `Time` varchar (50)
        )";
        $query = $this->connect->query($sql) or die ($this->connect->error);
    }

    public function removeProductFromCart($id,$tableName){

        $productId = $id;
        $sql = "DELETE FROM `ezyro_30763974_tyardz_online_store`.`$tableName` WHERE `Product Id` = '$productId'";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        echo '<script>alert("The item has been removed!"); window.location.href="cart.php"</script>';
    }

    public function createDB(){

        $sql = "CREATE DATABASE IF NOT EXISTS `ezyro_30763974_tyardz_online_store`";
        $query = $this->connect->query($sql) or die ($this->connect->error);
    }

    public function createTable(){

        $sql = "CREATE TABLE IF NOT EXISTS `ezyro_30763974_tyardz_online_store`.`product_table`(
            `Product Id` int (11) auto_increment PRIMARY KEY,
            `Product Name` varchar (50),
            `Product Price` float,
            `Product Status` varchar (50),
            `Product Details` text,
            `Product Image` varchar (100)
        )";
        $query = $this->connect->query($sql) or die ($this->connect->error);

        $sql = "CREATE TABLE IF NOT EXISTS `ezyro_30763974_tyardz_online_store`.`users_table`(
            `User Id` int (11) auto_increment PRIMARY KEY,
            `First Name` varchar (100),
            `Last Name` varchar (100),
            `Username` varchar (50),
            `Password` varchar (50)
        )";
        $query = $this->connect->query($sql) or die ($this->connect->error);
    }

    public function searchItem(){

        $productName = $_GET['product-name'];

        if(!empty($productName)){

            $sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`product_table` WHERE `Product Name` LIKE '%$productName%' LIMIT 20";
            $query = $this->connect->query($sql) or die ($this->connect->error);
            $total = $query->num_rows;

            if($total > 0){
            return $query;
            }
            else{
                return false;
            }
        }

    }

    public function logout(){

        session_destroy();
        header("Location:../index.php");
    }

    public function login(){

        $userName = $_POST['username'];
        $password = $_POST['password'];

        //rechecking the database to determine if the username and password are already exist
        $sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`users_table` WHERE `Username` = '$userName' AND `Password` = '$password'";
        $query = $this->connect->query($sql) or die ($this->connect->error);
        $row = $query->fetch_assoc();
        $total = $query->num_rows;

        if($total == 1){

            session_start();
            $_SESSION['OGS-User-login'] = true;
            $_SESSION['User Id'] = $row['User Id'];
            header("Location:users");
            exit();
        }
        else{
            header("Location:login.php?mis_unorpass=");
            exit();
        }

    }

    public function userSignUp(){
            
            $firstName = $_POST['firstname'];
            $lastName = $_POST['lastname'];
            $userName = $_POST['username'];
            $password = $_POST['password'];

            //rechecking the database to determine if the username and password are already exist
            $sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`users_table` WHERE `Username` = '$userName' AND `Password` = '$password'";
            $query = $this->connect->query($sql) or die ($this->connect->error);
            $row = $query->fetch_assoc();
            $total = $query->num_rows;

            if($total == 0){
            //Insert new users information in the database
            $sql = "INSERT INTO `ezyro_30763974_tyardz_online_store`.`users_table`(`First Name`, `Last Name`, `Username`, `Password`) 
                    VALUES ('$firstName','$lastName','$userName','$password')";
            $query = $this->connect->query($sql) or die ($this->connect->error);

            //get user's id and username from the database
            $sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`users_table` WHERE `Username` = '$userName' AND `Password` = '$password'";
            $query = $this->connect->query($sql) or die ($this->connect->error);
            $row = $query->fetch_assoc();
            $total = $query->num_rows;

            $userId = $row['User Id'];
            $username = $row['Username'];

            //Create user cart table
            $tableName = "$username$userId"."_table";
            $sql = "CREATE TABLE IF NOT EXISTS  `ezyro_30763974_tyardz_online_store`.`$tableName`
            (
                `Id` int(11) auto_increment Primary Key,
                `Product Id` int(11),
                `Product Name` varchar(100),
                `Product Quantity` int(11),
                `Product Price` float,
                `Product Image` varchar(100),
                `Total` float
            )
            ";
                $query = $this->connect->query($sql) or die ($this->connect->error);

                //Create User Purchase Cart table
                $tableName = "purchase_"."$username$userId"."_table";
                $sql = "CREATE TABLE IF NOT EXISTS  `ezyro_30763974_tyardz_online_store`.`$tableName`
                (
                    `Id` int(11) auto_increment Primary Key,
                    `Product Name` varchar(100),
                    `Product Quantity` int(11),
                    `Product Price` float,
                    `Product Image` varchar(100),
                    `Amount` float
                )
                ";
                $query = $this->connect->query($sql) or die ($this->connect->error);

                echo '<script>
                        alert("Your are successfully registered...\nYou can login now!");
                        window.location.href="login.php";
                </script>';


                }
                else{
                    header("Location:signup.php?rechange=&firstname=$firstName&lastname=$lastName&username=$userName");
                }
    }
}
    $method = new Programs($connect);
?>