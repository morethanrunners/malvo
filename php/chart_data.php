<?php
include_once("check_login_status.php");
	
$sql = "SELECT ROUND(distance/1000, 1) FROM runlog WHERE user_id='".$log_id."'ORDER BY run_date DESC LIMIT 7;";
  $query_select = mysqli_query($conn, $sql);

  $query_select = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($query_select, MYSQL_NUM)) {
	$array[] = $row;
}
$json_array = json_encode($array, JSON_HEX_TAG);
echo $json_array;

/*while ($row = mysqli_fetch_assoc($query_select)){
	echo $row["distancia"]."<br>";
}*/
