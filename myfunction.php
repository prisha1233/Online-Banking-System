<?php
/* get function definition */
function GET($fieldname, &$flag){
  global $db;
  $variable = $_GET[$fieldname];
  $v = trim($variable);

  if ($v == "" ){
    $flag = true; 
    echo "<br> $fieldname is empty. <br>";
    return ;
  };
  echo "$fieldname is $v.<br>";
  return $v;
  
}
/* authentication function definion */

function authenticate ($UCID, $pass,$db){
global $db ; 
$s = "select * from AA where UCID = '$UCID'  ";
  echo "SQL is $s<br>";
  ($t = mysqli_query ($db ,$s));
  if (!$t){die ( mysqli_error ($db)); exit();}
  //$num = mysqli_num_rows($t);
  //echo "The number of rows retrieved for $UCID is $num<br>"; 
while ($r = mysqli_fetch_array ($t, MYSQLI_ASSOC)){
  $hash= $r["pass"];
  }
  echo "password is $pass <br> hash password of $UCID is $hash <br>"; 
  if (!password_verify ($pass,$hash)) {return false;}
  else{return true; }

}

/* Display function definition   */
function display ($UCID, $number,$output,$account, $db){ 
  $s = "select * from AA where UCID = '$UCID' and account= '$account' ";
  $a = "SQL select is: $s<br>";
  $output .= $a; 
  (($t = mysqli_query ($db , $s)));
  if (!$t){die ( mysqli_error ($db)); }
  $num = mysqli_num_rows($t);
  $word = numtowords($num);
  echo "There are $word rows retrived from DB table.<br>";
  $b = "<style> th {color: red;} </style><table border=2 width = auto>"; 
  $output .= $b; 
  echo "$b"; 
  $c = "<tr><style> td {color: red;}</style><th>Account</th><th>UCID</th><th>Pass</th><th>Name</th><th>Mail</th>";
  $d = "<th>Initial</th><th>Current</th><th>Recent</th><th>Plaintext</th></tr>";
  $output .= $c; 
  $output .= $d;
  echo "$c"; 
  echo "$d";
while ($r = mysqli_fetch_array ($t, MYSQLI_ASSOC)){
  $m = "<tr><style> tr:nth-child(even){background-color: orange ;} </style><style>td{color:blue;}</style>";
  $output .= $m; 
  echo "$m"; 
  $account = $r["account"]; 
  $UCID= $r["UCID"];
  $pass= $r["pass"];
  $name= $r["name"];
  $mail = $r["mail"];
  $initial= $r["initial"];
  $current= $r["current"];
  $recent= $r["recent"];
  $plaintext= $r["plaintext"];
  $n ="<td>$account</td><td>$UCID</td><td>$pass</td><td>$name</td><td>$mail</td><td>$initial</td>";
  $p = "<td>$current</td><td>$recent</td><td>$plaintext</td></tr>";
  echo "$n$p"; 
  $output .= $n; 
  $output .= $p ; 
}
$o = "</table>"; 
$output .= $o; 
echo "$o";  

  $s = "select * from TT where UCID = '$UCID' and account = '$account' order by date DESC limit $number ";
  $f = "SQL select is: $s<br>";
  $output .= $f ; 
  echo "$f "; 
  (($t = mysqli_query ($db , $s)));
  if (!$t){die ( mysqli_error ($db)); }
  $num = mysqli_num_rows($t);
  $word = numtowords($num);
  echo "There are $word rows retrived from DB table.<br>";
  $e =  "<table border=2 width = auto><tr><style> td {color: red;} </style><th>Account</th><th>UCID</th><th>Type</th><th>Amount</th><th>Recent</th><th>Mail</th></tr>";
   $output .= $e ; 
   echo "$e"; 
while ($r = mysqli_fetch_array ($t, MYSQLI_ASSOC)){
  $f = "<tr><style> tr:nth-child(even){background-color: #cccccc; }</style><style>td{color:blue;}</style>";
  echo "$f";
  $output .= $f; 
  $account = $r["account"];
  $UCID= $r["UCID"];
  $type= $r["type"];
  $amount= $r["amount"];
  $date = $r["date"];
  $mail= $r["mail"];
  $g =  "<td>$account</td><td>$UCID</td><td>$type</td><td>$amount</td><td>$date</td><td>$mail</td></tr>";
  echo "$g";
  $output .= $g ;  
}
$avc = "</table></html> ";
echo "$avc";
$output .=$avc; 
return $output; 
}

/* insert function definition */
function insert($UCID, $pass, $name, $mail, $initial, $output,$account, $db){
	$s = "insert into AA values ('$account','$UCID', '$pass', '$name', '$mail', '$initial', '$initial', NOW(), '$pass')";
  $a = "SQL insert statement is: $s<br>";
  $output = $output.$a;
  echo "$a";
  ($ab = mysqli_query ($db , $s));
  if (!$ab){
  die ($c = mysqli_error ($db)); 
  }
  $d = "SQL insert AA statment was transmitted for execution.<br>";
  $output = $output. $d;
  echo "$d"; 
  
  return $output; 
}

/* deposit function definition */
function deposit($UCID, $amount,$output,$mailchoice,$account,$db){
	$s  = "insert into TT values ('$account','$UCID',NOW(), 'D', '$amount','$mailchoice')";
	$a = "SQL insert statement is: $s<br>"; 
  $output .= $a;
  ($ab = mysqli_query ($db , $s));
  if (!$ab){
  die ( mysqli_error ($db)); 
  }
  $b = "SQL insert TT statment was transmitted for execution.<br>";
	$output .= $b;
	$t = "update AA SET current=current+$amount, recent=NOW()  where UCID = '$UCID' and account = '$account'";
  $c = "SQL update AA statement is: $t<br>";
  $output .= $c ; 
  ($abc = mysqli_query ($db , $t));
  if (!$abc){
  die ( mysqli_error ($db)); 
  }
  $d = "SQL statment was transmitted for execution.<br>";
  $output .= $d; 
  return $output; 
}	

/* converting num to word function definition */
FUNCTION numtowords($num){
  if ($num <= 0 ) {return "zero"; }
  $digits =array ("zero", "one","two","three","four","five","six","seven","eight","nine");
  return $digits[$num];
}
/* enough function definition */
function enough ($UCID, $amount,$account, $db){

  $t = "select * from AA where UCID= '$UCID' and account = '$account' and current >= '$amount'";
  echo "SQL enough statment is $t<br>";
  ($ab = mysqli_query ($db , $t));
  if (!$ab){
  die ( mysqli_error ($db)); 
  }
  $num = mysqli_num_rows($ab);
  if ($num == 0) {return false;}
  echo "SQL statmetn was transmitted for execution.<br>";
  return true; 
}

/* withdraw function definition */
function withdraw($UCID, $amount,$output,$mailchoice,$account, $db){
  global $db; 
	$s  = "insert into TT values ('$account','$UCID',NOW(), 'W', '$amount','$mailchoice')";
	$a = "SQL insert statement is: $s<br>"; 
   $output .= $a;
   echo "$a";
($t = mysqli_query( $db, $s ) ) or die( "<br>SQL error: failed " . mysqli_error($db) );

  $b = "SQL insert TT statment was transmitted for execution.<br>";
	$output .= $b; 
   echo "$b";
	$t = "update AA SET current=current-$amount, recent=NOW()  where UCID = '$UCID' and account = '$account'";
  $c = "SQL update AA statement is: $t<br>";
  $output .= $c; 
  echo "$c";
($t = mysqli_query( $db,  $t ) ) or die( "<br>SQL error: " . mysqli_error($db) );
  $d = "SQL statment was transmitted for execution.<br>";
  $output.=$d;
  echo "$d"; 
  return $output;
}
/* sending  mail function definition */ 
function email($UCID, $output,$subject, $db){
    $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
  $s = "select mail from AA where UCID = '$UCID'"; 
  ($ab = mysqli_query ($db , $s));
  if (!$ab){
  die ( mysqli_error ($db)); 
  }
  $row= mysqli_fetch_array($ab);
  $to = $row["mail"];
  echo "to  is  $to<br>";
  mail($to,$subject,$output,$headers);
  $output .= "Successfully email you message";
}
?>

