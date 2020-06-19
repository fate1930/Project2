<?php if (!get_magic_quotes_gpc()) {
          $_POST['file0'] = addslashes($_POST['file0']);
      }
      $text = $_POST['file0'];
      $text1 = addslashes($text);
      echo "<script> function aim(){
                        var text = '$text1';
                        var s = 'browser.php?text=' + text + '&p=1';
                        window.location.href = s;
                     } 
                     aim();
            </script>";