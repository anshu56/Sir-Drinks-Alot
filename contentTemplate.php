<?
/****************************************
 * Template for all pages user sees when logged in.
 * All references must be of the format
 * include('contentTemplate.php')
 * 			CONTENT
 * 		</div>
 *		</div>
 *	<body>
 *<html>
 */
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styling.css" />
		<link rel="stylesheet" href="treeView/jquery.treeview.css" />
		<script src="jquery-1.7.js" type="text/javascript"></script>
		<script src="treeView/jquery.cookie.js" type="text/javascript"></script>
		<script src="treeView/jquery.treeview.js" type="text/javascript"></script>
			<script type="text/javascript">
			// third example
			$(document).ready(function(){
		$("#red").treeview({
			animated: "fast",
			collapsed: true
		});
		});
		</script>
	</head>
	<body>
		<h4>
			<?
				if($session->logged_in){
					$dbArray = $database->getUserInfo($session->getUser());
					echo "Welcome ".$dbArray['Name'];
					echo "&nbsp";
					echo "<a href=\"process.php\" text-align='right'>Logout</a></h4>";
				}
				else{
			?>
				<link rel="stylesheet" href="nyroModal.css" />
				<script src="jquery.nyroModal.custom.js" type="text/javascript"></script>	
				<form action="process.php" method="post" enctype="multipart/form-data">
				Username: <input type="text" maxlength="25" name="user" />
				Password: <input type="password" maxlength="25" name="pass" />
	
				<input type="hidden" name="sublogin" value="1">
				<input type="submit" name="submit" style="background-color:#EAAA5D" value="Login" /> 
				<a href="#registerForm" style="text-decoration: none;" class="nyroModal"> <input type="button" id="RegisterButton" style="background-color:#EAAA5D" name="" value="Register" /></a>
				</form></h4>
				<?
				include("RegisterForm.php");
				?>
					<script type="text/javascript">
						$(function() {
						  $('.nyroModal').nyroModal();
						});
					</script>
			<?
			}
			?>

		<?
			include("mikestyling.php");
		?>
		<p>
			
		</p>
		<br>
		<div id="topMenuContainer">
			<div id="topMenuContent">
			<ul id="menulist">
				<?
				include_once("sessions.php");
				if($session->logged_in){
					echo"<li><a href=\"home.php\" text-align='right'>Home</a></li>";
				}
				?>
				<li><a href="pregame.php" text-align='right'>Pre Game</a></li>
				<li><a href="#" text-align='right'>The Game</a></li>
				<li><a href="#" text-align='right'>Post Game</a></li>
				<?
					if($database->getAdmin($session->getUser())){
						echo"<li><a href=\"maintenance.php\" text-align='right'>Maintenance</a></li>";
					}
				?>
			</ul>
			</div>
		</div>

		<div id="menuContainer">
			<div id="menuContent">
				<ul id="red" class="treeview-red">
					<li><span>Drinks</span>
						<ul>
							<?
								$result = $database->getAllDrinkCategories();
								$dbArray = mysql_fetch_array($result);
								while($dbArray!=NULL){
									echo "<li><span><a href=\"drinkCategory.php?dname=".$dbArray['Category']."\">".$dbArray['Category']."</a></span></li>";
									$dbArray = mysql_fetch_array($result);
								}
							?>
						</ul>
					</li>
					<li><span>Ingredients</span>
						<ul>
							<?
								$result = $database->getAllIngredientTypesOrdered();
								$dbArray = mysql_fetch_array($result);
								while($dbArray!=NULL){
									echo "<li><span>".$dbArray['TypeName']."</span></li>";
									$dbArray = mysql_fetch_array($result);
								}
							?>
						</ul>
					</li>
					</ul>
			</div>
		</div>
		<div id="container">
		<div id="content">
