<?php 
    session_start();
    if (!isset($_SESSION['id'])) {
        header('location: ./login.php', true, 301);
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('location: ./login.php', true, 301);
    }

    $userid = $_SESSION['id'];
    require_once('./connet.php');

    if (isset($_POST['submit'])) {
        $query = 'insert into tasks(contents, userid) value(?,?)';
        $smst = $conn->prepare($query);
        $smst->execute([$_POST['nametask'], $userid]);
    }

    if (isset($_GET['taskid'])) {
        $query = 'delete from tasks where id= ? and userid= ?';
        $smst = $conn->prepare($query);
        $smst->execute([$_GET['taskid'], $userid]);
        header('location: ./index.php');
    }

    $query = 'select * from tasks where userid=?';
    $smst = $conn->prepare($query);
    $smst->execute([$userid]);
    $results = $smst->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./icon/css/all.css">
    <title>Home</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        .container {
            width: 50%;
            background-color: #f3f3f3db;
            margin: 0 auto;
        }

        .title {
            text-align: center;
            font-size: 30px;
            color: #FF9800;
            padding: 50px;
        }

        .add {
            text-align: center;
            padding-bottom: 50px; 
        }

        .add > form > input {
            font-size: 15px;
            width: 55%;
            height: 30px;
        }

        .submit {
            margin-left: 20px;
            width: 50px;
            height: 30px;
            font-size: 18px;
            border: none;
            background-color: #F44336;
            cursor: pointer;
        }

        .content {
            width: 90%;
            margin: 10px auto;

        }

        .content > p {
            width: 90%;
            display: inline-block;
            word-break: break-word;
        }

        .content > form {
            display: inline-block;
        }

        .content > form > button {
            border: none;
            font-size: 20px;
            background-color: #03A9F4;
            width: 60px;
            height: 40px;
            cursor: pointer;
        }

        .logout {
            float: right;
            width: 70px;
            height: 30px;
            font-size: 16px;
            border: none;
            background-color: #3f0ee7;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="">
            <form action="" method="post">
                <input type="submit" name="logout" value="Logout" class="logout">
            </form>
        </div>
        <div class="title"><h1><b>TASK LIST</b></h1></div>
        <div class="add">
            <form action="" method="post">
                <input type="text" name="nametask">
                <button type="submit" class="submit" name="submit"><i class="fa-solid fa-plus"></i></button>
            </form>
        </div>
        <div class="contents">
            <?php 
                foreach($results as $res) {
                    echo '<div class="content">
                            <p>'.htmlspecialchars($res['contents']).'</p>
                            <form action="" method="get">
                            <input type="hidden" name="taskid" value="'.$res['id'].'">
                            <button type="submit" class="xoa"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>';
                }
            ?>
        </div>
                
    </div>
</body>
</html>