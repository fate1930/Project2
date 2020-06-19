<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>
                  window.onload = function(){
                  document.getElementById('myaccountin').textContent = 'Login';
                  document.getElementById('myaccountin').setAttribute('href','src/login.php');
                  document.getElementById('second').style.display = 'none';
                  }
              </script>";
}
