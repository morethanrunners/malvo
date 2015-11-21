<?php
include_once("check_login_status.php");

if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$sql = "DELETE FROM runlog WHERE run_id='".$id."'";
	if(mysqli_query($conn, $sql)) {
		echo "Se borro 1 registro";
		exit;
	}
	else {
		echo "No se borro nada, algo salio mal";
		exit;
	}
}
else {
	echo "Algo salio terriblemnete mal";
	exit;
}

?>