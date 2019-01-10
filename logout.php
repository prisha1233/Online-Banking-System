<!DOCTYPE HTML>
<style>
  html {
  background: url("picture.jpg") no-repeat center center fixed;
  background-size: cover;
  height: 100%;
  overflow: hidden;
} 
}
</style>

<?php
session_set_cookie_params (0, "/~pps48/A2/", "web,njit.edu");

session_start(); 
echo "sidvalue is "; 
echo $sidvalue = session_id();
echo  $sidvalue; 
  
  $_SESSION = array();
  
    session_destroy();
    echo '<h1><center><b>Succefully logout</b></center></h1>';
    setcookie ("PHPSESSID", "", time()-3600, '~pps48/A2/', "",0,0); 
    header ("refresh:7;url= 'https://web.njit.edu/~pps48/A2/form.html'");
    exit();

?>

</html>