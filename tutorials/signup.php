<?php
//pone las variables para conectar a la base de datos
$server = "localhost";
$root = "root";
$pass = "goldensun2591";
$database = "test";
//conecta  a la base de datos
$conn = mysqli_connect($server, $root, $pass, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

//pone las variables para ser utilizadas
$username = mysqli_real_escape_string($conn, $_POST['user']);
$firstname = mysqli_real_escape_string($conn, ucfirst($_POST['firstname']));
$lastname = mysqli_real_escape_string($conn, ucfirst($_POST['lastname']));
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$secure_pass = password_hash($password, PASSWORD_DEFAULT);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$ip = getenv('REMOTE_ADDR');

//Seccion de mensajes de error
//si los campos estan vacios
if (empty($username) || empty($firstname) || empty($lastname) || empty($password) || empty($password_confirm) || empty($email)) {
	echo "Debes completar todos los datos.";
	exit;
}
//si el username tiene caracteres especiales
elseif (!ctype_alnum($username)) {
	echo "Username must be alphanumeric";
	exit;
	}
//valida la idreccion de correo
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$emailErr = "Invalid email format";
	echo $emailErr;
	exit;
}
//si la contrasena es menor a 8 caracteres
elseif (strlen($password) < 8){
	echo "tu contrasena debe tener almenos 8 caracteres por tu seguridad";
	exit;
	}
//si las contrasenas no son iguales
elseif ($password != $password_confirm) {
	echo "Las contrasenas no concuerdan";
	exit;
	}
//Fin del area de errores

//si no da ningun error
else {
	//selecciona de la base de datos las columnas con el 'username' y el 'email'
		$sql_user = "SELECT * FROM users WHERE username='".$username."'";
		$sql_email = "SELECT * FROM users WHERE email='".$email."'";

		$select_user = mysqli_query($conn, $sql_user);
		$select_email = mysqli_query($conn, $sql_email);
		$user_rows = mysqli_num_rows($select_user);
		$email_rows = mysqli_num_rows($select_email);
	//verifica que ni el nombre de usuario ni el correo existan
		if ($user_rows != 0){
			echo "usuario ya existe";
		}
		elseif ($email_rows != 0) {
			echo "ese email ya esta en uso"; 
		}
	//si el usuario y correo se pueden usar inserta las variables en la base de datos
		else {
			$sql = "INSERT INTO users (`user_id`, `username`, `password`, `email`, `firstname`, `lastname`, `ip`) VALUES (NULL, '".$username."', '".$secure_pass."', '".$email."', '".$firstname."', '".$lastname."', '".$ip."')";
			$sql_insert = mysqli_query($conn, $sql);
			
		//si el registro es exitoso se envia un mensaje al usuario con AJAX para que revise su correo. un correo de activacion es enviado al correo proporcionado por el usuario. de esa forma verificamos que el correo sea real.
			if ($sql_insert == true) {
				echo "Registro con exito";
				
				//guarda el id del usuario agregado en una variable local
				$user_id = mysqli_insert_id($conn);
				
				//codigo para enviar el correo de activacion cuando se agrego el usuario
				$to = "$email";
				$from = "erwinhenriquez91@gmail.com";
				$subject = "Malvo acount activation";
				$message = '<html>Hola '.$username.',  ingresa en el siguiente link para poder activar tu cuenta <a href="http://localhost/~erwinhenriquezviejo/malvo/tutorials/activation.php?user_id='.$user_id.'&username='.$username.'&email='.$email.'&secure_pass='.$secure_pass.'">ACTIVA TU CUENTA</a>';
				$headers = "From: $from\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
				mail($to, $subject, $message, $headers);
				exit;
				
			}
			else {
				echo "registro fallido";
				exit;
			}
		}
	}