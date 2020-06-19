<!doctype html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <title>Browser</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/samestyle.css" rel="stylesheet" type="text/css">
    <link href="css/browser.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <?php require_once "php/selfchange.php"; ?>
    <?php
    function addp($number){
        if($number == 0){
            echo "<script>function addpages(){
                           var addpage = document.getElementById('numbers');
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
                           var addpage = document.getElementById('numbers');
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
                           var addpage = document.getElementById('numbers');
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
    <?php function add()
    {
        try {
            $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;', 'fate1930', 'my=22310=wa');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select CountryName from geocountries";
            $result = $pdo->query($sql);
            while ($key = $result->fetch()) {
                $countries = $key[0];
                echo "<script> 
                              function addc(){
                                  var countries = '$countries';
                                  var tem = document.createElement('option');
                                  tem.text = countries;
                                  document.getElementById('country').add(tem);
                              }
                              addc();
                          </script>";
            }
            $pdo = null;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }?>
    <?php function getImage($value1,$value2,$value3){
        $i = 1;
        $sql = '';
        try {
            $pdo = new PDO('mysql:dbname=users;charset=utf8mb4;','fate1930','my=22310=wa');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($value1!='0' && $value2!='0' && $value3!='0'){
                $pro = "select GeoNameID from geocities where AsciiName='$value2'";
                $pro1 = $pdo->query($pro);
                $pro2 = $pro1->fetch();
                $cityId = $pro2[0];
                $prepa = $_GET['p'];
                $prepa1 = intval(16*(intval($prepa)-1));
                $sql = "select * from travelimage where CityCode='$cityId' and Content='Scenery' limit $prepa1,16";
                $count = "select count(*) as 'count' from travelimage where CityCode='$cityId' and Content='Scenery'";
                $result = $pdo->query($count);
                $count1 = 0;
                while ($arr = $result->fetch()) {
                    $count1 = $arr['count'];
                }
                $pagesize = 16;
                $pages = ceil($count1/$pagesize);
                addp($pages);
            }
            else if ($value1 === 'yes'){
                $prepa = $_GET['p'];
                $prepa1 = intval(16*(intval($prepa)-1));
                $sql = "select * from travelimage where Title LIKE '%$value3%' limit $prepa1,16";
                $count = "select count(*) as 'count' from travelimage where Title LIKE '%$value3%'";
                $result = $pdo->query($count);
                $count1 = 0;
                while ($arr = $result->fetch()) {
                    $count1 = $arr['count'];
                }
                $pagesize = 16;
                $pages = ceil($count1/$pagesize);
                addp($pages);
            }
            else if ($value3!='0'){
                $prepa = $_GET['p'];
                $prepa1 = intval(16*(intval($prepa)-1));
                $sql = "select * from travelimage where Content='$value3' limit $prepa1,16";
                $count = "select count(*) as 'count' from travelimage where Content='$value3'";
                $result = $pdo->query($count);
                $count1 = 0;
                while ($arr = $result->fetch()) {
                    $count1 = $arr['count'];
                }
                $pagesize = 16;
                $pages = ceil($count1/$pagesize);
                addp($pages);
            }
            else if ($value1!='0'){
                $pro = "select ISO from geocountries where CountryName='$value1'";
                $pro1 = $pdo->query($pro);
                $pro2 = $pro1->fetch();
                $countryId = $pro2[0];
                $prepa = $_GET['p'];
                $prepa1 = intval(16*(intval($prepa)-1));
                $sql = "select * from travelimage where CountryCodeISO='$countryId' and Content='Scenery' limit $prepa1,16";
                $count = "select count(*) as 'count' from travelimage where CountryCodeISO='$countryId' and Content='Scenery'";
                $result = $pdo->query($count);
                $count1 = 0;
                while ($arr = $result->fetch()) {
                    $count1 = $arr['count'];
                }
                $pagesize = 16;
                $pages = ceil($count1/$pagesize);
                addp($pages);
            }
            else if ($value2!='0'){
                $pro = "select GeoNameID from geocities where AsciiName='$value2'";
                $pro1 = $pdo->query($pro);
                $pro2 = $pro1->fetch();
                $cityId = $pro2[0];
                $prepa = $_GET['p'];
                $prepa1 = intval(16*(intval($prepa)-1));
                $sql = "select * from travelimage where CityCode='$cityId' and Content='Scenery' limit $prepa1,16";
                $count = "select count(*) as 'count' from travelimage where CityCode='$cityId' and Content='Scenery'";
                $result = $pdo->query($count);
                $count1 = 0;
                while ($arr = $result->fetch()) {
                    $count1 = $arr['count'];
                }
                $pagesize = 16;
                $pages = ceil($count1/$pagesize);
                addp($pages);
            }
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
                $path = $row['PATH'];
                echo "<script> function change(){
                      var path = '$path';
                      var i = '$i';
                      var imgUrl = '../images/travel-images/medium/' + path;
                      var img =new Image();
                      img.src =imgUrl;
                      img.onclick = function(){
                          location.href = 'details.php?pic=' + path + '&value=no';
                      }
                      var aim = document.getElementById('pict' + i);
                      aim.appendChild(img);
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
                <li><a href="browser.php" id="browser">Browse</a></li>
                <li><a href="search.php">Search</a></li>
                <li id="myaccount"><a id="myaccountin">My account<img src="../images/others/list.png" id="list"></a>
                    <ul class="second" id="second" >
                        <li><a href="upload.php"><img src="../images/others/upload.png" id="upload">Upload</a></li>
                        <li><a href="mypicture.php?p=1"><img src="../images/others/mypicture.png" id="mypicture">MyPicture</a></li>
                        <li><a href="mycollection.php?p=1"><img src="../images/others/mycollection.png" id="mycollection">MyCollection</a></li>
                        <li><a href="php/logout.php"><img src="../images/others/index.png" id="index">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="clear"></div>
<div id="body">
    <aside>
        <div class="block">
            <h1>Search By Title</h1>
            <form action="browser2.php" method="post" id="searching">
                <input type="text" name="file0" id="file0">
                <div id="search" onclick="document.getElementById('searching').submit();"><img src="../images/others/search.png"></div>
            </form>
        </div>
        <div class="block">
            <h1>Hot Content</h1>
            <ul>
                <li><a href="javascript:void(0)" onclick="getUrl(1,this.innerText)">Scenery</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(1,this.innerText)">City</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(1,this.innerText)">People</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(1,this.innerText)">Animal</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(1,this.innerText)">Building</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(1,this.innerText)">Wonder</a></li>
            </ul>
        </div>
        <div class="block">
            <h1>Hot Country</h1>
            <ul>
                <li><a href="javascript:void(0)" onclick="getUrl(2,this.innerText)">Canada</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(2,this.innerText)">Italy</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(2,this.innerText)">Germany</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(2,this.innerText)">United Kingdom</a></li>
            </ul>
        </div>
        <div class="block">
            <h1>Hot City</h1>
            <ul>
                <li><a href="javascript:void(0)" onclick="getUrl(3,this.innerText)">Venezia</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(3,this.innerText)">Firenze</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(3,this.innerText)">Calgary</a></li>
                <li><a href="javascript:void(0)" onclick="getUrl(3,this.innerText)">London</a></li>
            </ul>
        </div>
    </aside>
    <div id="select0">
        <h1 id="hchange">Filter</h1>
        <div id="selections">
            <select id="content">
                <option value="Filter By Content" disabled selected hidden>Filter By Content</option>
                <option value="Scenery">Scenery</option>
                <option value="City">City</option>
                <option value="People">People</option>
                <option value="Animal">Animal</option>
                <option value="Building">Building</option>
                <option value="Wonder">Wonder</option>
            </select>
            <select id="country">
                <option value="Filter By Country" disabled selected hidden>Filter By Country</option>
            </select>
            <select id="city">
                <option value="Filter By City" disabled selected hidden>Filter By City</option>
            </select>
            <?php add();?>
            <script>
                $(function(){
                    var url = 'browser1.php';
                    $("#country").change(function(){
                        var country = document.getElementById('country').value;
                        $.ajax({
                            type:'post',
                            url:url,
                            data:{key:country},
                            dataType:'json',
                            success:function(data){
                                var status = data.status;
                                var country = data.data;
                                if(status == 200){
                                    var option = '';
                                    for(var i=0;i<country.length;i++){
                                        option +='<option>'+country[i]+'</option>';
                                    }
                                }else{
                                    var option = '<option>请选择城市</option>';
                                }
                                $("#city").html(option);
                            },
                        });
                    });
                });
            </script>
            <a href="javascript:void(0)" onclick="getUrl(0,0)"><input type="button" value="Filter" id="file1"></a>
            <script>
                function getUrl(key1,key2){
                    var a = window.location.href;
                    if(a.indexOf("?") !=-1){
                        a = a.split("?")[0];
                    }
                    if (key1 === 0) {
                        var s = a + '?country=' + document.getElementById('country').value + '&city=' + document.getElementById('city').value + '&content=' + document.getElementById('content').value + '&p=1';
                    }
                    if (key1 === 1){
                        var s = a + '?content=' + key2 + '&p=1';
                    }
                    if (key1 === 2){
                        var s = a + '?country=' + key2 + '&p=1';
                    }
                    if (key1 === 3){
                        var s = a + '?city=' + key2 + '&p=1';
                    }
                    window.location.href = s ;
                }
            </script>
        </div>
        <div class="container" id="container">
            <div id="pict1" class="inner"></div>
            <div id="pict2" class="inner"></div>
            <div id="pict3" class="inner"></div>
            <div id="pict4" class="inner"></div>
            <div id="pict5" class="inner"></div>
            <div id="pict6" class="inner"></div>
            <div id="pict7" class="inner"></div>
            <div id="pict8" class="inner"></div>
            <div id="pict9" class="inner"></div>
            <div id="pict10" class="inner"></div>
            <div id="pict11" class="inner"></div>
            <div id="pict12" class="inner"></div>
            <div id="pict13" class="inner"></div>
            <div id="pict14" class="inner"></div>
            <div id="pict15" class="inner"></div>
            <div id="pict16" class="inner"></div>
        </div>
        <div id="numbers"></div>
        <?php if(isset($_GET['country']) && isset($_GET['city']) && isset($_GET['content'])){
            if (($_GET['country']=='Filter By Country') || ($_GET['city']=='Filter By Country') || ($_GET['content']=='Filter By Content') || ($_GET['city']=='')){
                echo "<script>alert('您还未选择完毕')</script>";
            }
            else {
                getImage($_GET['country'], $_GET['city'], $_GET['content']);
            }
        }
        else if(isset($_GET['content']) && (!isset($_GET['city']))){
            getImage(0,0,$_GET['content']);
        }
        else if(isset($_GET['country']) && (!isset($_GET['city']))){
            getImage($_GET['country'],0,0);
        }
        else if(isset($_GET['city']) && (!isset($_GET['content']))){
            getImage(0,$_GET['city'],0);
        }
        else if(isset($_GET['text'])){
            getImage('yes',0,$_GET['text']);
        }
        ?>
        <?php if(!isset($_GET['p'])){
            addp(0);
        }?>
    </div>
</div>
<div class="clear"></div>
<footer id="foot">
    <div class="footer">
        <p>©19软工张璐.备案号：19302010023</p>
    </div>
</footer>
</body>
