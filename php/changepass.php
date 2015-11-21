<?php
session_start();
include_once('conn.php');

//chequea la SESSION pone las variables
if (isset($_SESSION['user_id']) && isset($_SESSION['user'])) {
	$user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
	$user = mysqli_real_escape_string($conn, $_SESSION['user']);
}

//chequea las COOKIES pone las variables
elseif (isset($_COOKIE["user_id"]) && isset($_COOKIE["user"])) {
	$_SESSION['user_id'] = mysqli_real_escape_string($conn, $_COOKIE['user_id']);
    $_SESSION['user'] = mysqli_real_escape_string($conn, $_COOKIE['user']);
	
	$user_id = $_SESSION['user_id'];
	$user = $_SESSION['user'];
}

$pass1 = $_POST['newPass1'];
$pass2 = $_POST['newPass2'];
$secure_pass = password_hash($pass1, PASSWORD_DEFAULT);
		
//seccion de errores
if (empty($pass1) || empty($pass2)) {
	$error = "Debes llenar todos los campos";
	echo $error;
	exit;
}
elseif (strlen($pass1) < 8 || strlen($pass2) < 8) {
	$error = "Tu contrasena debe tener al menos 8 caracteres";
	echo $error;
	exit;
}
elseif ($pass1 != $pass2) {
	$error = "Las contrasenas no coinciden";
	echo $error;
	exit;
	}
//fin de los errores
	
else {
	$sql = "UPDATE users SET password='".$secure_pass."' WHERE user_id='".$user_id."' AND username='".$user."' LIMIT 1";
	$sql_update = mysqli_query($conn, $sql);
	if ($sql_update == true) {
		
		//elimina la session y las cookies utilizadas en este proceso
		//pone la session como una array vacia.
		$_SESSION = array();
		
		//expira las Cookies
		if (isset($_COOKIE["user_id"]) && isset($_COOKIE["user"])) {
			setcookie("user_id", '', strtotime( '-5 days' ), '/');
			setcookie("user", '', strtotime( '-5 days' ), '/');
		}
		//destruye las variables de la session
		session_destroy();
		
		echo "exito";
		}
	else {
		echo "algo salio mal";
	}
}

?>