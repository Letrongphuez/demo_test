<?php
session_start();
$host="localhost";
$username="root";
$password="";
$dbname="qlsv";
$error=[];
$message = '';
try{
    $conn=new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   
}catch(PDOException $e)
{
    echo"Kết nối thất bại".$e->getMessage();
}
if(!isset($_SESSION['username']))
{
    header('Location:login.php');
    exit();
}
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $newpass=trim($_POST['newpass']);
     if(strlen($newpass)<6||strlen($newpass)>60)
     {
        $error['newpass']="Mật khẩu tối thiểu 6 ký tự và tối đa 60 ký tự";
     }
     else{
        $hashed_password = password_hash($newpass, PASSWORD_DEFAULT);

      
        $stmt = $conn->prepare('UPDATE tai_khoan SET password=:password WHERE username=:username');
        $stmt->bindValue(':password', $hashed_password);
        $stmt->bindValue(':username', $_SESSION['username']);
        $stmt->execute();

        $error['newpass'] = 'Cập nhật mật khẩu thành công!';
     }
     if(isset($error['newpass']))
     {
        $error['newpass'];
     }
}
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
    <h1>Account</h1> <br>
    <h2>Update account here</h2>
    <form action="account.php" method="post">
    <label for="newpass">Password:</label><input type="password" name="newpass" id="newpass"> <br>
    <button name="btn" value="update" type="submit">Update</button>
    </form>
    <?php if ($error): ?>
        <p><?php echo $error['newpass']; ?></p>
    <?php endif; ?>
    <a href="index.php">Quay về trang chủ</a>
</body>
</html>
