<?php
$username = $_POST['username'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];
$email = $_POST['email'];
$db = mysqli_connect("localhost","fate1930","my=22310=wa","users");
if ( mysqli_connect_errno() ) {
    die( mysqli_connect_error() );
}
if ($repassword == $password) {
    $key = false;
    $str = "select * from traveluser where UserName = '$username'";
    $str1 = "select * from traveluser where Email = '$email'";
    $result = $db->query($str);
    $result1 = $db->query($str1);
    $pass=mysqli_num_rows($result);
    $pass1=mysqli_num_rows($result1);
    if ($pass>0){
        $key = true;
    }
    if ($pass1>0){
        $key = true;
    }
    if($key)
    {
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."该用户名或者邮箱已被注册"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.php"."\""."</script>";
        exit;
    }
    else {
        $salt=rand();
        $password1=sha1($password.$salt);
        $query="INSERT INTO traveluser (UserName,Email,Pass,Salt) VALUES('$username','$email','$password1','$salt')";
        $result = mysqli_query($db,$query) or die("error:".mysqli_error());
        mysqli_close($db);
        echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."注册成功！"."\"".")".";"."</script>";
        echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.php"."\""."</script>";
    }
}
else {
    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."密码不一致！"."\"".")".";"."</script>";
    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register.php"."\""."</script>";
}