
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

session_start(); 

if ( !isset ($_SESSION ['logged']) && time() - $_session ['testing']  > 600){

  echo "You have not logg in yet <br> "; 
  header ("refresh:5;url= 'https://web.njit.edu/~pps48/A2/form.html'");
  exit(); 
}
else {    

  $UCID = $_SESSION ['UCID'] ;
    
  $inactive  =  time() - $_SESSION['testing'];
  if ($inactive > 600 ){
    session_destroy();
    header ("refresh:5;url= 'https://web.njit.edu/~pps48/A2/form.html'");
    exit();
  }
  
  echo '<h1>This is '.$UCID.' transaction.php</h1><br>' ; 
 // echo "$db<br>";
  
 $_SESSION ['testing'] = time();
 
}
include ("myfunction.php");
$flag = false; 
$amount = GET ("amount", $flag); 
$type = GET ("type",$flag); 
$account = GET ("account", $flag);
$mailChoice = GET ("mailChoice",$flag);
if ($flag){exit ("Failed: empty input field."); }



echo "I would like to $type  \$$amount.00 in the $UCID.<br> "; 

$output = ""; 
if ($type == "D"){
  $output = deposit($UCID, $amount,$output,$mailChoice,$account, $db); 
  echo "Successfully deposited.<br>";
}
else {
  if (!enough ($UCID, $amount,$account, $db)) 
  {echo "not enough money in your account $account"; }
  else {
  $output = withdraw($UCID, $amount,$output,$mailChoice,$account, $db);
  echo "Successfully Withdraw<br>"; 
  }
}

if ($mailChoice == 'Y'){
  $subject = "Insertion Information";
 // echo "$output";
  $output = email($UCID, $output,$subject, $db);
  } 

Echo "Thank you for visiting"; 

?>
</html>