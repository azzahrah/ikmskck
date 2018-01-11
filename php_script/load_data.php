<?php

require_once("connection.php");
//Tidak Puas
$ids = isset($_POST['ids']) ? $_POST['ids'] : "";
$response['total'] = 0;
$response['rows'] = array();
$response['msg'] = '';
$response['sql'] = "SELECT COUNT(*) as jumlah,polling from polling group by polling order by polling";
$result = $mysqli->query($response['sql']);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $response['rows'][] = $row;
        $response['total'] +=$row['jumlah'];
    }
    //fill data dummy
    if ($response['total'] <= 0) {
        $response['total']=3;
        $response['rows'][]=array("jumlah"=>0,"polling"=>"1");
        $response['rows'][]=array("jumlah"=>0,"polling"=>"2");
        $response['rows'][]=array("jumlah"=>0,"polling"=>"3");        
    }
} else {
    $response['msg'] = $mysqli->error;
}
$mysqli->close();
echo json_encode($response);
?>