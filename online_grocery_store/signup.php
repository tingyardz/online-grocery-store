<?php
require_once('connection.php');
require_once('functionality.php');

//User Sign Up
if(isset($_POST['sign-up'])){
    $method->userSignUp();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-Yardz Online Store</title>
    <link rel="stylesheet" href="css/signup.style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="shortcut icon" href="icon/logo.ico" type="image/x-icon">
    <script src="js/jquery.min.js"></script>
</head>
<body>
    
    <nav>
        <ul>
            <li><a href="index.php"><button><i class="fas fa-arrow-left"></i> Back</button></a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="wrapper">
            <h2>Sign Up</h2>
            <form id="signup-form" action="signup.php" method="POST">
                <input id="firstname" type="text" name="firstname" placeholder="First Name">
                <input id="lastname" type="text" name="lastname" placeholder="Last Name">
                <input id="username" type="text" name="username" placeholder="Username">
                <input id="password" type="password" name="password" placeholder="Password" minlength="8">
                <input id="confirm-password" type="password" name="confirm-password" placeholder="Confirm Password" minlength="8">
                <button id="submit-btn" onclick = "return validateForm()" type="submit" name="sign-up">Submit Form</button>
            </form>
        </div>
    </div>
    

    <!-- Javascript -->
    <script>
         //Validating Sign Up Form
         function validateForm(){
             var password = document.querySelector('#password');
             var confirmPassword = document.querySelector('#confirm-password');
             var input_fields = document.querySelectorAll('input');
             var hasEmptyField = false;
         
             for(var i = 0; i < input_fields.length; i++){
                 if(input_fields[i].value.length == 0){
                     input_fields[i].focus();
                     hasEmptyField = true;
                     break;
                 }
             }
         
             if(hasEmptyField){
                 return false;
             }else{
                 if(password.value != confirmPassword.value){
                     alert("Please check your password!");
                     password.value = "";
                     confirmPassword.value = "";
                     password.focus();
                     return false;
                 }
             }
         }
    </script>

    <?php
        if(isset($_GET['rechange'])){
    ?>
    <script>
        alert("Please change your password because it is very weak!");
        var firstname = "<?php echo $_GET['firstname']; ?>";
        var lastname = "<?php echo $_GET['lastname']; ?>";
        var username = "<?php echo $_GET['username']; ?>";

        document.querySelector("#firstname").value = firstname;
        document.querySelector("#lastname").value = lastname;
        document.querySelector("#username").value = username;
        document.querySelector("#password").focus();
    </script>
    <?php
        }
    ?>


</body>
</html>