<?php
session_start(); 

include("include/db.php");

if(isset($_POST["submit"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Validate and sanitize input data
    $email = mysqli_real_escape_string($conn, $email);

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
    $row = mysqli_fetch_assoc($result);

    if(mysqli_num_rows($result) > 0){
        // Verify the password
        if($password == $row["password"]){
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: adminhome.php");
            exit();
        }
        else{
            echo "<script>alert('Wrong Password')</script>";
        }
    }
    else{
        echo "<script>alert('Invalid Credentials')</script>";
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include('include/header.php'); ?>
<form action="login.php" method="POST">
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="active"> Sign In </h2>
            <br><br>
            <!-- Icon -->
            <div class="user-logo">
            <img src="images/librarian.png" id="icon" alt="User Icon" />
            </div>
            <!-- Login Form -->
            <input type="text" name="email" id="email" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <br><br>
            <button type="submit" name="submit" class="submit">Submit</button>        
        </div>
    </div>
</form>
</body>
</html>
