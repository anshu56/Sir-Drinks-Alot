<?
include("sessions.php");
if($session->logged_in){
	header('Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot/home.php?uname='.$session->getUser());
}
?>
<html>
	<head>
		<link rel="stylesheet" href="nyroModal.css" />
		<script src="jquery-1.7.js" type="text/javascript"></script>
		<script src="jquery.nyroModal.custom.js" type="text/javascript"></script>	
		<<link rel="stylesheet" href="styling.css" />
	</head>
	<body>
		<script type="text/javascript">
			function goToPregame(){
				window.location="http://rustagi1.projects.cs.illinois.edu/DrinksAlot/pregame.php";
			}
			function goToThegame(){
				window.location="http://www.facebook.com";
			}
			function goToPostgame(){
				window.location="http://www.google.com";
			}
		</script>
		<h2>Sir Drinks-A-Lot</h2>
		<img class="man" src="Sir DrinksALot2.png" width=350>
		<table id='pageOptionsTable' width="75%">
 			<tr>	
 				<td align='centert'><img class="but" onclick="goToPregame()" src="pregame.png" width=250 height=250 >
 				<td align='centert'><img class="but" onclick="goToThegame()" src="thegame.png" width=250 height=250></td>
 				<td align='centert'><img class="but" onclick="goToPostgame()" src="postgame.png" width=250 height=250></td>
 			</tr>
  		</table>
		

		


		

		
		<br>
		<div id="topLogin">
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
		?>>
		<h4>
		<form action="process.php" id='loginform' method="post" enctype="multipart/form-data">
			Username: <input type="text" maxlength="25" name="user" />
			Password: <input type="password" maxlength="25" name="pass" />

			<input type="hidden" name="sublogin" value="1">
			<input type="submit" name="submit" style="background-color:#EAAA5D" value="Login" /> 
			<a href="#registerForm" style="text-decoration: none;" class="nyroModal"> <input type="button" id="RegisterButton" style="background-color:#EAAA5D" name="" value="Register" /></a>
		</form>
		</h4>
		<?
			include("RegisterForm.php");
		?>
		</div>	

		<script type="text/javascript">
			$(function() {
			  $('.nyroModal').nyroModal();
			});
		</script>
		
	</body>
</html>


