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
		<form class="login_form form_design" v-on:submit.prevent="exec">		
		<div class="back_arrow" v-if="configs.registerform" v-on:click="switchForm()">
			<i class="arrow"></i>
		</div>
			<h3>{{ configs.loginheader }}</h3>
			<label for="username">Username:</label>
			<input v-model="form.username" type="text" id="username" name="username" placeholder="Username" :value="[[ form.username ]]" data-toggle="tooltip" data-placement="bottom" :data-bs-original-title="[[ tooltips.username ]]">
			<label for="password">Password:</label>
			<input v-model="form.password" type="password" id="password" name="password" placeholder="password" :value="[[ form.password ]]" data-toggle="tooltip" data-placement="bottom" :data-bs-original-title="[[ tooltips.password ]]">
			<div v-if="configs.registerform">
    			<label for="repeat_password">repeat Password:</label>
    			<input v-model="form.repeat" type="password" id="repeat_password" name="repeat_password" placeholder="Repeat password" :value="[[ form.repeat ]]">			
    			<label for="email">Email: </label>
    			<input v-model="form.email" type="text" id="email" name="email" placeholder="example@example.com" :value="[[ form.email ]]">
			</div>
			<input type="submit" id="login" :value="[[ configs.loginheader ]]">
			<h4 v-if="!configs.registerform">Don't have an account yet?</h4>
			<input type="button" id="register" v-if="!configs.registerform" v-on:click="switchForm()" value="Register now!">
		</form>
	</div>
	<!--  App Loading -->
	<script src="js/app.js"></script>
	<script>
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
	</script>
	</body>
</html>