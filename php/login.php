<?php
include_once("conn.php");

//pone las variables que vienen del imput usando AJAX
$user = mysqli_real_escape_string($conn, $_POST['user']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if ($user == "" || $password == "") {
	echo "Debes colocar todos los datos.";
	exit;
}
//sql para selecionar el usuario correspondiente al ingresado
$sql = "SELECT * FROM users WHERE username='".$user."'";
$sql_select = mysqli_query($conn, $sql);

//cuenta el numero de rows utilizando el usuario ingresado
$sql_rows = mysqli_num_rows($sql_select);

if ($sql_rows == 1){
	while ($row = mysqli_fetch_assoc($sql_select)){
		$secure_pass = $row['password'];
	}
	
	//verifica que la contrasena ingresada por el usuario concuerde con la contrasena ingresada
	if (password_verify($password, $secure_pass)) {
	$sql = "SELECT * FROM users WHERE username='".$user."' LIMIT 1";

	$select_query = mysqli_query($conn, $sql);
	$num_rows = mysqli_num_rows($select_query);
		if ($num_rows == 1){
			
			//verifica que el usuario este activado
			$sql = "SELECT * FROM users WHERE username='".$user."' AND password='".$secure_pass."' AND activated='1' LIMIT 1";
			$query = mysqli_query($conn, $sql);
			$numrows = mysqli_num_rows($query);
			
			//si el usuario no esta activado
			if ($numrows == 0) {
				echo "Debes activar tu cuenta antes de poder ingresar.";
			}
			//si el usuario esta activado
			else {
				$sql = "SELECT user_id, username, password FROM users WHERE username='".$user."' AND activated='1' LIMIT 1;";
				$sql_query = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($sql_query);
				$db_user_id = $row['user_id'];
				$db_username = $row['username'];
				$db_password = $row['password'];
				
				//set SESSION
				$_SESSION['user_id'] = $db_user_id;
				$_SESSION['user'] = $db_username;
				$_SESSION['password'] = $db_password;
				
				//set COOKIES
				setcookie("user_id", $db_user_id, strtotime( '+30 days' ), "/", "", "", TRUE);
				setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
				setcookie("password", $db_password, strtotime( '+30 days' ), "/", "", "", TRUE);
				echo $db_username;

				
			}
		}
		else {
			echo "algo salio mal";	
		}
	}
	else {
		echo "la contrasena es incorrecta";
	}
}
else {
	echo "Parece que ese usuario no existe";
}
?>