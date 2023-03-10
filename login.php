<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
    <div class="center">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="txt_field">
                <input type="text" required name="username">
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="password" required name="password">
                <span></span>
                <label>Password</label>
            </div>
            <input type="submit" value="Login" name="login">
            <div class="signup_link">
                Not a member? <a href="signup.php">SignUp</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    session_start();

    if(isset($_SESSION['id'])){
        header('location:tasklist.php',true,301);
    }

    if(isset($_POST['login'])){
        $id = null;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $conn = connectDB();
        $query = 'select id from users where username = ? and password = ? limit 1';
        $stmt = $conn->prepare($query);
        $stmt->execute([$username,$password]);
        $results = $stmt->fetchAll();
        foreach($results as $res){
            $id = $res['id'];
        }
        if($id) {
            $_SESSION['id'] = $id;
            header('location:tasklist.php',true,301);
        }else{
            echo '<h1 style="text-align: center;color: red">Tài Khoản Hoặc Mật Khẩu Sai</h1>';
        }
        $conn = null;
    }

    function connectDB() {
        $server = 'localhost';
        $user = 'root';
        $pass = '';
        $database = 'bluecyber';
        $conn = new PDO("mysql:hos=$server;dbname=$database",$user,$pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
?>