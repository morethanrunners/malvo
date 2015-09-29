<?php
date_default_timezone_set ('UTC');

$server = "localhost";
$root = "root";
$password = "goldensun2591";
$database = "Runlog";

//conecta con la base de datos
$conn = mysqli_connect($server, $root, $password, $database);

//en error sale
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

$fecha = $_POST['fecha'];
if (!empty($fecha)) {
  $test_arr = explode('/', $fecha);
  
	if (checkdate($test_arr[0], $test_arr[1], $test_arr[2])){
		
		$distancia = $_POST['distancia'];
		if (!empty($distancia)) {
			$tiempo = $_POST['tiempo'];
			if (!empty($tiempo)) {
				$ritmo = $tiempo / $distancia;
			}
			else {
				$tiempo = 'NULL';
				$ritmo = 'NULL';
				echo "no colocaste ninguna duracion";
			}
		
		$insert = "INSERT INTO `test` (`id`, `fecha`, `distancia`, `tiempo`, `ritmo`) VALUES (NULL, STR_TO_DATE('$fecha', '%m/%d/%Y'), $distancia, $tiempo, $ritmo)";
  echo $insert;
		if(mysqli_query($conn, $insert)){
    	echo "registro con exito";
		}
		else {
      echo "registro fallo";
		}
	}
    else {
			echo "Distancia es obligatoria";
		}
	}
	else {
		echo "Fecha en formato incorrecto";
	}
}
else {
	echo "fecha es obligatoria";
}
?>