<?php
date_default_timezone_set ('UTC');
$server = "localhost";
$root = "root";
$password = "goldensun2591";
$database = "Runlog";
$conn = mysqli_connect($server, $root, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 

//funcion para asignar valor NULL a un input vacio
function empty_to_null ($input) {
	if (empty($_POST[$input])) {
		$_POST[$input] = 'NULL';
	}
	/*
	 *
	 *con esta parte de la fucnion pretendo estanarizar el uso de la funcion para que cequee todos los campos 
	 *la idea es que verifique si el campo esta vacio, de estarlo asigna al $_POST un NULL. si no lo esta genera una variable para ser agregada en el query de mysql
	*
	*
	*el efecto deseado se esta logrando con el siguiente codigo:
	
					empty_to_null("distancia_train");
					if($_POST["distancia_train"] = "NULL") {
						$d_t = $_POST["distancia_train"];
					}
					else {
						$d_t = '$_POST["distancia_tarin"]';
					}
	*
	*
	*
	*trate de agregar a la function:
				if ($_POST[$input] = 'NULL') {
						global $$input;
						$$input = $_POST["$input"];
				}
				else {
						$$input = '$_POST["$input"]';
				}

	*Pero eso ocasiona que todo los inputs se asignen como NULL.
	*
	*/
}

//se ejeuta solo si el metodo del servidor es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["training_program"])) {
		
	//si la fecha NO esta vacia verifica el formato
	if(!empty($_POST["fecha_train"])) {
		$testdate_train = $_POST["fecha_train"];
		$test_arr_train = explode('/', $testdate_train);
		
		//si la fecha tiene formato correcto
		if (checkdate($test_arr_train[0], $test_arr_train[1], $test_arr_train[2])) {
			
			//si tipo_train NO esta vacio
			if(!empty($_POST["tipo_train"])) {
				
				//asigna los valores a las variables
				$fecha_train = $_POST["fecha_train"];
				$f_t = $fecha_train;
				$tipo_train = $_POST["tipo_train"];
				$t_t = "'$tipo_train'";
				
				// metodo 1 para inserta la variable cuando es posible un valor NULL
				empty_to_null("distancia_train");
					if($_POST["distancia_train"] = "NULL") {
						$d_t = $_POST["distancia_train"];
					}
					else {
						$d_t = '$_POST["distancia_tarin"]';
					}
				
				//metodo 2 para insertar un variable cuando es posible un valor NULL
				empty_to_null("coment_train");
				$coment_train = $_POST["coment_train"];
					if ($coment_train = "NULL") {
						$c_t = $coment_train;
					}
					else {
						$c_t = "'$coment_train'";
					}
			}
			
			//si el tipo de entrenmaineto esta vacio
			else {
				echo "debes colocar un tipo de entrenamiento";
			}
		}
		
		//si la fecha tiene formato incorrecto
		else {
			echo "fecha en formato incorrecto";
		}
				}
	
	//si la fecha esta vacia
	else {
		echo "Fcha es obligatorio";
	}
	
	//codigo para insertar las variables a la base de datos. el campo de 'id' siempre se pone NULL porque esta en A_I. la fecha se cambia del formato de input al formato de mysql. si el formulario los permite los valores vacios se agregan como NULL.
$input_train = "INSERT INTO trainplan (id, fecha, distancia, tipo, comentario) VALUES (NULL, STR_TO_DATE('$f_t', '%m/%d/%Y'), $d_t, $t_t, $c_t)";

if(mysqli_query($conn, $input_train)) {
	echo "registro con exito";
}
else {
	echo "registro fallo";
}
}	
	}

$select_train = "SELECT * FROM trainplan ORDER BY fecha DESC";
$query_select_train = mysqli_query($conn, $select_train);
$train_rows = mysqli_num_rows($query_select_train);
if ($train_rows > 0) {
	while ($row = mysqli_fetch_assoc($query_select_train)) {
		$fecha = $row["fecha"];
		$distancia = $row["distancia"] / 1000;
		$tipo_train = $row["tipo"];
		$coment_train = $row["comentario"];
		
		print "La fecha es: ".$fecha."<br>La distancia es: ".$distancia."<br>El tipo de entreamiento es: ".$tipo_train."<br>el comentario es: ".$coment_train;
	}
	
} 
mysqli_close($conn);

?>