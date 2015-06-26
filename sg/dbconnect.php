<?php
//$connect =mysql_pconnect('localhost','root','root');
// Check connection

/*if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
} 
//else echo "Connected successfully";
$connect =mysql_select_db('b7_13329629_ws');
*/

@$connect =mysql_pconnect('localhost','root','root')or die("Cannot connect server");
@$connect =mysql_select_db('b7_13329629_ws')or die("Cannot connect database");
//@$connect =mysql_pconnect('sql102.freevnn.com','freev_13747651','lab411')or die("Cannot connect server");
//@$connect =mysql_select_db('freev_13747651_sg')or die("Cannot connect database");

?>
