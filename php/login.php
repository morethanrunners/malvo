<?php
$server = "localhost";
$root = "root";
$pass = "goldensun2591";
$database = "test";
$conn = mysqli_connect($server, $root, $pass, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

//pone las variables que vienen del imput usando AJAX
$user = $_POST['user'];
$password = $_POST['password'];

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
				echo "ingreso con exito";
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
	echo "Parece que es usuario no existe";
}
?>