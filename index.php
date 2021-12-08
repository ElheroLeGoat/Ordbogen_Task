<?php 

require_once __DIR__ . '/app/collector.php';

?>

<!DOCTYPE html>
<html>
	<head>
	<!-- This login system is made for Ordbogen.com as a task. git repo: https://github.com/ElheroLeGoat/task-oop -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- CSS libraries: Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="css/main.css" rel="stylesheet">
	
	<!--  Javascript libraries: Bootstrap, VueJS, Axios-http -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	</head>
	<body>
	<img src="images/background.jpg" class="background_image w-100 h-100 position-absolute">
	<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
		<form id="login_form" method="POST">
			<h3>Login</h3>
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" placeholder="Email or username">
			<label for="password">Password:</label>
			<input type="text" id="password" name="password" placeholder="password">
			<input type="submit" id="login" value="Login">
			<h4>Don't have an account yet?</h4>
			<input type="button" id="register" value="Register now!">
		</form>
	</div>
	<!--  App Loading -->
	<script src="js/app.js"></script>
	</body>
</html>