<?php if (!get_magic_quotes_gpc()) {
    $_POST['fbt'] = addslashes($_POST['fbt']);
}
if (!get_magic_quotes_gpc()) {
    $_POST['fbd'] = addslashes($_POST['fbd']);
}
if($_POST['fbt']) {
    $text = $_POST['fbt'];
    $text1 = addslashes($text);
    echo "<script> function aim(){
                        var text = '$text1';
                        var s = 'search.php?title=' + text + '&p=1';
                        window.location.href = s;
                     } 
                     aim();
            </script>";
}
else if($_POST['fbd']){
    $text = $_POST['fbd'];
    $text1 = addslashes($text);
    echo "<script> function aim(){
                        var text = '$text1';
                        var s = 'search.php?intro=' + text + '&p=1';
                        window.location.href = s;
                     } 
                     aim();
            </script>";
}
else{
    echo "<script> function aim(){
                        alert('请输入搜索内容!');
                        window.location.href = 'search.php';
                     } 
                     aim();
            </script>";
}
