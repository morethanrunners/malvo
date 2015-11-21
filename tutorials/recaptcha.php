<!DOCTYPE html>
<html lang="en">
  <head>
    <title>How to Integrate Google “No CAPTCHA reCAPTCHA” on Your Website</title>
  </head>
 
  <body>
 <?php 
		$name = $_POST['name'];
		$email = $_POST['email'];
		$recaptcha = $_POST['g-recaptcha-response'];
		
		echo $name;
		echo $email;
		echo $recaptcha;
?>
    <form action="" method="post">
 
      <label for="name">Name:</label>
      <input name="name" required><br />
 
      <label for="email">Email:</label>
      <input name="email" type="email" required><br />
 
      <div class="g-recaptcha" data-sitekey="6Lfhtw8TAAAAAM_f6XwYRs9BEqANXkTLetOU-Tey"></div>
 
      <input type="submit" value="Submit" />
 
    </form>
 
    <!--js-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
 
  </body>
</html>