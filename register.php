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
    echo"<script>alert('Kết nối thành công!');</script>";
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
    if(!$username)
    {
        $error['username']="Tên đăng nhập không được bỏ trống";
    }
    if(isset($error['username']))
    {
        echo$error['username'];
    }
    if(!$password)
    {
        $error['password']="Mật khẩu không được bỏ trống";
    }
    if(isset($error['password']))
        {
            echo$error['password'];
        }
    if(strlen($username)<6||strlen($username)>32)
    {
        $error['username']="Tên đăng nhập tối thiểu 6 ký tự và tối đa 32 ký tự";
    }
    if(isset($error['username']))
    {
        echo$error['username'];
    }

    if(empty($error)){
        $stmt=$conn->prepare('SELECT*FROM tai_khoan WHERE username=:username');
        $stmt->bindValue(':username',$username);
        $stmt->execute();
        $kq=$stmt->rowCount();

        if($kq>0)
        {
            $error['username']="Tên đăng nhập đã tồn tại, vui lòng sử dụng tên khác";
        }
        if(isset($error['username']))
        {
            echo$error['username'];
        }
        if(strlen($password)<6||strlen($password)>60)
        {
            $error['password']="Mật khẩu tối thiểu 6 ký tự và tối đa 60 ký tự";
        }
        if(isset($error['password']))
        {
            echo$error['password'];
        }
        if(empty($error)){
            $pass=password_hash($password,PASSWORD_DEFAULT);
            $stmt=$conn->prepare('INSERT INTO tai_khoan (username, password) VALUES (:username, :password)');
            $stmt->bindValue(':username',$username);
            $stmt->bindValue(':password',$pass);
            if( $stmt->execute())
            {
                echo"Đăng ký thành công";
                echo"<a href='login.php'>Bấm vào đây để đăng nhập</a>";
                exit();
            } else {
        
                echo"Đăng ký không thành công";
               
            }
        }
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
    <h1>Register</h1>
    <form action="register.php" method="post">
        <label for="username">Username:</label> <input type="text" name="username" id="username" value="<?php echo isset($password) ? $password : ''; ?>" > <br>
        <label for="password">Password:</label> <input type="password" name="password" id="password" value="<?php echo isset($password) ? $password : ''; ?>"> <br>
        Bạn đã có tài khoản? <a href="login.php">Bấm vào đây để đăng nhập</a> <br>
        <button name="btn" value="register" type="submit">Register</button>
    </form>
</body>
</html>
