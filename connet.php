<?php
try{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tasklist";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Lỗi : " . $e->getMessage());
}
?>