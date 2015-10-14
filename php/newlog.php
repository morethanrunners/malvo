<?php
include_once("conn.php");

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
			exit;
		}
	}
	else {
		echo "fecha en formato incorrecto";
		exit;
	} 
}
else{
	echo "fecha es obligatorio";
	exit;
}
	

    
    //codigo para insertar las variables a la base de datos. el campo de 'id' siempre se pone NULL porque esta en A_I. la fecha se cambia del formato de input al formato de mysql. si el formulario los permite los valores vacios se agregan como NULL.
$input = "INSERT INTO runlog (run_id, run_date, distance, time, pace, bpm, run_type, log_date)
VALUES (NULL, STR_TO_DATE('$fecha', '%m/%d/%Y'), $distancia, $tiempo, $ritmo, $ppm, $entr, now());";

if(mysqli_query($conn, $input)){
	echo "<br>registro con exito";
	exit;
}

else {
	echo "<br>registro fallo";
	exit;
}


?>