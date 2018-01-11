<?php 
require_once("connection.php");
//Tidak Puas
$ids=isset($_POST['ids'])?$_POST['ids']:"";

$response['msg']='';
$response['sql']='';
$response['ids']=$ids;

$sqlExt="";
$arr= explode(",", $ids);
for($i=0;$i<count($arr);$i++){
    if($sqlExt !=""){
        $sqlExt.=" OR id='". $arr[$i] ."'";
    }else{
        $sqlExt ="id='". $arr[$i] ."'";
    }
}
$response['sql']="DELETE FROM polling WHERE ". $sqlExt;
if($mysqli->query($response['sql'])){
    $response['msg']="delete success";
}else{
    $response['msg']=$mysqli->error;
}
$mysqli->close();

echo json_encode($response);
?>