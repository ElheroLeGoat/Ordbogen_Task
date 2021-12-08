<!DOCTYPE html>
<html>
	<head>
	<!-- This login system is made for Ordbogen.com as a task. git repo: https://github.com/ElheroLeGoat/task-oop -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- CSS libraries: Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="css/main.css" rel="stylesheet">
	
	<!--  Javascript libraries: Bootstrap, VueJS, Vee-validate, Axios-http -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
	<script src="https://unpkg.com/vee-validate@2.0.0-rc.18/dist/vee-validate.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	</head>
	<body>
	<img src="images/background.jpg" class="background_image w-100 h-100 position-absolute">
	<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
		<form id="login_form" @submit="login">
			<h3>Login</h3>
			<div class="error_list" v-if="errors.length">
				
			</div>
			<label for="username">Username:</label>
			<input v-model="form.username" type="text" id="username" name="username" placeholder="Email or username">
			<label for="password">Password:</label>
			<input v-model="form.password" type="text" id="password" name="password" placeholder="password">
			<input type="submit" id="login" value="Login">
			<h4>Don't have an account yet?</h4>
			<input type="button" id="register" value="Register now!">
		</div>
	</div>
	<!--  App Loading -->
	<script src="js/app.js"></script>
	</body>
</html>