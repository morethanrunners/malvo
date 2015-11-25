<?php
include_once('check_login_status.php');

$select = "SELECT * FROM runlog WHERE user_id='".$log_id."' ORDER BY run_date DESC, run_id DESC LIMIT 7";
$query_select = mysqli_query($conn, $select);

  //cuenta el numero de rows
$num_rows = mysqli_num_rows($query_select);
	
//si existen rows
if ($num_rows > 0){
	while ($row = mysqli_fetch_assoc($query_select)){
    
		//transforma las variables tiempo y ritmo a minutos y segundos 
		$run_id = $row["run_id"];
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
		$fechadisplayformat = date ("d/m/y", $strtotime);
		
    //muestra la fecha y distancia
    print "<tr id='$run_id'><td>" .$fechadisplayformat. '</td><td>' .$distancia_km. " km";
		//si segundos es < 10 agrega un 0 y la muestra si segundos > 10 lo deja asi y lo muestra
		
		
    if ($horas < 1){
      print "</td><td>".$minutos.":".$segundos. "</td><td>";
    }
    else {
      print "</td><td>".$horas.":".$minutos.":".$segundos."</td><td>";
    }
  
    //si rito en segundos es < 10 acomoda el formato para mostrarlo
    if($ritmohoras < 1){
    print $ritmominutos.":".$ritmosegundos." /km</td>";
    }
    else {
      print $ritmohoras.":".$ritmominutos.":".$ritmosegundos." /km</td>";
    }
    
    //muestra las ppm
    print "<td>" .$ppm. "</td><td>" .$entr. "</td><td><button class='fa fa-trash-o' data-toggle='modal' data-target='#deleteModal".$run_id."'><button class='fa fa-pencil' data-toggle='modal' data-target='#editModal".$run_id."'></td></tr>";
		
		/*En esta seccion se imprimen los modales de cada boton de delete*/
		print "<div class='modal fade' id='deleteModal".$run_id."' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel".$run_id."'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'><div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						<span aria-hidden='true'>&times;</span></button>
							<h4 class='modal-title text-center' id='deleteModalLabel".$run_id."'>Borrar registro</h4>
				</div>
				<div class='modal-body'>
					<p class='text-center strong'>Estas seguro de querer borrar este registro. Una vez borredo esta data no puede ser recuperada.</p>
				</div>
				<div class='modal-footer'>
					<div class='col-md-6 text-left'>
						<button type='button' class='btn btn-primary' onclick='deleteRow(".$run_id.");' data-toggle='modal' data-dismiss='modal' data-target='#deleteModal'>Confirmar</button>
					</div>
					<div class='col-md-6 text-rigth'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>";
		
		/*En esta seccion se imprimen los modales de cada boton de editar*/
		print "<div class='modal fade' id='editModal".$run_id."' tabindex='-1' role='dialog' aria-labelledby='editModalLabel".$run_id."'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title text-center' id='editModalLabel".$run_id."'>Editar registro</h4>
      </div>
      <div class='modal-body'>
       <form id='reg-edit'>
			 
<!--Fecha-->
				<div class='form-group'>
					<h5>Fecha</h5>
          	<div class='input-group'>
            	<span class='input-group-addon custom-padding'><span class='glyphicon glyphicon-calendar'></span></span>
							<input type='text' name='fecha' id='fecha-edit".$run_id."' class='form-control' placeholder='dd/mm/aa' value='".$fechadisplayformat."' aria-describedby='date' required>
            </div>
        </div>
          
<!--Distancia-->  
				<div class='form-group'>
					<h5>Distancia</h5>
					<div class='input-group'>
						<span class='input-group-addon custom-padding'><span class='glyphicon glyphicon-road'></span></span>
						<input type='number' id='distancia-edit".$run_id."' name='distancia' step='0.1' class='form-control' placeholder='in Km' value='".$distancia_km."' aria-describedby='dist' required>
					</div>
				</div>
          
<!--Tiempo-->
				<div class='form-group'>
					<h5>Tiempo</h5>
					<div class='input-group'>
						<span class='input-group-addon custom-padding'><span class='glyphicon glyphicon-time'></span></span>
						<input type='text' id='horas-edit".$run_id."' name='horas' class='form-control' placeholder='Hrs' value='".$horas."' aria-describedby='dist'>
	<span class='input-group-addon timeSpace' id='time'>:</span>
	<input type='text' id='minutos-edit".$run_id."' name='minutos' class='form-control' placeholder='Min' value='".$minutos."' aria-describedby='dist'>
						<span class='input-group-addon timeSpace' id='time'>:</span>
						<input type='text' id='segundos-edit".$run_id."' name='segundos' class='form-control' placeholder='Sec' value='".$segundos."'>
					</div>
				</div>

<!--PPM-->
				<div class='form-group'>
					<h5>PPM</h5>
					<div class='input-group'><span class='input-group-addon custom-padding'><span class='glyphicon glyphicon-heart'></span></span>
						<input type='text' id='ppm-edit".$run_id."' name='ppm' class='form-control' placeholder='BPM' value='".$ppm."' aria-describedby='dist'>
					</div>
				</div>

<!--          Tipo-->
          
          <div class='form-group'>
            <h5>Entrenamiento</h5>
            <div class='input-group'><span class='input-group-addon custom-padding' id='pace'><span class='glyphicon glyphicon-flag'></span></span>
							<input type='text' id='entre-edit".$run_id."' name='entrenamiento' class='form-control' placeholder='Type' value='".$entr."' aria-describedby='dist'>
            </div>
          </div>
			 </form>
      </div>
      <div class='modal-footer'>
				<div class='col-md-6 text-left'>
        	<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
        </div>
				<div class='col-md-6 text-rigth'>
					<button type='button' class='btn btn-primary' onclick='editlog(".$run_id.")' data-toggle='modal' data-dismiss='modal' data-target='#editModal'>Guardar cambios</button>
				</div>	
      </div>
    </div>
  </div>
</div>";
}	
 }
?>

<!--		/Modal-->