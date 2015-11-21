<?php
	$server = "localhost";
	$root = "root";
	$pass = "goldensun2591";
	$database = "runlg";
	$conn = mysqli_connect($server, $root, $pass, $database);

	// Check connection
	if (!$conn) {
			die("Connection failed: " . $conn->connect_error);
	}
//si llas variables se han enviado
if (isset($_GET['user_id']) && isset($_GET['username']) && isset($_GET['email']) && isset($_GET['secure_pass'])) {
	
	//pone las variables que se enviaron del correo usando GET
	$user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
	$username = mysqli_real_escape_string($conn, $_GET['username']);
	$email = mysqli_real_escape_string($conn, $_GET['email']);
	$secure_pass = mysqli_real_escape_string($conn, $_GET['secure_pass']);
	
	//si la variables estan vacias da un error
	if ($user_id == "" || $username == "" || $email == "" || $secure_pass == "") {
		echo "Algo salio mal con el proceso de activacion de tu cuenta. por favor intenta registrarte nuevamente.";
		exit;
	}
	
	// si todas tienen valores asignados seleciona en la BD la row con esos datos
	else {
		$sql = "SELECT * FROM users WHERE user_id='".$user_id."' AND username='".$username."' AND email='".$email."' AND password='".$secure_pass."' LIMIT 1";
		$query = mysqli_query($conn, $sql);
		$numrows = mysqli_num_rows($query);
		
		//si por error un usario que no se registro recive este correo
		if ($numrows == 0) {
			echo "Tus datos no parecen estar en el sitema.";
			exit;
		}
		
		//si el usuario esta en la base de dato procede con el proceso de activacion
		$sql = "UPDATE users SET activated='1' WHERE user_id='".$user_id."' LIMIT 1";
		$query = mysqli_query($conn, $sql);
		
		//chequear que la activacion funciono
		$sql = "SELECT * FROM users WHERE user_id='".$user_id."' AND activated='1' LIMIT 1";
		$query = mysqli_query($conn, $sql);
		$numrows = mysqli_num_rows($query);
		
		if ($numrows == 0) {
			echo "Algo salio mal con el proceso de activacion.";
			exit;
		}
		if ($numrows == 1) {
			echo "Activacion Exitosa pudes ingresar a tu cuenta.<br><br>";
			echo '<a href="http://localhost/~erwinhenriquezviejo/malvo/loginpage.php">Regresa a la pagina de LogIn</a>';
			exit;
		}
	}
}

//si por error no se envio alguna variable con el metodo GET
else {
	echo "No se enviaron los datos de tu activacion.";
	exit;
}
?>