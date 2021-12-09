<?php 

if (!empty($pass_to_file))
{
    $user = $pass_to_file;
}
else 
{
    unset($_SESSION);
    header('index.php');
}
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
    	
    	<!--  Javascript libraries: Bootstrap -->
    	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	</head>
	<body>
    	<img src="images/background.jpg" class="background_image w-100 h-100 position-absolute">
    	<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
    		<form class="form_design welcome_form" method="GET" action="index.php">
    			<h3>Welcome <?= $user->username; ?></h3>
    			<p>
    			<b>Your email is: </b><?= $user->email?> <br>
    			<b>And you registered:</b> <?= $user->creation_date?>
    			<input type="submit" name="logout" value="Logout">
    		</form>
    	</div>
	</body>
</html>