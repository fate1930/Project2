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
    $sql = "select * from travelimage where PATH='$target'";
    $result = $pdo->query($sql);
    while ($arr = $result->fetch()){
        $id = $arr['ImageID'];
    }
    $query1 = "Delete from travelimagefavor where UID='$userid' and ImageID='$id'";
    $pdo->exec($query1);
    $pdo = null;
}catch (PDOException $e) {
    die( $e->getMessage() );
}
    echo "<script>function del(){
                     window.location.href = 'mycollection.php?p=1';
                  }
                  del();
              </script>";
