<!doctype html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="src/css/reset.css" rel="stylesheet" type="text/css">
    <link href="src/css/samestyle.css" rel="stylesheet" type="text/css">
    <link href="src/css/home.css" rel="stylesheet" type="text/css">
    <script>MaintainScrollPositionOnPostBack = true;</script>
    <?php require_once "src/php/selfchange.php"; ?>
    <?php function getImage($value){
        $i = 1;
        $sql = '';
            try {
                $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;','fate1930','my=22310=wa');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if($value == false){
                    $sql = "select * from travelimage order by rand() limit 6";
                    echo "<script>window.scrollBy(0,1080);</script>";
                }
                if($value == true) {
                    $j = 0;
                    $array = array();
                    $num = "select ImageID,count(*) as number from travelimagefavor group by ImageID order by number desc limit 6";
                    $nums = $pdo->query($num);
                    while ($key = $nums->fetch()){
                        $array[$j] = $key[0];
                        $j++;
                    }
                    $sql = "select * from travelimage where (ImageID = '$array[0]' or ImageID = '$array[1]' or ImageID = '$array[2]' or ImageID = '$array[3]' or ImageID = '$array[4]' or ImageID = '$array[5]')";
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
                      var imgUrl = 'images/travel-images/medium/' + path;
                      var img =new Image();
                      img.src =imgUrl;
                      img.onclick = function(){
                          location.href = 'src/details.php?pic=' + path + '&value=no';
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
<a href="javascript:void(0)" onclick="getUrl('refresh=1')"><input type="button" value=刷新 id="refresh"></a>
<script>
    function getUrl(target){
        var a = window.location.href;
        if(a.indexOf("?") !=-1){
            a = a.split("?")[0];
        }
        var s = a + '?' +target;
        window.location.href = s ;
    }
</script>
<div id="totop"><a href="#top" class="totop">回到顶部</a></div>
<header id="head">
    <a id="top"></a>
    <div class="logo"><img src="images/others/logo.jpg"></div>
    <div class="lead">
        <nav>
            <ul class="top">
                <li><a href="index.php" id="home">Home</a></li>
                <li><a href="src/browser.php">Browse</a></li>
                <li><a href="src/search.php">Search</a></li>
                <li id="myaccount"><a id = "myaccountin">My account<img src="images/others/list.png" id="list"></a>
                    <ul class="second" id="second">
                        <li><a href="src/upload.php"><img src="images/others/upload.png" id="upload">Upload</a></li>
                        <li><a href="src/mypicture.php?p=1"><img src="images/others/mypicture.png" id="mypicture">MyPicture</a></li>
                        <li><a href="src/mycollection.php?p=1"><img src="images/others/mycollection.png" id="mycollection">MyCollection</a></li>
                        <li><a href="src/php/logout.php"><img src="images/others/index.png" id="index">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="clear"></div>
<section id="main">
    <div id="toppicture"><img src="images/travel-images/medium/5855174537.jpg"></div>
    <div class="container">
        <div class="inner" id="pic1"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
        <div class="inner" id="pic2"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
        <div class="inner" id="pic3"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
        <div class="inner" id="pic4"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
        <div class="inner" id="pic5"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
        <div class="inner" id="pic6"><div class="brief"><p class="title"></p><br><p class="intro"></p></div></div>
    </div>
</section>
<?php if(isset($_GET['refresh'])){
    getImage(false);
}
if(!isset($_GET['refresh'])){
    getImage(true);
}
?>
<footer id="foot">
    <div class="footicon">
        <img src="images/others/camera.png">
        <img src="images/others/qq.png">
        <img src="images/others/wechat.png">
        <img src="images/others/github.png">
    </div>
    <div class="footer">
        <p>©19软工张璐.备案号：19302010023</p>
    </div>
</footer>
</body>
</html>