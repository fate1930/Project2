<?php if($_GET['value'] == 'true') {
    changefavor('true');
}else if($_GET['value'] == 'false'){
    changefavor('false');
}
error_reporting(5);
?>
<!doctype html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <title>Details</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/samestyle.css" rel="stylesheet" type="text/css">
    <link href="css/details.css" rel="stylesheet" type="text/css">
    <?php require_once "php/selfchange.php"; ?>
    <?php function getImage($value){
        try {
            $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;','fate1930','my=22310=wa');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select * from travelimage where PATH='$value'";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
                $title = $row['Title'];
                $intro = $row['Description'];
                $content = $row['Content'];
                $country = $row['CountryCodeISO'];
                $city = $row['CityCode'];
                $count = $row['ImageID'];
                $sql1 = "select count(*) as 'count' from travelimagefavor where ImageID='$count'";
                $sql2 = "select * from geocountries where ISO='$country'";
                $sql3 = "select * from geocities where GeoNameID='$city'";
                $result1 = $pdo->query($sql1);
                $result2 = $pdo->query($sql2);
                $result3 = $pdo->query($sql3);
                $count1 = 0;
                while ($arr = $result1->fetch()){
                     $count1 = $arr['count'];
                }
                while ($arr1 = $result2->fetch()){
                     $countryname = $arr1['CountryName'];
                }
                while ($arr2 = $result3->fetch()){
                     $cityname = $arr2['AsciiName'];
                }
                $countryname1 = addslashes($countryname);
                $cityname1 = addslashes($cityname);
                echo "<script> function addDetails(){
                                   var count1 = '$count1';
                                   var countryname = '$countryname1';
                                   var cityname = '$cityname1';
                                   document.getElementById('likeNumber').textContent = count1;
                                   document.getElementById('country').textContent = countryname;
                                   document.getElementById('city').textContent = cityname;
                               }
                               addDetails();
                      </script>";
                $intro1 =  addslashes($intro);
                $title1 = addslashes($title);
                echo "<script> function change(){
                      var title = '$title1';
                      var intro = '$intro1';
                      var content = '$content';
                      var value = '$value';
                      document.getElementById('titlein').textContent = title;
                      document.getElementById('intro').textContent = intro;
                      document.getElementById('content').textContent = content;
                      var imgUrl = '../images/travel-images/medium/' + value;
                      var img =new Image();
                      img.src =imgUrl;
                      img.onclick = function(){
                          location.href = 'details.php?pic=' + value;
                      }
                      var aim = document.getElementById('pic');
                      aim.appendChild(img);
                      }
                      change();
                      </script>";
            }
            $pdo = null;
        }catch (PDOException $e) {
            die( $e->getMessage() );
        }
    }
    ?>
    <?php function getfavor($picval){
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
            $sql = "select * from travelimage where PATH='$picval'";
            $result = $pdo->query($sql);
            while ($arr = $result->fetch()){
                $id = $arr['ImageID'];
            }
            $sqlr = "select * from travelimagefavor where ImageID='$id'";
            $resultr = $pdo->query($sqlr);
            $n = 0;
            while ($arrr = $resultr->fetch()){
                if($arrr['UID'] == $userid){
                    $n = 1;
                }
            }
            echo "<script> function favorsituation(){
                               var n = '$n';
                               if (n === '0'){
                                   document.getElementById('collect').value = '☆收藏';
                               }
                               else {
                                   document.getElementById('collect').value = '☆已收藏';
                               }
                           }
                           favorsituation();
                  </script>";
            $pdo = null;
        }catch (PDOException $e) {
            die( $e->getMessage() );
        }
    }
    ?>
    <?php function changefavor($bool){
        session_start();
        try {
            $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;','fate1930','my=22310=wa');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $username = $_SESSION['username'];
            $path = $_GET['pic'];
            $sql = "select * from traveluser where UserName='$username' or Email='$username'";
            $result = $pdo->query($sql);
            while ($arr = $result->fetch()){
                $id = $arr['UID'];
            }
            if ($bool == 'true'){
                $sql1 = "select * from travelimage where PATH='$path'";
                $result1 = $pdo->query($sql1);
                while ($arr1 = $result1->fetch()){
                    $picid = $arr1['ImageID'];
                }
                $query="INSERT INTO travelimagefavor (UID,ImageID) VALUES('$id','$picid')";
                $pdo->exec($query);
            }
            else if($bool == 'false'){
                $sql2 = "select * from travelimage where PATH='$path'";
                $result2 = $pdo->query($sql2);
                while ($arr2 = $result2->fetch()){
                    $picid1 = $arr2['ImageID'];
                }
                $query1 = "Delete from travelimagefavor where UID='$id' and ImageID='$picid1'";
                $pdo->exec($query1);
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
                <li><a href="browser.php" id="browser">Browse</a></li>
                <li><a href="search.php">Search</a></li>
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
<div id="container1">
    <h1 class="mchange">Details</h1>
    <div class="title"><p id="titlein"></p></div>
    <div id="introductions">
        <div id="pic">
        </div>
        <div class="like">
            <h1>Like Number</h1>
            <p id="likeNumber"></p>
        </div>
        <div class="imgdetails">
            <h1>Image Details</h1>
            <p>Content: <span id="content"></span></p>
            <p>Country: <span id="country"></span></p>
            <p>City: <span id="city"></span></p>
        </div>
        <div>
            <input type="button" name="collect" id="collect" class="collect" onclick="getUrl(document.getElementById('collect').value)">
        </div>
        <script>
            function getUrl(key){
                var a = window.location.href;
                if(a.indexOf("?")!=-1){
                    a = a.split("&")[0];
                }
                var s;
                if(key === '☆收藏') {
                    s = 'true';
                }
                else{
                    s = 'false';
                }
                window.location.href = a + '&value=' + s;
            }
        </script>
        <div class="details">
            <p id="intro"></p>
        </div>
    </div>
</div>
<?php if(isset($_GET['pic'])){
    getImage($_GET['pic']);
    getfavor($_GET['pic']);
}
?>
<footer id="foot">
    <div class="footer">
        <p>©19软工张璐.备案号：19302010023</p>
    </div>
</footer>
</body>
</html>