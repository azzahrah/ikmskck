<?php 
require_once("php_script/connection.php");
//Tidak Puas
$polling=isset($_POST['polling'])?intval($_POST['polling']):0;
$mysqli->query("INSERT INTO polling (`tdate`,`polling`) values(now(),'". $polling ."')");
$mysqli->close();
?>