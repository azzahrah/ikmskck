<?php
require_once("connection.php");
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15;
$offset = ($page - 1) * $rows;
$result = array();
$result["total"] = 0;
$result["rows"] = array();

$rs = $mysqli->query("select count(*) as total from polling order by tdate DESC");
if ($rs) {
    $row = $rs->fetch_assoc();
    $result["total"] = $row['total'];
    $rs->free();
}
$rs = $mysqli->query("SELECT * from polling order by tdate DESC limit $offset,$rows");
if ($rs) {
    while ($row = $rs->fetch_assoc()) {
        array_push($result["rows"], $row);
    }
    $rs->free();
}
$mysqli->close();
echo json_encode($result);
?>