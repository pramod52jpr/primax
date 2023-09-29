<?php include "conn.php" ?>
<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
}
session_abort();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRIMAX</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    $conn=new Conn();
    if(isset($_POST['username']) and isset($_POST['password'])){
        $username=$_POST['username'];
        $password=bin2hex($_POST['password']);
        $result=$conn->read("users","*","`username`='$username' and `password`='$password'");
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            if($row['active']==1){
                session_start();
                $_SESSION['user_id']=$row['user_id'];
                header("Location: dashboard.php");
            }else{
                echo "<script>alert('You are Deactivated by Admin')</script>";
            }
        }else{
            echo "<script>alert('Wrong Username or Password')</script>";
        }
    }
    ?>
    <div class="loginForm" style="background-image: url('https://fxhome.com/wp-content/uploads/2020/09/Blog-e1601541985522-1920x1080.jpg');">
        <form action="" method="post">
            <div class="intro">
                <h2>PRIMAX</h2>
            </div>
            <h3>Login Form</h3>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>