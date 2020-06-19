<?php error_reporting(5);
session_start();
$username = $_SESSION['username'];
if(isset($_GET['path'])){
    $file5 = $_GET['path'];
}
else {
    $file5 = $_POST['file5'];
}
$pt = $_POST['pt'];
$pd = $_POST['pd'];
$content = $_POST['content'];
$country = $_POST['country'];
$city = $_POST['city'];
try {
    $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;','fate1930','my=22310=wa');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlid = "select * from traveluser where UserName='$username' or Email='$username'";
    $resultid = $pdo->query($sqlid);
    while ($arrid = $resultid->fetch()){
        $userid = $arrid['UID'];
    }
    $sql = "select * from geocountries where CountryName='$country'";
    $result = $pdo->query($sql);
    while ($arr = $result->fetch()){
        $country1 = $arr['ISO'];
    }
    $sql1 = "select * from geocities where AsciiName='$city'";
    $result1 = $pdo->query($sql1);
    while ($arr1 = $result1->fetch()){
        $city1 = $arr1['GeoNameID'];
    }
    if (isset($_GET['path'])){
        $query = "update travelimage set UID='$userid',Title='$pt',Description='$pd',Content='$content',CountryCodeISO='$country1',CityCode='$city1' where PATH='$file5'";
    }else {
        $query = "INSERT INTO travelimage (UID,PATH,Title,Description,Content,CountryCodeISO,CityCode) VALUES ('$userid','$file5','$pt','$pd','$content','$country1','$city1')";
    }
    $pdo->exec($query);
    $pdo = null;
}catch (PDOException $e) {
    die( $e->getMessage() );
}
echo "<script>function insert(){
                     window.location.href = 'mypicture.php?p=1';
                  }
                  insert();
              </script>";

