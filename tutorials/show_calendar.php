<html>
<head>
	<link rel="stylesheet" href="calccs.css">		
<script>
		function initialCalendar() {
			var hr = new XMLHttpRequest();
			var url = "calendar_start.php";
			var currentTime = new Date();
			var month = currentTime.getMonth() + 1;
			var year = currentTime.getFullYear();
			showmonth = month;
			showyear = year;
			var vars = "showmonth="+showmonth+"&showyear="+showyear;
			hr.open ("POST", url, true);
			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			hr.onreadystatechange = function () {
				if (hr.readyState == 4 && hr.status == 200) {
					var return_data = hr.responseText;
					document.getElementById("showCalendar").innerHTML = return_data;
				}
			}
			hr.send(vars);
		}
	</script>

	
<!--	js para Next Month-->
	
<script>
		function next_month() {
			var nextmonth = showmonth + 1;
			if (nextmonth > 12) {
				nextmonth = 1;
				showyear = showyear + 1;
			}
			showmonth = nextmonth
			var hr = new XMLHttpRequest();
			var url = "calendar_start.php";
			var vars = "showmonth="+showmonth+"&showyear="+showyear;
			hr.open ("POST", url, true);
			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			hr.onreadystatechange = function () {
				if (hr.readyState == 4 && hr.status == 200) {
					var return_data = hr.responseText;
					document.getElementById("showCalendar").innerHTML = return_data;
				}
			}
			hr.send(vars);
		}
	</script>
	
	
<!--	js para last month-->

<script>
		function last_month() {
			var lasttmonth = showmonth - 1;
			if (lasttmonth < 1) {
				lasttmonth = 12;
				showyear = showyear - 1;
			}
			showmonth = lasttmonth;
			
			var hr = new XMLHttpRequest();
			var url = "calendar_start.php";
			var vars = "showmonth="+showmonth+"&showyear="+showyear;
			hr.open ("POST", url, true);
			hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			hr.onreadystatechange = function () {
				if (hr.readyState == 4 && hr.status == 200) {
					var return_data = hr.responseText;
					document.getElementById("showCalendar").innerHTML = return_data;
				}
			}
			hr.send(vars);
		}
	</script>

	
</head>
<body onload="initialCalendar();">
	<div id="showCalendar"></div>
</body>
</html>