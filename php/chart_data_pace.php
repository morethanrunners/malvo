<?php

//Este archivo es solo para la data de tiempo para la grafica

include_once("check_login_status.php");
	
$sql = "SELECT ROUND(pace/60, 0) FROM runlog WHERE user_id='".$log_id."'ORDER BY run_date DESC LIMIT 7;";
  $query_select = mysqli_query($conn, $sql);

  $query_select = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($query_select, MYSQL_NUM)) {
	$array[] = $row;
}
$json_array = json_encode($array, JSON_HEX_TAG);
echo $json_array;
?>