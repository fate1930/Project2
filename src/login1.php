<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$db = mysqli_connect("localhost", "fate1930", "my=22310=wa", "users");
if ( mysqli_connect_errno() ) {
    die( mysqli_connect_error() );
}
$salt = "select * from traveluser where UserName = '$username' or Email = '$username'";
$res1 = $db->query($salt);
$row = mysqli_fetch_array($res1);
$depassword = sha1($password.$row[4]);
$sql = "select * from traveluser where (UserName = '$username' or Email = '$username') and Pass= '$depassword'";
$res = $db->query($sql);
$result = $res->fetch_assoc();
if (!($result == null)){
    mysqli_close($db);
    $_SESSION['username']=$_POST['username'];
    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."../index.php"."\""."</script>";
}else{
    echo"<script type="."\""."text/javascript"."\"".">"."window.alert"."("."\""."用户名或者密码不正确！"."\"".")".";"."</script>";
    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."login.php"."\""."</script>";
}