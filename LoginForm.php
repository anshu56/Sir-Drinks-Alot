<?
include_once("sessions.php");
if($session->logged_in){
	header('Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot');
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styling.css" />
	</head>
	<body>
	<?
		include("mikestyling.php");
	?>
	<br>
	<div id="container">
	<div id="content">
	
	<h1> Login </h1>
		<?
		    if($form->num_errors>0){
		        #echo "Username And Password Could Not Be Found";
		        #print_r($form->errors);
		        $errors = "";
		        if($form->errors['user'] and $form->errors['pass']){
		            echo "Username and Password could not be found";
		        }
		        else if($form->errors['user']){
		            echo "Username could not be found";
		        }
		        else if($form->errors['pass']){
		            echo "Password could not be found";
		        }
		    }
		?>
		<script type="text/javascript">	
			function registerClicked(){
				window.location = "RegisterForm.php";			
			}
		</script>
		<form action="process.php" method="post" enctype="multipart/form-data">
			Username: <input type="text" maxlength="25" name="user" /><br />
			Password: <input type="password" maxlength="25" name="pass" /><br />
			Remember me next time   <input type="checkbox" name="remember" /> <br />
			<input type="hidden" name="sublogin" value="1">
			<input type="submit" name="submit" value="Login" /> 
			<input type="button" id="RegisterButton" onclick="registerClicked()" name="" value="Register" />
			</form>
					
	</div>
	</div>	
	</body>
</html>
