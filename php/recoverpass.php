<?php
include_once("conn.php");

$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
$user = mysqli_real_escape_string($conn, $_POST['user']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$email2 = mysqli_real_escape_string($conn, $_POST['email2']);

if (empty($firstname) || empty($lastname) || empty($user) || empty($email) || empty($email2)) {
	echo "Debes completar todos los datos";
}
else {
	if ($email != $email2) {
		echo "Las direcciones de correo no coinciden";
		exit;
	}
	else {
		$sql = "SELECT * FROM users WHERE username='".$user."' AND email='".$email."' AND firstname='".$firstname."' AND lastname='".$lastname."' LIMIT 1";
		$sql_query = mysqli_query($conn, $sql);
		$num_rows = mysqli_num_rows($sql_query);

		if ($num_rows != 1) {
			echo "Tus datos no se encuentran en el sistema. Por favor verifica e ingresalos nuevamente";

			//para gestionar errores elimar al estar live
			echo $sql;

			exit;
		}
		else {
			while($row = mysqli_fetch_assoc($sql_query)) {
				$user_id = $row['user_id'];
				$user = $row['username'];
				$email = $row['email'];
			}
			//set sessions
			$_SESSION['user_id'] = $user_id;
			$_SESSION['user'] = $user;

			//set COOKIES
				setcookie("user_id", $user_id, strtotime( '+30 days' ), "/", "", "", TRUE);
				setcookie("user", $user, strtotime( '+30 days' ), "/", "", "", TRUE);

			//envia el correo de recuperacion
			$to = "$email";
			$from = "erwinhenriquez91@gmail.com";
			$subject = "RunLg recuperacion de contrasena";
			$message = '<html>Hola '.$user.', ingresa en el siguiente link para poder cambiar tu contrasena <a href="http://localhost/~erwinhenriquezviejo/malvo/changepage.php?user_id='.$user_id.'">RECUPERAR CONTRASENA</a>';
			$headers = "From: $from\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			mail($to, $subject, $message, $headers);
			echo "exito";
		}
	}
}