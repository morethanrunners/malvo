<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="UTF-8">
        <title> Proyecto Running Log 1</title>
    <body>
        <?php
		//Pone la timezone predeterminada.
date_default_timezone_set ('UTC');

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
	
$sql = "SELECT `distancia` FROM `running` LIMIT 7";
  $query_select = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($query_select)){
	echo $row["distancia"]."<br>";
}

mysqli_close($conn);
				?>
		</body>
	</head>
</html>