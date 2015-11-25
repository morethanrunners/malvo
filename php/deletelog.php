<?php
include_once("check_login_status.php");

if(isset($_POST['id'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$sql = "DELETE FROM runlog WHERE run_id='".$id."'";
	if(mysqli_query($conn, $sql)) {
		echo "<p class='text-center'>Se borro 1 registro</p>";
		exit;
	}
	else {
		echo "<p>No se borro nada, algo salio mal</p>";
		exit;
	}
}
else {
	echo "<p>Algo salio terriblemnete mal</p>";
	exit;
}

?>