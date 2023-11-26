<?php
session_start();
$host="localhost";
$username="root";
$password="";
$dbname="qlsv";
$error=[];
try{
    $conn=new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   
}catch(PDOException $e)
{
    echo"Kết nối thất bại".$e->getMessage();
}
if(isset($_SESSION['username']))
{
    unset($_SESSION['username']);
    $_SESSION['message']="Đăng xuất thành công";
}
session_destroy();
header('Location: index.php');
exit();
$conn=null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>