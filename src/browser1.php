<?php
$key = $_POST['key'];
$array = array();
$i = 0;
try {
    $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;', 'fate1930', 'my=22310=wa');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql1 = "select ISO from geocountries where CountryName='$key'";
    $result1 = $pdo->query($sql1);
    $key2 = ($result1->fetch())[0];
    $sql2 = "select AsciiName from geocities where CountryCodeISO='$key2'";
    $result2 = $pdo->query($sql2);
    while ($key3 = $result2->fetch()) {
        $cities = $key3[0];
        $cities1 = addslashes($cities);
        $array[$i] = $cities1;
        $i++;
    }
    $pdo = null;
} catch (PDOException $e) {
    die($e->getMessage());
}
if(!empty($array)){
    $result['status'] = 200;
    $result['data'] = $array;
}else{
    $result['status'] = 220;
}
echo json_encode($result);
