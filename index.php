<!DOCTYPE html>
<html>
<head>
<!--  Titulo-->
  <title>Malvo. A Training Log for runners.</title>
  <meta charset="utf-8">
<!--  Hojas de estilo-->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="angular-chart.js/angular-chart.min.css">
</head>
  
<body ng-app="app">
<!--  Jumbotron-->
  <div class="jumbotron">
    <div class="container">
<!--      Titulo principal-->
      <h1 class="lead">Malvo. <small>A Training Log for runners.</small></h1>
			</div>
  </div>
<!-- Espacio para los forms -->
  <div class="forms">
    
    <div class="container">
      
      <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<!--        Row para los forms-->
        <div class="row">
          
          <div class="col-md-2">
            <h4>Date</h4>
            <div class="input-group">
              <span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-calendar"></span></span>
              <input type="text" name="fecha" class="form-control" placeholder="mm/dd/yy" aria-describedby="date" required>
            </div>
          
          </div>
          
<!--          Distancia-->  
          <div class="col-md-3">
            <h4>Distance</h4>
            <div class="input-group">
              <span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-road"></span></span>
    
    <input type="number" name="distancia" step="0.1" class="form-control" placeholder="in Km" aria-describedby="dist" required>
            </div>
          </div>
          
<!--          Tiempo-->
          <div class="col-md-3">
            <h4>Time</h4>
            <div class="input-group">
              <span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-time"></span></span>
              <input type="text" name="horas" class="form-control" placeholder="Hrs" aria-describedby="dist">
    <span class="input-group-addon timeSpace" id="time">:</span>
    <input type="text" name="minutos" class="form-control" placeholder="Min" aria-describedby="dist">
              <span class="input-group-addon timeSpace" id="time">:</span>
              <input type="text" name="segundos" class="form-control" placeholder="Sec">
            </div>
            
          </div>

<!--          PPM-->
          <div class="col-md-2">
            <h4>BPM</h4>
            <div class="input-group">
    <span class="input-group-addon custom-padding" id="ppm"><span class="glyphicon glyphicon-heart"></span></span>
    <input type="text" name="ppm" class="form-control" placeholder="BPM" aria-describedby="dist">
            </div>
          </div>
<!--          Tipo-->
          
          <div class="col-md-2">
            <h4>Type of Training</h4>
            <div class="input-group">
    <span class="input-group-addon custom-padding" id="pace"><span class="glyphicon glyphicon-flag"></span></span>
    <input type="text" name="entrenamiento" class="form-control" placeholder="Type" aria-describedby="dist">
            </div>
          </div>
        </div>
        
<!--        Boton Submit-->
          <div class="align-center">
            <input type="submit" name="running_log" value="Submit" class="btn btn-default espacio25">
          </div>
        
      </form>
    </div>
  </div>
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

?>
<!--  Espacio para la tabla y gráfica-->
  <div class="data">
<!--    Contenedor-->
    <div class="container">
      <div class="row">
        
<!--        Tabla en 6 col medianas-->
        <div class="col-md-6">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Date</th>
                <th>Distance
                  <span class="caret"></span></th>
                  
                <th>Time <span class="caret"></span></th>
                <th>Pace <span class="caret"></span></th>
                <th>BPM <span class="caret"></span></th>
                <th>Type <span class="caret"></span></th>
              </tr>
            </thead>
            <tbody>
              <?php
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

							?>
            </tbody>
          </table>
          
<!--          Boton para ver todo-->
          <div class="align-center">
            <button type="button" class="btn btn-default" onclick="openNewWindow()" >See All</button>
          </div>
        </div>
<!--        Espacio de gráfico en 6 col medianas-->
        <div class="col-md-6 ng-scope" ng-controller="TabController as tab">
<!--          Pills para cambiar de gráfica-->
            <ul class="nav nav-pills">
              <li ng-class="{ active:tab.isSet(1)}"><a href ng-click=tab.setTab(1)>Distance</a></li>
              <li ng-class="{ active:tab.isSet(2)}"><a href ng-click=tab.setTab(2)>Time</a></li>
              <li ng-class="{ active:tab.isSet(3)}"><a href ng-click=tab.setTab(3)>Pace</a></li>
            </ul>
<!--          Este es el gráfico-->
          <div ng-controller="BarCtrl" ng-show="tab.isSet(1)">
            <canvas id="line" class="chart chart-bar" chart-data="data" chart-labels="labels" chart-legend="true" chart-series="series" chart-click="onClick">
            </canvas>
          </div>
          <div ng-controller="LineCtrl" ng-show="tab.isSet(2)">
            <canvas id="line" class="chart chart-bar" chart-data="data" chart-labels="labels" chart-legend="true" chart-series="series" chart-click="onClick">
            </canvas>
          </div>
          <div ng-controller="PaceCtrl" ng-show="tab.isSet(3)">
            <canvas id="line" class="chart chart-bar" chart-data="data" chart-labels="labels" chart-legend="true" chart-series="series" chart-click="onClick">
            </canvas>
          </div>
          
          
        </div>
      </div>
			<div class="training_plan">
	<?php

$database = "Runlog";
$conn = mysqli_connect($server, $root, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
mysqli_close($conn);
?>
			<div class="plan_input">
				<h2>Training program</h2>
				<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?> "method="post">
			Date<br>
			<input type="text" name="fecha_train" placeholder="mm/dd/yy" required><br>
			Distance<br>
			<input type="number" name="distancia_train" step="0.1" placeholder="distance in 'Km'"><br>
			Training type<br>
			<input type="text" name="tipo_train" required><br>
			Comments<br>
			<input type="text" name="coment_train" maxlength="140"><br>
			<input type="submit" name="training_program">
				</form>
			</div>
			<div class="plan">
				
			<?php
$conn = mysqli_connect($server, $root, $password, $database);

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

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
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
echo $train_rows;
mysqli_close($conn);

			?>
</div>
	</div>
    </div>
  </div>
	
<!--  Javascript-->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js" type="text/javascript"></script>
  <script src="js/Chart.min.js"></script>
  <script src="angular-chart.js/angular-chart.min.js"></script>
  <script src="js/app2.js"></script>
  <script src="js/functions.js"></script>
  
</body>
</html>