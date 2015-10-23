function logIn() {
			var hr = new XMLHttpRequest;
			var url = "http://localhost/~erwinhenriquezviejo/malvo/php/login.php";
			var user = document.getElementById("loginUser").value;
			var password = document.getElementById("loginPass").value;
			var vars = "user="+user+"&password="+password;
			
			hr.open("POST", url, true);
			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			hr.onreadystatechange = function() {
				if(hr.readyState === 4 && hr.status === 200) {
					var return_data = hr.responseText;
					document.getElementById("loginresult").innerHTML = "Please Wait..."
					
					if (return_data == "Debes colocar todos los datos" || return_data == "Debes activar tu cuenta antes de poder ingresar" || return_data == "Algo salio mal" || return_data == "La contrasena es incorrecta" || return_data == "Parece que ese usuario no existe") {
						document.getElementById("loginresult").innerHTML = return_data;
					}
					else {
							window.location.assign("http://localhost/~erwinhenriquezviejo/malvo/userlog.php?user="+return_data);
					}
	    }
    }
	hr.send(vars);
		}

function signUp() {
			var hr = new XMLHttpRequest() ;
			var url = "http://localhost/~erwinhenriquezviejo/malvo/php/signup.php";
			var user = document.getElementById("signupUser").value;
			var password = document.getElementById("signupPass").value;
			var password_confirm = document.getElementById("signupPass2").value;
			var email = document.getElementById("signupEmail").value;
			var firstname = document.getElementById("signupName").value;
			var lastname = document.getElementById("signupLastName").value;
			var vars = "user=" + user + "&password=" + password + "&password_confirm=" + password_confirm + "&email=" + email + "&firstname=" + firstname + "&lastname=" + lastname;
			hr.open("POST", url, true);
			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			hr.onreadystatechange = function() {
				if(hr.readyState === 4 && hr.status === 200) {
					var return_data = hr.responseText;
					if (return_data == "Registro con exito") {
						document.getElementById("result").innerHTML = "Hola "+user+". Tus datos se han ingresado con exito chequea tu bandeja de entrada en el correo proporcionado: "+email+" para proseguir con el proceso de activacion. Despues de la activacion puedes hacer Log In."
				}
					else {
						document.getElementById("result").innerHTML = return_data;
					}
				}
			}
			hr.send(vars);
		}

function recoverPass() {
	var hr = new XMLHttpRequest;
	var url = "http://localhost/~erwinhenriquezviejo/malvo/php/recoverpass.php";
	var firstname = document.getElementById("recoverName").value;
	var lastname = document.getElementById("recoverLastName").value;
	var user = document.getElementById("recoverUser").value;
	var email = document.getElementById("recoverEmail").value;
	var email2 = document.getElementById("recoverEmail2").value;
	var vars = "firstname="+firstname+"&lastname="+lastname+"&user="+user+"&email="+email+"&email2="+email2;
	
	hr.open("POST", url, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			hr.onreadystatechange = function() {
				if(hr.readyState === 4 && hr.status === 200) {
					var return_data = hr.responseText;
					if (return_data === "exito") {
						document.getElementById("login").innerHTML = "<p>Hemos enviado un correo a la direccion asociada a tu cuenta para seguir con el proceso de recuperacion de contrasena.</p>"
					}
					else {
						document.getElementById("login").innerHTML = return_data;
					}
	    }
    }
	hr.send(vars);
	/*
	Para controlar errores
	document.getElementById("test").innerHTML = vars;
	*/
}

function changePass() {
	var hr = new XMLHttpRequest;
	var url = "http://localhost/~erwinhenriquezviejo/malvo/php/changepass.php";
	var p1 = document.getElementById("newPass1").value;
	var p2 = document.getElementById("newPass2").value;
	var vars = "newPass1="+p1+"&newPass2="+p2;

	hr.open("POST", url, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState === 4 && hr.status === 200) {
			var return_data = hr.responseText;
			if (return_data === "exito") {
				document.getElementById("changeResult").innerHTML = "Clave actualizada";
			}
			else {
				document.getElementById("changeResult").innerHTML = return_data;
			}
		}
	}
	hr.send(vars);
	document.getElementById("testResult").innerHTML = vars;
}

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

function logTable() {
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

function deleteLog() {

}