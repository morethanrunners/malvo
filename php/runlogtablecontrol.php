<?php
//Pone la timezone predeterminada.
date_default_timezone_set ('UTC');

		//Conecta con el servidor
$server = "localhost";
$root = "root";
$password = "goldensun2591";
$database = "Runlog";
$conn = mysqli_connect($server, $root, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//se agrego un nombre al imput del formulario 1 para poder verificar cual de los formularios se est utilizando. Este codigo verifica que se este usando el formulario correspondiente.
	if (isset($_POST["running_log"])) {
		
		//chequea que la variable tiempo no este vacia
		$tiempo = $_POST["segundos"] + ($_POST["minutos"] * 60) + ($_POST["horas"] * 60 * 60);
		
		if($tiempo == 0 || $tiempo = "" || empty($tiempo)){
			echo "no colocaste ninguna duracion.";
		}
		//si el tiempo tiene una duracion valida
		else {
			  //prueba que la fecha tenga el formto correcto
  $testdate = $_POST["fecha"];
  $test_arr = explode('/', $testdate);
  if (checkdate($test_arr[0], $test_arr[1], $test_arr[2])){
		
		//logica para verificar si la feha ya existe en la base de datos
			
		$select = "SELECT * FROM `running` WHERE `fecha` = STR_TO_DATE('$testdate', '%m/%d/%Y')";
  $query_select = mysqli_query($conn, $select);
$num_rows = mysqli_num_rows($query_select);
		if ($num_rows > 0) {
			echo "fecha ya existe";
		}
		else {
			echo "nueva fecha";
		}
		
			/*
		falta agregar un controlador para que el usuario confirme que desea agregar un nuevo entrenamiento con esa fecha
		*
		*
		si el usauario deside agregar el entrenamiento se coloca normal.
		si el usuario se equivoco de fecha selecciona no agregara el entenamiento
		*
		*
		*
		para editar un entrenamiento es necesario crear un controlador para cada registro de la tabla.
		*/
		
    //para colocar la distancia obligtoria, almacena el error como variable para poder mostrarla en otra parte
		if (!empty($_POST["distancia"])) {
			$fecha = $_POST["fecha"];
			$distanciakm = $_POST["distancia"];
			$distancia = $distanciakm * 1000;
			$tiempo = $_POST["segundos"] + ($_POST["minutos"] * 60) + ($_POST["horas"] * 60 * 60);
			$ritmo = $tiempo * 1000 / $distancia;
			if (empty($_POST["ppm"])) {
				$ppm = "NULL";
	}
			else {
				$ppm = $_POST["ppm"];
	}
			if (empty($_POST["entrenamiento"])){
				$entr = "NULL";
	}
			else {
				$input_entr = $_POST["entrenamiento"];
				$entr = "'$input_entr'";
	}
}
		else {
			echo "Distancia es obligatorio.";
		}
	}
  else {
		echo "<h1>fecha en formato incorrecto</h1>";
	}
		}
		
    
    //codigo para insertar las variables a la base de datos. el campo de 'id' siempre se pone NULL porque esta en A_I. la fecha se cambia del formato de input al formato de mysql. si el formulario los permite los valores vacios se agregan como NULL.
$input = "INSERT INTO running (id, fecha, distancia, tiempo, ritmo, ppm, entr)
VALUES (NULL, STR_TO_DATE('$fecha', '%m/%d/%Y'), $distancia, $tiempo, $ritmo, $ppm, $entr)";
  
if(mysqli_query($conn, $input)){
    echo "registro con exito";
}
    else{
        echo "registro fallo";
  }
}
	}
	//seleccional los datos de toda la tabla guarda los resultados en la variable $query_select
$select = "SELECT * FROM running ORDER BY fecha DESC, id DESC LIMIT 7";
$query_select = mysqli_query($conn, $select);

  //cuenta el numero de rows
$num_rows = mysqli_num_rows($query_select);
	
//si existen rows
if ($num_rows > 0){
	while ($row = mysqli_fetch_assoc($query_select)){
    
		//transforma las variables tiempo y ritmo a minutos y segundos 
		$tiempo = $row["tiempo"];
		$segundos = $tiempo % 60;
		$minutos = ($tiempo / 60) % 60;
		$horas = floor(($tiempo / 60) / 60);
			if ($segundos < 10) {
				$segundos = sprintf('%02d', $segundos);
			}
			if ($minutos < 10) {
				$minutos = sprintf('%02d', $minutos);
			}
		$ritmo = $row["ritmo"];
		$ritmosegundos = $ritmo % 60;
		$ritmominutos = ($ritmo / 60) % 60;
		$ritmohoras = floor(($ritmo / 60) / 60);
			if ($ritmosegundos < 10) {
				$ritmosegundos = sprintf('%02d', $ritmosegundos);
			}
			if ($ritmominutos < 10) {
				$ritmominutos = sprintf('%02d', $ritmominutos);
			}
		
		//transforma la distancia de m a km para mostrarla en la tabala la guarda en un avariable
     $distancia_km = $row["distancia"] / 1000;
		
		//convierte la fecha de mysql a "m/d/y" y la almacena la fecha en una variable
    $strtotime = strtotime($row["fecha"]);
		$fechadisplayformat = date ("m/d/y", $strtotime);
		
    //muestra la fecha y distancia
    print "<tr><td>" .$fechadisplayformat. "</td><td>" .$distancia_km. " km";
		//si segundos es < 10 agrega un 0 y la muestra si segundos > 10 lo deja asi y lo muestra
		
		
    if ($horas < 1){
      print "</td><td>".$minutos.":".$segundos. "</td><td>";
    }
    else {
      print "</td><td>".$horas.":".$minutos.":".$segundos."</td><td>";
    }
  
    //si rito en segundos es < 10 acomoda el formato para mostrarlo
    if($ritmohoras < 1){
    print $ritmominutos.":".$ritmosegundos;
    }
    else {
      print $ritmohoras.":".$ritmominutos.":".$ritmosegundos;
    }
    
    //muestra las ppm
    print " /km</td><td>" .$row["ppm"]. "</td><td>" .$row["entr"]. "</td></tr>";
}
	
 }
  mysqli_close($conn);

?>