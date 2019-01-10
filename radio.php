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
  $UCID = $_SESSION ['UCID'] ;
  
  $s = "select * from AA where UCID= '$UCID'"; 
  echo '<form action = "abc.php">';
    ($t = mysqli_query ($db ,$s));
  if (!$t){die ( mysqli_error ($db)); exit();}
  while ($r = mysqli_fetch_array ($t, MYSQLI_ASSOC)){
  $account= $r["account"];
  $current = $r["current"]; 
  echo '<input type = "radio" name = "account" value = "'.$account.'">'.$UCID.' '.$account.'<b> $'.$current.'</b><br><br>';
  }

?>
