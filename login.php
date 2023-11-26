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
    header('location: index.php');
    exit();
}
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $username=trim($_POST['username']);
    $password=trim($_POST['password']);
    $stmt=$conn->prepare('SELECT*FROM tai_khoan WHERE username=:username ');
        $stmt->bindValue(':username',$username);
        $stmt->execute();
        $kq=$stmt->fetch();
setcookie('username',$username,time()+(86400*7));
setcookie('password',$password,time()+(86400*7));
if($kq&& password_verify($password,$kq['password']))
{
    $_SESSION['username']=$username;
    header('location: index.php');
    exit();
} else {
    echo"<script>alert('Đăng nhập không thành công');</script>";
    $error['login']="Tên đăng nhập hoặc mật khẩu không đúng, vui lòng nhập lại";
}
}
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
    <h1>Login</h1>
    <form action="login.php" method="post">
    <label for="username">Username:</label> <input type="text" name="username" id="username" value="<?php echo  $_COOKIE['username']??''?>"> <br>
        <label for="password">Password:</label> <input type="password" name="password" id="password" value="<?php echo $_COOKIE['password']??''?>"> <br>
        <?php if(isset($error['login'])): ?>
            <p><?php echo $error['login']; ?></p>
        <?php endif; ?>
        <label for="remember">Remember password?</label><input type="checkbox" name="remember" id="remember"><br>
        

        Bạn chưa có tài khoản? <a href="register.php">Bấm vào đây để đăng ký</a> <br>
        <button name="btn" value="login" type="submit">Login</button>
    </form>
</body>
</html>