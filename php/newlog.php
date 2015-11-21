<?php
include_once("check_login_status.php");

$fecha = $_POST['fecha'];

if(!empty($fecha)){
	
	$test_arr = explode('/', $fecha);
  if (checkdate($test_arr[1], $test_arr[0], $test_arr[2])) {
		
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
			echo "<p class='text-danger text-center'>Debes colocar la duracion de tu entrenamiento.<p>";
			exit;
		}
	}
	else {
		echo "<p class='text-danger text-center'>Fecha en formato incorrecto.<p>";
		exit;
	} 
}
else{
	echo "<p class='text-danger text-center'>La fecha es obligatoria.<p>";
	exit;
}
	

    
    //codigo para insertar las variables a la base de datos. el campo de 'id' siempre se pone NULL porque esta en A_I. la fecha se cambia del formato de input al formato de mysql. si el formulario los permite los valores vacios se agregan como NULL.
$input = "INSERT INTO runlog (run_id, user_id, run_date, distance, time, pace, bpm, run_type, log_date)
VALUES (NULL, '".$log_id."', STR_TO_DATE('$fecha', '%d/%m/%Y'), $distancia, $tiempo, $ritmo, $ppm, $entr, now());";

if(mysqli_query($conn, $input)){
	echo "<br>Registro con exito";
	exit;
}

else {
	echo "<br>Registro fallo";
	echo $input;
	exit;
}


?>