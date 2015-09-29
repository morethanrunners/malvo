<?php
date_default_timezone_set('UTC');

$server = "localhost";
$root = "root";
$password = "goldensun2591";
$database = "Runlog";
$conn = mysqli_connect($server, $root, $password, $database);

$sql = "SELECT * FROM `test`";
$select = mysqli_query($conn, $sql);
$num_row = mysqli_num_rows($select);
if($num_row > 0) {
	while ($row = mysqli_fetch_assoc($select)) {
		$fecha = $row['fecha'];
		$distancia = $row['distancia'];
		$tiempo = $row['tiempo'];
		$ritmo = $row['ritmo'];
		echo "las distancias son: ".$distancia."<br>";
	}
}
?>