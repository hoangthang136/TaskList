<?php
    session_start();
    // kiểm tra session để tránh truy cập trực tiếp bằng url
    if(!isset($_SESSION['id'])){
        header('location:login.php',true,301);
    }
    // logout ra khỏi trang main
    if(isset($_POST['btn-logout'])) {
        session_destroy();
        header('location:login.php',true,301);
    }
    $conn = ConnectDB();
    $id = $_SESSION['id'];
    // add dữ liệu vào database
    if(isset($_POST['add'])){
        $task = trim($_POST['newtask']);
        if(empty($task)){
            echo '<h1 style="text-align: center;color: red">New task không được để trống</h1>';
        }else{
            $query = 'insert into tasks(id,task) values (?,?)';
            $stmt = $conn->prepare($query);
            $stmt->execute([$id, $task]);
            header('location:tasklist.php',true,301);
        }
    }

    // xoá dữ liệu khỏi database
    if(isset($_GET['del_task'])){
        $query = 'delete from tasks where stt=?';
        $stmt = $conn->prepare($query);
        $stmt->execute([$_GET['del_task']]);
        header('location:tasklist.php',true,301);
    }

    // in dữ liệu
    $query = 'select * from tasks where id=?';
    $stmt = $conn->prepare($query);
    $stmt->execute([$id]);
    $results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Task List</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Task List</h2>
        </div>
        <form action="tasklist.php" method="post">
            <p>New Task</p>
            <input type="text" name="newtask" class="txt_field" placeholder="Enter task name">
            <button type="submit" name="add" class="btn-add">Thêm</button>
        </form>
        <div class="list">
            <p>Current tasks</p>
        </div>
        <table>
            <tbody>
                <?php 
                    foreach($results as $res) {
                        $task = htmlspecialchars($res['task']);
                ?>
                <tr>
                    <td> <?php echo $task;?> </td>
                    <td style="width: 60px;"><a href="tasklist.php?del_task=<?php echo $res['stt'] ?>">Xoá</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <form action="tasklist.php" method="post">
        <button type="submit" name="btn-logout" class="btn-logout">Logout</button>
    </form>
</body>
</html>


<?php
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