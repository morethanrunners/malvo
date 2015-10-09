<!DOCTYPE html>
<html lang="es">
	<head>
        <title> Proyecto Running Log 1</title>
    <body>
        <?php
		//Pone la timezone predeterminada.

		//Conecta con el servidor
$server = "localhost";
$root = "root";
$password = "goldensun2591";
$database = "Runlog";
$conn = mysqli_connect($server, $root, $password, $database);
//check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
	
$sql = "SELECT * FROM `running` ORDER BY `fecha` DESC LIMIT 7";
  $query_select = mysqli_query($conn, $sql);

  $query_select = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($query_select, MYSQL_ASSOC)) {
	$array[] = $row;
}
$json_array = json_encode($array);
echo $json_array;

/*while ($row = mysqli_fetch_assoc($query_select)){
	echo $row["distancia"]."<br>";
}*/

mysqli_close($conn);
				?>
		</body>
	</head>
</html>