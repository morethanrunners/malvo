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

function newLog(){
	var hr = new XMLHttpRequest();
				
	var url = "http://localhost/~erwinhenriquezviejo/malvo/tutorials/newlog.php";
	var fecha = document.getElementById("fecha").value;
	var distancia = document.getElementById("distancia").value;
	var tiempo = document.getElementById("tiempo").value;
	var vars = "fecha="+fecha+"&distancia="+distancia+"&tiempo="+tiempo;
	
	hr.open("POST", url, true);
	
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
 hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("runlog").innerHTML = return_data;
	    }
    }
	hr.send(vars);	
}

function logTable(){
	var hr = new XMLHttpRequest();
	var url = "http://localhost/~erwinhenriquezviejo/malvo/tutorials/showtable.php";
	
	hr.open("POST", url, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("logtable").innerHTML = return_data;
	    }
    }
	hr.send();
}