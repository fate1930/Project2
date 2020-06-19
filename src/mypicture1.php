<?php error_reporting(5);
session_start();
$username = $_SESSION['username'];
$target = $_GET['target'];
try {
    $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;','fate1930','my=22310=wa');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlid = "select * from traveluser where UserName='$username' or Email='$username'";
    $resultid = $pdo->query($sqlid);
    while ($arrid = $resultid->fetch()){
        $userid = $arrid['UID'];
    }
    $query1 = "Delete from travelimage where UID='$userid' and PATH='$target'";
    $pdo->exec($query1);
    $pdo = null;
}catch (PDOException $e) {
    die( $e->getMessage() );
}
echo "<script>function del(){
                     window.location.href = 'mypicture.php?p=1';
                  }
                  del();
              </script>";
