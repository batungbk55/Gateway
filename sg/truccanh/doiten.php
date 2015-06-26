<?php
require '../dbconnect.php';
$date = time();
$mdir='video'; //thu muc chua tap tin can doi ten
$r1='thanghien'; //tu can doi trong ten file
$r2=gmdate("d-m-Y-H-i-s", time()+7*3600);
$r3=gmdate('d-m-Y');
$r4=gmdate('H-i-s',time()+7*3600);
 //ten dc doi thanh
function mass_rename($dir,$r1,$r2) {
	$opdir=opendir($dir);
	while ($a=readdir($opdir)) {
		if ($a=='.' or $a=='..') continue;
		if (is_file($dir.'/'.$a)) {
			$b=str_replace($r1,$r2,$a);
			rename($dir.'/'.$a,$dir.'/'.$b); 
		}
		else {
			mass_rename($dir.'/'.$a,$r1,$r2); 
		} 
	}
	closedir($opdir);
	return $dir; 
}
mass_rename($mdir,$r1,$r2);
mysql_query("INSERT INTO video VALUES('{$r4}','{$r3}')");
?>
<script type="text/javascript">
	location.href="index.php"
</script>