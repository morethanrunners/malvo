<?php
date_default_timezone_set ('UTC');

		//Conecta con el servidor
$server = "localhost";
$root = "root";
$password = "goldensun2591";
$database = "runlg";
$conn = mysqli_connect($server, $root, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

$select = "SELECT * FROM runlog ORDER BY run_date DESC, run_id DESC LIMIT 7";
$query_select = mysqli_query($conn, $select);

  //cuenta el numero de rows
$num_rows = mysqli_num_rows($query_select);
	
//si existen rows
if ($num_rows > 0){
	while ($row = mysqli_fetch_assoc($query_select)){
    
		//transforma las variables tiempo y ritmo a minutos y segundos 
		$tiempo = $row["time"];
		$segundos = $tiempo % 60;
		$minutos = ($tiempo / 60) % 60;
		$horas = floor(($tiempo / 60) / 60);
			if ($segundos < 10) {
				$segundos = sprintf('%02d', $segundos);
			}
			if ($minutos < 10) {
				$minutos = sprintf('%02d', $minutos);
			}
		$ritmo = $row["pace"];
		$ritmosegundos = $ritmo % 60;
		$ritmominutos = ($ritmo / 60) % 60;
		$ritmohoras = floor(($ritmo / 60) / 60);
			if ($ritmosegundos < 10) {
				$ritmosegundos = sprintf('%02d', $ritmosegundos);
			}
			if ($ritmominutos < 10) {
				$ritmominutos = sprintf('%02d', $ritmominutos);
			}
		$ppm = $row["bpm"];
		$entr = $row["run_type"];
		
		//transforma la distancia de m a km para mostrarla en la tabala la guarda en un avariable
     $distancia_km = $row["distance"] / 1000;
		
		//convierte la fecha de mysql a "m/d/y" y la almacena la fecha en una variable
    $strtotime = strtotime($row["run_date"]);
		$fechadisplayformat = date ("m/d/y", $strtotime);
		
    //muestra la fecha y distancia
    print '<tr><td id="fecha">' .$fechadisplayformat. '</td><td id="distancia">' .$distancia_km. " km";
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
    print " /km</td><td>" .$ppm. "</td><td>" .$entr. "</td></tr>";
}
	
 }
?>