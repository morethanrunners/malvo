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
		//asegura el codigo se ejecute solo cuando este el POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//se agrego un nombre al imput del formulario 1 para poder verificar cual de los formularios se est utilizando. Este codigo verifica que se este usando el formulario correspondiente.
	if (isset($_POST["running_log"])) {
		
		//chequea que la variable tiempo no este vacia
		$tiempo = $_POST["segundos"] + ($_POST["minutos"] * 60) + ($_POST["horas"] * 60 * 60);
		if($tiempo == 0 || $tiempo = "" || empty($tiempo)){
			echo "no colocaste ninguna duracion.";
		}
		
		  //prueba la fecha
  $testdate = $_POST["fecha"];
  $test_arr = explode('/', $testdate);
  if (checkdate($test_arr[0], $test_arr[1], $test_arr[2])){
		
    //para colocar la distancia obligtoria, usa exit para terminar con el codigo, almacena el error como variable para poder mostrarla en otra parte
if (empty($_POST["distancia"])){
    echo $distanciaErr = "distancia es obligatorio";
}
		
		//si el campo 'ppm' esta vacio le asigna el valor NULL. todos los demas valores son los del formulario
elseif(empty($_POST["ppm"])){
    $ppm = "NULL";
    $fecha = $_POST["fecha"];
    $distanciakm = $_POST["distancia"];
        $distancia = $distanciakm * 1000;
		$tiempo = $_POST["segundos"] + ($_POST["minutos"] * 60) + ($_POST["horas"] * 60 * 60);
    $ritmo = $tiempo * 1000 / $distancia;
	if (empty($_POST["entrenamiento"])){
		$entr = "NULL";
	}
	else {
		$input_entr = $_POST["entrenamiento"];
		$entr = "'$input_entr'";
	}
}
    //si todos los campos estan llenos registra todas las variables.
else{
  $fecha = $_POST["fecha"];
  $distanciakm = $_POST["distancia"];
    $distancia = $distanciakm * 1000;
	$tiempo = $_POST["segundos"] + ($_POST["minutos"] * 60) + ($_POST["horas"] * 60 * 60);
  $ritmo = $tiempo * 1000 / $distancia;
  $ppm = $_POST["ppm"];
	if (empty($_POST["entrenamiento"])){
		$entr = "NULL";
	}
	else {
		$input_entr = $_POST["entrenamiento"];
		$entr = "'$input_entr'";
	}
}
  }
      else {
        echo "<h1>fecha en formato incorrecto</h1>";
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
mysqli_close($conn);
	}


$conn = mysqli_connect($server, $root, $password, $database);
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 

	//seleccional los datos de toda la tabla guarda los resultados en la variable $query_select
$select = "SELECT * FROM running ORDER BY fecha DESC LIMIT 7";
  $query_select = mysqli_query($conn, $select);

  //cuenta el numero de rows
$num_rows = mysqli_num_rows($query_select);
	
//si existen rows
if( $num_rows > 0){
	while ($row = mysqli_fetch_assoc($query_select)){
    
		//transforma las variables tiempo y ritmo a minutos y segundos
    $minutos = floor($row["tiempo"] / 60);
    $segundos = $row["tiempo"] % 60;
    $ritmominutos = floor ($row["ritmo"] / 60);
    $ritmosegundos = $row["ritmo"] % 60;
		
		//transforma la distancia de m a km para mostrarla en la tabala la guarda en un avariable
     $distancia_km = $row["distancia"] / 1000;
		
		//convierte la fecha de mysql a "m/d/y" y la almacena la fecha en una variable
    $strtotime = strtotime($row["fecha"]);
		$fechadisplayformat = date ("m/d/y", $strtotime);
		
    //muestra la fecha y distancia
    print "<tr><td>" .$fechadisplayformat. "</td><td>" .$distancia_km. " km";
		//si segundos es < 10 agrega un 0 y la muestra si segundos > 10 lo deja asi y lo muestra
    if ($segundos < 10){
      print "</td><td>". $minutos.":0".$segundos. "</td><td>";
    }
    else {
      print "</td><td>". $minutos.":".$segundos. "</td><td>";
    }
  
    //si rito en segundos es < 10 acomoda el formato para mostrarlo
    if($ritmosegundos < 10){
    echo $ritmominutos.":0".$ritmosegundos;
    }
    else {
      print $ritmominutos.":".$ritmosegundos;
    }
    
    //muestra las ppm
    print " /km</td><td>" .$row["ppm"]. "</td><td>" .$row["entr"]. "</td></tr>";
}
	
 }
  mysqli_close($conn);


$database = "Runlog";
$conn = mysqli_connect($server, $root, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
mysqli_close($conn);
?>