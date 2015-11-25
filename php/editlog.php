<?php
include_once("check_login_status.php");

$run_id = $_POST['runid'];
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
$sql = "UPDATE runlog SET user_id='$log_id', run_date=STR_TO_DATE('$fecha', '%d/%m/%Y'), distance='$distancia', time='$tiempo', pace='$ritmo', bpm='$ppm', run_type=$entr, log_date=now() WHERE run_id='$run_id';";

if(mysqli_query($conn, $sql)){
	echo "<p class='text-center text-success'>Registro con exito</p>";
	exit;
}

else {
	echo "<p class='text-center texte-danger'>Registro fallo</p>";
	echo $sql;
	exit;
}