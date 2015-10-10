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
			document.getElementById("login").innerHTML = return_data;
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