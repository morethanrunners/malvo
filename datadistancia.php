<?php

date_default_timezone_set ('UTC');

		//Conecta con el servidor
$server = "localhost";
$root = "root";
$password = "goldensun2591";
$database = "Runlog";

$conn = mysqli_connect($server, $root, $password, $database);

$select = "SELECT distancia FROM running ORDER BY fecha DESC, id DESC LIMIT 7";

$query_select = mysqli_query($conn, $select);

$num_rows = mysqli_num_rows($query_select);
if ($num_rows > 0){
	$data = array ();
	while ($row = mysqli_fetch_assoc($query_select)){
		$distancia = $row['distancia'] / 1000;
		$data[] = $distancia;
}
	}
echo json_encode($data);

?>