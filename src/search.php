<!doctype html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/samestyle.css" rel="stylesheet" type="text/css">
    <link href="css/search.css" rel="stylesheet" type="text/css">
    <?php require_once "php/selfchange.php"; ?>
    <?php
    function addp($number){
        if($number == 0){
            echo "<script>function addpages(){
                           var addpage = document.getElementById('numbers1');
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
                      }
                      addpages();
                  </script>";
        }
        else if($number >= 5){
            $prepage = $_GET['p'];
            echo "<script>function addpages(){
                           var prepage = parseInt('$prepage');
                           var number;
                           var addpage = document.getElementById('numbers1');
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
                           var addpage = document.getElementById('numbers1');
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
    <?php function getImage($value1,$value2){
        $i = 1;
        $sql = '';
        try {
            $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;','fate1930','my=22310=wa');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($value1 == 'yes'){
                $prepa = $_GET['p'];
                $prepa1 = intval(6*(intval($prepa)-1));
                $sql = "select * from travelimage where Title LIKE '%$value2%' limit $prepa1,6";
                $count = "select count(*) as 'count' from travelimage where Title LIKE '%$value2%'";
                $result = $pdo->query($count);
                $count1 = 0;
                while ($arr = $result->fetch()) {
                    $count1 = $arr['count'];
                }
                $pagesize = 6;
                $pages = ceil($count1/$pagesize);
                addp($pages);
            }
            else if ($value1 == 'no'){
                $prepa = $_GET['p'];
                $prepa1 = intval(6*(intval($prepa)-1));
                $sql = "select * from travelimage where Description LIKE '%$value2%' limit $prepa1,6";
                $count = "select count(*) as 'count' from travelimage where Description LIKE '%$value2%'";
                $result = $pdo->query($count);
                $count1 = 0;
                while ($arr = $result->fetch()) {
                    $count1 = $arr['count'];
                }
                $pagesize = 6;
                $pages = ceil($count1/$pagesize);
                addp($pages);
            }
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
                          location.href = 'details.php?pic=' + path;
                      }
                      var aim = document.getElementById('pic' + i);
                      var firch = aim.firstElementChild;
                      aim.insertBefore(img,firch);
                      }
                      change();
                      </script>";
                $i++;
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
                        <li><a href="../index.php"><img src="../images/others/index.png" id="index">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="clear"></div>
<div id="container2">
    <h1 class="mchange">Search</h1>
    <form action="search1.php" method="post" id="searching1">
    <input type="radio" value="fbt" name="filb">Filter By Title
    <input type="text" name="fbt" id="fbt" disabled="disabled">
    <input type="radio" value="fbd" name="filb">Filter By Description
    <textarea name="fbd" id="fbd" disabled="disabled"></textarea>
    <input type="submit" value="Filter" id="fil">
    </form>
</div>
<script>
    radio = document.getElementsByName("filb");
    radio[0].onclick=function(){
        document.getElementById('fbt').disabled = false;
        document.getElementById('fbd').disabled = true;
    };
    radio[1].onclick=function() {
        document.getElementById('fbd').disabled = false;
        document.getElementById('fbt').disabled = true;
    }
</script>
<div id="container3">
    <h1 class="mchange">Result</h1>
    <div class="inner" id="pic1"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
    <div class="inner" id="pic2"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
    <div class="inner" id="pic3"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
    <div class="inner" id="pic4"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
    <div class="inner" id="pic5"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
    <div class="inner" id="pic6"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
    <div id="numbers1">
    </div>
    <?php if(isset($_GET['title'])){
        getImage('yes',$_GET['title']);
    }
    else if(isset($_GET['intro'])){
        getImage('no',$_GET['intro']);
    }
    ?>
    <?php if(!isset($_GET['p'])){
        addp(0);
    }?>
</div>
<footer id="foot">
    <div class="footer">
        <p>©19软工张璐.备案号：19302010023</p>
    </div>
</footer>
</body>
</html>