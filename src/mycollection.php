<?php error_reporting(5);
session_start();
if(!isset($_SESSION['username'])){
    echo '您还没有登录！';
    echo "<script>function insert(){
                     window.location.href = '../index.php';
                  }
                  insert();
              </script>";
}
?>
<!doctype html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <title>Mycollection</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/samestyle.css" rel="stylesheet" type="text/css">
    <link href="css/mycollection.css" rel="stylesheet" type="text/css">
    <?php require_once "php/selfchange.php"; ?>
    <?php
    function addp($number){
        if($number == 0){
            echo "<script>function addpages(){
                           var addpage = document.getElementById('numbers3');
                           var papre = document.createElement('a');
                           papre.text = '<<';
                           addpage.appendChild(papre);
                           for (var k=0;k<5;k++){
                               var pa =document.createElement('a');
                               pa.text = String(k+1);
                               addpage.appendChild(pa);
                           }
                           var panex = document.createElement('a');
                           panex.text = '>>';
                           addpage.appendChild(panex);
                           document.getElementById('pic1').getElementsByClassName('title')[0].textContent = '您还没有收藏照片';
                      }
                      addpages();
                  </script>";
        }
        else if($number >= 5){
            $prepage = $_GET['p'];
            echo "<script>function addpages(){
                           var prepage = parseInt('$prepage');
                           var number;
                           var addpage = document.getElementById('numbers3');
                           var papre = document.createElement('a');
                           var url = window.location.href;
                           papre.text = '<<';
                           if (Number(url.substring(url.length-1,url.length)) == 1){
                               number =1;
                           }
                           else {
                               number = Number(url.substring(url.length-1,url.length))-1;
                           }
                           papre.href = window.location.href.substring(0,window.location.href.length-1) + number;
                           addpage.appendChild(papre);
                           for (var k=0;k<5;k++){
                               var pa =document.createElement('a');
                               pa.text = String(k+1);
                               if((k+1) == prepage){
                                   pa.style.color = '#FF0000';
                               }
                               pa.href = window.location.href.substring(0,window.location.href.length-1) + String(k+1);
                               addpage.appendChild(pa);
                           }
                           var panex = document.createElement('a');
                           panex.text = '>>';
                           if (Number(url.substring(url.length-1,url.length)) == 5){
                               number =5;
                           }
                           else {
                               number = Number(url.substring(url.length-1,url.length))+1;
                           }
                           panex.href = window.location.href.substring(0,window.location.href.length-1) + number;
                           addpage.appendChild(panex);
                      }
                      addpages();
                  </script>";
        }
        else{
            $prepage = $_GET['p'];
            echo "<script>function addpages(){
                           var prepage = parseInt('$prepage');
                           var key = '$number';
                           var number;
                           var addpage = document.getElementById('numbers3');
                           var papre = document.createElement('a');
                           var url = window.location.href;
                           papre.text = '<<';
                           if (Number(url.substring(url.length-1,url.length)) == 1){
                               number =1;
                           }
                           else {
                               number = Number(url.substring(url.length-1,url.length))-1;
                           }
                           papre.href = window.location.href.substring(0,window.location.href.length-1) + number;
                           addpage.appendChild(papre);
                           for (var k=0;k<key;k++){
                               var pa =document.createElement('a');
                               pa.text = String(k+1);
                               if((k+1) == prepage){
                                   pa.style.color = '#FF0000';
                               }
                               pa.href = window.location.href.substring(0,window.location.href.length-1) + String(k+1);
                               addpage.appendChild(pa);
                           }
                           var panex = document.createElement('a');
                           panex.text = '>>';
                           if (Number(url.substring(url.length-1,url.length)) == key){
                               number = key;
                           }
                           else {
                               number = Number(url.substring(url.length-1,url.length))+1;
                           }
                           panex.href = window.location.href.substring(0,window.location.href.length-1) + number;
                           addpage.appendChild(panex);
                      }
                      addpages();
                  </script>";
        }
    }?>
    <?php function getImage(){
        session_start();
        try {
            $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;','fate1930','my=22310=wa');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $username = $_SESSION['username'];
            $sqlid = "select * from traveluser where UserName='$username' or Email='$username'";
            $resultid = $pdo->query($sqlid);
            while ($arrid = $resultid->fetch()){
                $userid = $arrid['UID'];
            }
            $prepa = $_GET['p'];
            $prepa1 = intval(4*(intval($prepa)-1));
            $pro = "select * from travelimagefavor where UID='$userid' limit $prepa1,4";
            $pro1 = $pdo->query($pro);
            $count = "select count(*) as 'count' from travelimagefavor where UID='$userid'";
            $result1 = $pdo->query($count);
            $count1 = 0;
            while ($arr = $result1->fetch()) {
                $count1 = $arr['count'];
            }
            $pagesize = 4;
            $pages = ceil($count1/$pagesize);
            addp($pages);
            $i = 1;
            while($pro2 = $pro1->fetch()){
                $id = $pro2['ImageID'];
                $sql = "select * from travelimage where ImageID='$id'";
                $result = $pdo->query($sql);
                while ($row = $result->fetch()) {
                    $path = $row['PATH'];
                    $title = $row['Title'];
                    $intro = $row['Description'];
                    $intro1 =  addslashes($intro);
                    $title1 = addslashes($title);
                    echo "<script> function change(){
                      var path = '$path';
                      var title = '$title1';
                      var intro = '$intro1';
                      var i = '$i';
                      document.getElementById('pic' + i).getElementsByClassName('title')[0].textContent = title;
                      document.getElementById('pic' + i).getElementsByClassName('intro')[0].textContent = intro;
                      var imgUrl = '../images/travel-images/medium/' + path;
                      var img =new Image();
                      img.src =imgUrl;
                      img.onclick = function(){
                          location.href = 'details.php?pic=' + path + '&value=no';
                      }
                      var aim = document.getElementById('pic' + i);
                      var firch = aim.firstElementChild;
                      aim.insertBefore(img,firch);
                      var aim1 = document.getElementsByClassName('button5')[i-1];
                      aim1.style.display = 'block';
                      document.getElementById('button' + i).name = path;
                      }
                      change();
                      </script>";
                    $i++;
                }
            }
            $pdo = null;
        }catch (PDOException $e) {
            die( $e->getMessage() );
        }
    }
    ?>
</head>
<body>
<header id="head">
    <a id="top"></a>
    <div class="logo"><img src="../images/others/logo.jpg"></div>
    <div class="lead">
        <nav>
            <ul class="top">
                <li><a href="../index.php">Home</a></li>
                <li><a href="browser.php">Browse</a></li>
                <li><a href="search.php" id="Search">Search</a></li>
                <li id="myaccount"><a id="myaccountin">My account<img src="../images/others/list.png" id="list"></a>
                    <ul class="second" id="second">
                        <li><a href="upload.php"><img src="../images/others/upload.png" id="upload">Upload</a></li>
                        <li><a href="mypicture.php?p=1"><img src="../images/others/mypicture.png" id="mypicture">MyPicture</a></li>
                        <li><a href="mycollection.php?p=1"><img src="../images/others/mycollection.png" id="mycollection">MyCollection</a></li>
                        <li><a href="login.php"><img src="../images/others/index.png" id="index">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="clear"></div>
<div id="container5">
    <h1 class="mchange">My Favourite</h1>
    <div class="inner" id="pic1"><div class="brief"><p class="title"></p><br><p class="intro"></p></div><input id="button1" type="button" value="Delete" class="button5" style="display:none" onclick="deletepic(1)"></div>
    <div class="inner" id="pic2"><div class="brief"><p class="title"></p><br><p class="intro"></p></div><input id="button2" type="button" value="Delete" class="button5" style="display:none" onclick="deletepic(2)"></div>
    <div class="inner" id="pic3"><div class="brief"><p class="title"></p><br><p class="intro"></p></div><input id="button3" type="button" value="Delete" class="button5" style="display:none" onclick="deletepic(3)"></div>
    <div class="inner" id="pic4"><div class="brief"><p class="title"></p><br><p class="intro"></p></div><input id="button4" type="button" value="Delete" class="button5" style="display:none" onclick="deletepic(4)"></div>
    <div id="numbers3"></div>
    <?php getImage();?>
</div>
<script>
    function deletepic(value) {
        var target = document.getElementById('button' + value).name;
        s = 'mycollection1.php?target=' + target;
        window.location = s;
    }
</script>
<footer id="foot">
    <div class="footer">
        <p>©19软工张璐.备案号：19302010023</p>
    </div>
</footer>
</body>
</html>