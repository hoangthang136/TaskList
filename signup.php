<?php
    $check = false;
    if(isset($_POST['signup'])){
        require_once("./connet.php");
        $id = null;
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = 'select id from users where username = ? limit 1';
        $stmt = $conn->prepare($query);
        $stmt->execute([$username]);
        $results = $stmt->fetchAll();
        foreach($results as $res){
            $id = $res['id'];
        }
        if($id) {
            $check = true;
        }else{
            $query = 'insert into users(username,password) values(?,?)';
            $stmt = $conn->prepare($query);
            $stmt->execute([$username,$password]);
            echo '<script> alert("Đăng ký thành công");</script>';
            header('refresh: 0.5;url=./login.php', true, 301);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./icon/css/all.css">
    <title>Signup</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        html {
            font-family: Arial, Helvetica, sans-serif; /* phông chữ ko chân*/
        }

        body {
            overflow: hidden;
            height: 100vh;
        }
        .center{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }

        .center h1 {
            text-align: center;
            padding: 0 0 20px 0;
        }

        .center form {
            padding: 0 40px;
            box-sizing: border-box;
        }

        form .txt_field {
            position: relative;
            margin: 30px 0;
            border-bottom: 2px solid #adadad;
        }

        .txt_field input{
            width: 100%;
            padding: 0 5px;
            height: 40px;
            font-size: 16px;
            border: none;
            background: none;
            outline: none;
        }

        .txt_field label{
            position: absolute;
            top: 50%;
            left: 5px;
            color: #adadad;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
            transition: .5s;
        }

        .txt_field span::before{
            content: '';
            position: absolute;
            top: 40px;
            left: 0;
            width: 0%;
            height: 2px;
            background: #2691d9;
            transition: .5s;
        }

        .txt_field input:focus ~ label,
        .txt_field input:valid ~ label{
            top: -5px;
            color: #2691d9;
        }

        .txt_field input:focus ~ span::before,
        .txt_field input:valid ~ span::before{
            width: 100%;
        }

        input[type="submit"] {
            width: 100%;
            height: 50px;
            border: 1px solid;
            background: #2691d9;
            border-radius: 25px;
            font-size: 20px;
            color: #e9f4fb;
            margin-top: 15px;
            font-weight: 700;
            cursor: pointer;
            outline:  none;
        }

        input[type="submit"]:hover {
            border-color: #2691d9;
            transition: .5s;
        }

        .signup_link{
            margin: 30px 0;
            text-align: center;
            font-size: 16px;
            color: #666666;
        }

        .signup_link a{
            color: #2691d9;
            text-decoration: none;
        }

        .signup_link a:hover{
            text-decoration: underline;
        }    

        .error {
            color: red;
            font-size: 13px;
        }
        #icon {
            position: absolute;
            top: 40%;
            transform: translateX(-27px);
            opacity: 0.5;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="center">
        <h1>SignUp</h1>
        <form action="signup.php" method="POST">
            <div class="txt_field">
                <input type="text" required name="username">
                <span></span>
                <label>Username</label>
            </div>
            <div class="txt_field">
                <input type="password" required name="password" id="password">
                <span></span>
                <label>Password</label>
                <i class="fa-regular fa-eye" id="icon" onclick="change()"></i>
            </div>
            <?php if ($check) {?>
            <span class="error">*Username already exists<span>
            <?php } ?>
            <input type="submit" value="Signup" name="signup">
            <div class="signup_link">
            Already a member? <a href="./login.php">login</a>
            </div>
        </form>
    </div>
    <script>
        var password = document.getElementById('password');
        var icon = document.getElementById('icon');
        function change() {
            if (password.type == 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash')
            }else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye')
            }
        }
    </script>
</body>
</html>