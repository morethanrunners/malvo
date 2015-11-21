/*

****IMPORTANTE****

Este archivo esta fuera de uso. las finciones aqui descritas han sido agregadas a "functions.js"

****IMPORTANTE****


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

function reset() {
	var form = document.getElementById("form");
	form.reset();
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
}*/