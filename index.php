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

$conn=null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if(isset($_SESSION['username'])): ?>
        <h1>Xin chào, <?php echo $_SESSION['username']; ?>!</h1>
        <a href="logout.php">Đăng xuất</a>
        <a href="account.php">View Account</a>
    <?php else :?>
        <?php if(isset($_SESSION['message'])): ?>
            <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>
        <a href="login.php">Đăng nhập</a>
        <a href="register.php">Đăng ký</a>
    <?php endif; ?>
</body>
</html>
