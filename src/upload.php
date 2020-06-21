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
    <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <title>Upload</title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/samestyle.css" rel="stylesheet" type="text/css">
    <link href="css/upload.css" rel="stylesheet" type="text/css">
    <?php require_once "php/selfchange.php"; ?>
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
                        <li><a href="mypicture.php"><img src="../images/others/mypicture.png" id="mypicture">MyPicture</a></li>
                        <li><a href="mycollection.php"><img src="../images/others/mycollection.png" id="mycollection">MyCollection</a></li>
                        <li><a href="login.php"><img src="../images/others/index.png" id="index">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="clear"></div>
<div id="container6">
    <h1 class="mchange">Upload</h1>
    <section>
        <form method="post" id="selections" onsubmit="return check()">
            <div class="imgdisplay" id="imgdisplay"></div>
            <p id="path">No file selected...</p>
            <div class="fileLabel">
                <label for="file5" class="filelabel">Upload</label>
            </div>
            <input type="file" name="file5" id="file5" onchange="loadFile(this.files[0])" style="display: none"  multiple="multiple" />
            <script>
                $("#file5").change(function(){
                    var objUrl = getObjectURL(this.files[0]) ;
                    console.log("objUrl = "+objUrl);
                    if (objUrl) {
                        $("#imgupload").attr("src", objUrl);
                    }
                }) ;
                function getObjectURL(file) {
                    var url = null;
                    if (window.createObjectURL!=undefined) {
                        url = window.createObjectURL(file) ;
                    } else if (window.URL!=undefined) {
                        url = window.URL.createObjectURL(file) ;
                    } else if (window.webkitURL!=undefined) {
                        url = window.webkitURL.createObjectURL(file) ;
                    }
                    return url ;
                }
            </script>
            <script>
                function loadFile(file){
                    document.getElementById('path').innerHTML=file.name;
                }
            </script>
            <div id="picload"></div>
            <p class="firstline">图片标题：</p>
            <input type="text" name="pt" id="pt" required>
            <p>图片描述：</p>
            <textarea name="pd" id="pd" required></textarea>
            <div id="selections1">
            <p>主题内容：</p>
                <select id="content" name="content" required>
                    <option id="key1" value="Filter By Content" disabled selected hidden>Filter By Content</option>
                    <option value="Scenery">Scenery</option>
                    <option value="City">City</option>
                    <option value="People">People</option>
                    <option value="Animal">Animal</option>
                    <option value="Building">Building</option>
                    <option value="Wonder">Wonder</option>
                </select>
            <p>拍摄国家：</p>
            <select id="country" name="country" required>
                <option id="key2" value="Filter By Country" disabled selected hidden>Filter By Country</option>
            </select>
            <p>拍摄城市：</p>
            <select id="city" name="city" required>
                <option id="key3" value="Filter By City" disabled selected hidden>Filter By City</option>
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
            </div>
            <input type="submit" value="Submit" name="continue" id="fil2">
        </form>
    </section>
</div>
<?php if(isset($_GET['path'])){
    $value = $_GET['path'];
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
            $sql2 = "select * from geocountries where ISO='$country'";
            $sql3 = "select * from geocities where GeoNameID='$city'";
            $result2 = $pdo->query($sql2);
            $result3 = $pdo->query($sql3);
            $count1 = 0;
            while ($arr1 = $result2->fetch()){
                $countryname = $arr1['CountryName'];
            }
            while ($arr2 = $result3->fetch()){
                $cityname = $arr2['AsciiName'];
            }
            $countryname1 = addslashes($countryname);
            $cityname1 = addslashes($cityname);
            $intro1 =  addslashes($intro);
            $title1 = addslashes($title);
            echo "<script> function addDetails(){
                                   var path = '$value';
                                   var intro = '$intro1';
                                   var title = '$title1'; 
                                   var countryname = '$countryname1';
                                   var cityname = '$cityname1';
                                   var content = '$content';
                                   document.getElementById('selections').action = 'upload1.php?path=' + path;
                                   document.getElementById('key1').innerHTML = content;
                                   document.getElementById('key2').innerHTML= countryname;
                                   document.getElementById('key3').innerHTML = cityname;
                                   document.getElementById('pt').value = title;
                                   document.getElementById('pd').innerHTML = intro;  
                                   document.getElementById('path').innerHTML = path;
                                   document.getElementById('file5').disabled = true;
                                   var imgUrl = '../images/travel-images/medium/' + path;
                                   var img =new Image();
                                   img.src =imgUrl;
                                   img.id = 'imgupload';
                                   img.alt = '图片未上传';
                                   img.required = true;                                   
                                   var aim = document.getElementById('imgdisplay');
                                   aim.appendChild(img);
                               }
                               addDetails();
                      </script>";
        }
        $pdo = null;
    }catch (PDOException $e) {
        die( $e->getMessage() );
    }
}
else if(!isset($_GET['path'])){
    echo "<script> function addDetails1(){
                                   document.getElementById('selections').action = 'upload1.php';
                                   var img =new Image();
                                   img.id = 'imgupload';
                                   img.alt = '图片未上传';
                                   img.required = true;                                   
                                   var aim = document.getElementById('imgdisplay');
                                   aim.appendChild(img);
                               }
                               addDetails1();
                      </script>";
}?>
<footer id="foot">
    <div class="footer">
        <p>©19软工张璐.备案号：19302010023</p>
    </div>
</footer>
</body>
<script>
    function check(){
        var key1 = document.getElementById('key1').innerText;
        var key2 = document.getElementById('key2').innerText;
        var key3 = document.getElementById('key3').innerText;
        var path = document.getElementById('path').innerText;
        if(path==="No file selected..." || key1==="Filter By Content" || key2==="Filter By Country" || key3==="Filter By City"){
            alert("请完整填写表单");
            return false;
        }
        return true;
    }
</script>
</html>
