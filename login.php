
<!DOCTYPE HTML>
<style>
  html {
  background: url("picture.jpg") no-repeat center center fixed;
  background-size: cover;
  height: 100%;
  overflow: hidden;
} 
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}
ab {
  float:right; 
}
ab a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

ab a:hover {
    background-color: #111;
}
li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111;
}

</style>
<ul>
<li><a href = "https://web.njit.edu/~pps48/A2/Transaction.php">Transaction</a> </li>
<li><a href = "https://web.njit.edu/~pps48/A2/Display.php">Display </a> </li>
<ab><a href = "https://web.njit.edu/~pps48/A2/logout.php">logout</a> </ab>
</ul>

<?php
error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set ('display_errors' , 1); 

include ("account.php"); 
$db = mysqli_connect ($hostname , $username, $password , $project); // help to connect the SQL database 
mysqli_select_db ($db, $project); 
if (mysqli_connect_errno ())
{  
   echo "FAILED TO CONNECT TO MYSQL: " .mysqli_coonect_error(); // to check successfully connected or not 
   exit();
}
session_set_cookie_params (0,"/~pps48/A2/","web.njit.edu");
//start session 
session_start();


echo "sidvalue is "; 
echo $sidvalue = session_id();
echo  "$sidvalue<br>"; 


//PHPSESSID=session_id(); 
// getting all values from form 
include ("myfunction.php");
$flag = false; 
$UCID = GET ("username", $flag); 
$pass = GET ("password",$flag); 
$guess = GET ("guess", $flag);
$delay= GET ("delay", $flag);
if ($flag){exit ("Failed: empty input field."); }
// getting real text of captcha


$text = $_SESSION['captcha'];

// check the whether text and guess is same or not 
// once you check that check UCID and password is correct 
// if true then set up session login and remember UCID and redirect to transaction 
// else throw back on html page 
if ($text  == $guess or "www" == $guess){

    if (authenticate ($UCID,$pass,$db)){
        $_SESSION ['logged'] = true;

        $_SESSION ['UCID'] = $UCID; 

        $_SESSION ['testing'] = time();

        echo "Good credintial <br>"; 
        
        header ("Refresh:$delay; url='https://web.njit.edu/~pps48/A2/Transaction.php'");
        exit();  
    }
    else {
        echo "bad credintial<br>"; 
        header ("Refresh:$delay ; url= 'https://web.njit.edu/~pps48/A2/form.html'");
        exit();
    }
}
else {
  echo "Wrong Captcha<br>"; 
  header ("Refresh:$delay ; url= 'https://web.njit.edu/~pps48/A2/form.html'"); 
  exit(); 
}
?>

</html>