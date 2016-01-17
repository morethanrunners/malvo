<?php
include_once("check_login_status.php");

$run_id = $_POST['runid'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$clima = $_POST['clima'];
$clasi = $_POST['clasi'];
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
if(empty($hora)) {
	$select = "SELECT run_time FROM runlog WHERE run_id='$run_id'";
	$query_select = mysqli_query($conn, $select);
	while ($row = mysqli_fetch_assoc($query_select)){
		$hora = $row['run_time'];
	}
}
if(empty($hora)){
	$hora = 'NULL';
}
if(empty($clima)) {
	$select = "SELECT clima FROM runlog WHERE run_id='$run_id'";
	$query_select = mysqli_query($conn, $select);
	while ($row = mysqli_fetch_assoc($query_select)){
		$clima = $row['clima'];
	}
}
if(empty($clima)){
	$clima = 'NULL';
}
if(empty($clasi)) {
	$select = "SELECT score FROM runlog WHERE run_id='$run_id'";
	$query_select = mysqli_query($conn, $select);
	while ($row = mysqli_fetch_assoc($query_select)){
		$clasi = $row['score'];
	}
}
if(empty($clasi)){
	$clasi = 'NULL';
}


$sql = "UPDATE runlog SET user_id='$log_id', run_date=STR_TO_DATE('$fecha', '%d/%m/%Y'), distance='$distancia', time='$tiempo', pace='$ritmo', bpm='$ppm', run_type=$entr, log_date=now(), run_time=$hora, clima=$clima, score=$clasi WHERE run_id='$run_id';";

if(mysqli_query($conn, $sql)){
	echo "<p class='text-center text-success'>Registro con exito</p>";
	exit;
}

else {
	echo "<p class='text-center texte-danger'>Registro fallo</p>";
	echo $sql;
	exit;
}