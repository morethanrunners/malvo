<?php
session_start();
include_once("php/check_login_status.php");

//si el usuario esta logiado lo saca de aqui
if($user_ok == true){
	header("location: userlog.php?user=".$_SESSION["user"]);
    exit();
}

//usa el get que se envia desde el correo en la direccion
$emai_user_id = $_GET['user_id'];

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

//seccion de errores
if (empty($emai_user_id)) {
	$error = "no se envio nada";
	echo $error;
	exit;
}
elseif ($emai_user_id != $user_id) {
	echo "algo salio mal";
	exit;
}
//fin de la seccion de errores

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$pass1 = $_POST['newPass'];
	$pass2 = $_POST['newPass2'];
	$secure_pass = password_hash($pass1, PASSWORD_DEFAULT);
		
	//seccion de errores
	if (strlen($pass1) < 8 || strlen($pass2) < 8) {
		$error = "Tu contrasena debe tener al menos 8 caracteres";
	}
	elseif ($pass1 != $pass2) {
		$error = "Las contrasenas no coinciden";
	}
	//fin de los errores
	
	else {
		$sql = "UPDATE users SET password='".$secure_pass."' WHERE user_id='".$user_id."' AND username='".$user."' LIMIT 1";
		$sql_update = mysqli_query($conn, $sql);
		if ($sql_update == true) {
			$exito = "Clave actualizada con exito, ingresa AQUI";
			
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
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>RunLg Forgot Password</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom CSS-->
		<link href="assets/css/style.css" rel="stylesheet">
	</head>

  <body>

    <div class="container">
			<row>
				<div class="col-12 text-center header">
					<h2>RunLg<br><small>Empieza a llevar rigistro de tus entrenamientos</small></h2>
				</div>
			</row>
			<row>
				<div class="col-md-3"></div>
				<div class="col-md-6 text-center colorfull">
					<h3>Recuperar contrasena</h3>
					<p>Para modificar tu contrasena ingresa tu nueva contrasena en el formulario</p>
					<form id="changePassForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
						<div class="form-group">
							<label for="newPass" class="sr-only">Contrasena</label>
							<input type="password" id="newPass1" name="newPass1" class="form-control" placeholder="Nueva contrasena" required>
						</div>
						<div class="form-group">
							<label for="newPass2" class="sr-only">Confirma tu contrasena</label>
							<input type="password" id="newPass2" name="newPass2" class="form-control" placeholder="Confirma tu contrasena" required>
						</div>
						<div class="form-group">
						<input type="submit" value="Sign Up" Class="btn btn-default">
						</div>
					</form>
				</div>
				<div class="col-md-3"></div>
			</row>
      

    </div> <!-- /container -->
		<script src="js/functions.js"></script>
  </body>
</html>