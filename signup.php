<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>SignUp</title>
</head>
<body>
<div class="center">
        <h1>SignUp</h1>
        <form action="signup.php" method="post">
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
            <input type="submit" value="SignUp" name='signup'>
            <div class="signup_link">
                Already a member? <a href="login.php">Login</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST['signup'])){
        $id = null;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $conn = connectDB();
        $query = 'select id from users where username = ? limit 1';
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]);
        $results = $stmt->fetchAll();
        foreach($results as $res){
            $id = $res['id'];
        }
        if($id) {
            echo '<h1 style="text-align: center;color: red">Username đã tồn tại</h1>';
        }else{
            $query = 'insert into users(username,password) values(?,?)';
            $stmt = $conn->prepare($query);
            $stmt->execute([$username,$password]);
            echo '<h1 style="text-align: center;color: red">Thành Công</h1>';
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