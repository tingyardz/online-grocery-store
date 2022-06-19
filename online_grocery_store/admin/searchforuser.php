<?php
require_once("../connection.php");

if(isset($_POST['inputDetails'])){

    $input = $_POST['inputDetails'];

        $sql = "SELECT * FROM `ezyro_30763974_tyardz_online_store`.`users_table` WHERE `First Name`LIKE'%$input%' || `Last Name`LIKE'%$input%'";
        $query = $connect->query($sql) or die ($connect->error);
        $row = $query->fetch_assoc();
        $total = $query->num_rows;

        if($total > 0){
            $a = "<table>
            <tr>
                <th>User Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Password</th>
            </tr>";

            $b = "";

            do{
                $userId = $row['User Id'];
                $firstName = $row['First Name'];
                $lastName = $row['Last Name'];
                $userName = $row['Username'];
                $password = $row['Password'];
                $b = "$b"."<tr>
                        <td>$userId</td>
                        <td>$firstName</td>
                        <td>$lastName</td>
                        <td>$userName</td>
                        <td>$password</td>
                        </tr>";
            }while($row = $query->fetch_assoc());

            $c = "</table>";

            $output = $a.$b.$c;

            echo $output;
        }
        else{

            echo "<h3 style='width:100%;margin-top:50px;text-align:center;color: rgb(110, 110, 110);'>No Data Found!</h3>";
        }
}