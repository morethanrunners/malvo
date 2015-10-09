<?php
//Pone la timezone predeterminada.
date_default_timezone_set ('UTC');

		//Conecta con el servidor
$server = "localhost";
$root = "root";
$password = "goldensun2591";
$database = "Runlog";
$conn = mysqli_connect($server, $root, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

$fecha = $_POST['fecha'];

if(!empty($fecha)){
	
	$test_arr = explode('/', $fecha);
  if (checkdate($test_arr[0], $test_arr[1], $test_arr[2])) {
		
		$horas = $_POST['horas'];
		$minutos = $_POST['minutos'];
		$segundos = $_POST['segundos'];
		$tiempo = $segundos + ($minutos * 60) + ($horas * 60 * 60);
		
		if ($tiempo != 0) {
			$distancia = $_POST['distancia'];
			if (!empty($distancia)) {
				$distancia = $distancia * 1000;
				$ritmo = $tiempo * 1000 / $distancia;
			}
			else {
				$distancia = 'NULL';
				$ritmo = 'NULL';
			}
			
			$ppm = $_POST['ppm'];
			if(empty($ppm)) {
				$ppm = 'NULL';
			}
			$entr = $_POST['entrenamiento'];
			if(empty($entr)) {
				$entr = 'NULL';
			}
			else {
				$entr = "'$entr'";
			}

		}
		else {
			echo "tiempo es obligatorio";
		}
	}
	else {
		echo "fecha en formato incorrecto";
	} 
}
else{
	echo "fecha es obligatorio";
}
	

    
    //codigo para insertar las variables a la base de datos. el campo de 'id' siempre se pone NULL porque esta en A_I. la fecha se cambia del formato de input al formato de mysql. si el formulario los permite los valores vacios se agregan como NULL.
$input = "INSERT INTO runninglog (run_id, fecha, distancia, tiempo, ritmo, ppm, entr)
VALUES (NULL, STR_TO_DATE('$fecha', '%m/%d/%Y'), $distancia, $tiempo, $ritmo, $ppm, $entr)";

if(mysqli_query($conn, $input))
    echo "<br>registro con exito";

    else
        echo "<br>registro fallo";
  


?>