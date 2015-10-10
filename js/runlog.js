/*
*
*
*Este js es para crear funciones que permitan agregar el input a la base de datos y automaticamnete actualizar la tabla que se muestra
*
*
*IMPORTANTE
*los archivos de php de los que se extrae la data estan separados
*
*
*/

function newLog() {
	var hr = new XMLHttpRequest();
	var url = "http://localhost/~erwinhenriquezviejo/malvo/php/newlog.php";
	var fecha = document.getElementById("fecha").value;
	var distancia = document.getElementById("distancia").value;
	var horas = document.getElementById("horas").value;
	var minutos = document.getElementById("minutos").value;
	var segundos = document.getElementById("segundos").value;
	var ppm = document.getElementById("ppm").value;
	var entrenamiento = document.getElementById("entrenamiento").value;
	var vars = "fecha="+fecha+"&distancia="+distancia+"&horas="+horas+"&minutos="+minutos+"&segundos="+segundos+"&ppm="+ppm+"&entrenamiento="+entrenamiento;
	
	hr.open("POST", url, true);
	
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
	    if(hr.readyState === 4 && hr.status === 200) {
		    var return_data = hr.responseText;
			document.getElementById("runlog").innerHTML = return_data;
	    }
    }
	hr.send(vars);
}

function logTable(){
	var hr = new XMLHttpRequest();
	var url = "http://localhost/~erwinhenriquezviejo/malvo/php/logtable.php";
	
	hr.open("POST", url, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 hr.onreadystatechange = function() {
	  if (hr.readyState === 4 && hr.status === 200) {
			var return_data = hr.responseText;
			document.getElementById("logtable").innerHTML = return_data;
		}
  }
	hr.send();
}