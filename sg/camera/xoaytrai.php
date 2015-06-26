    <?php
  
    require 'dbconnect.php';

//$connect =mysql_pconnect('localhost','root','')or die("ko ket noi dc");//ket noi sql
//$connect =mysql_select_db('ws')or die("ko co cai nay");
mysql_query("SETNAME 'UTF8'");
$sql=mysql_query("SELECT * FROM socket where id='1' ");
while($kq=mysql_fetch_array($sql))
{
    $a=$kq['ip'];
    $b=$kq['port'];
}

    $host=$a;
    $port=$b;
    $timeout=30;
    $sk=fsockopen($host,$port,$errnum,$errstr,$timeout) ;
    if (!is_resource($sk)) {
    exit("connection fail: ".$errnum." ".$errstr) ;
    }// else {
    fputs($sk, "trai") ;
    //$dati="" ;
    //while (!feof($sk)) {
    //$dati.= fgets ($sk, 1024);
    //}
    //}
    fclose($sk);
    //echo($dati) ;
    ?>