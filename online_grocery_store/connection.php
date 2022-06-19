<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "ezyro_30763974_tyardz_online_store";

try{
    $connect = mysqli_connect($serverName, $userName, $password, $dbName);
}catch(Exception $e){
    echo $e->getMessage();
    echo "<br>Connection Failed!";
}
?>