<?
	include_once("sessions.php");
	$drinkCategory = $_GET['dname'];
	if($drinkCategory==Null or $database->checkDrinkCategoryExists($drinkCategory)==False){
		header("Location: home.php");
	}
	else{
		include("contentTemplate.php");
		//echo "<h1> ". $drinkCategory."</h1>";
	}
?>
		<h3 style="text-align:left"> All Drinks </h3>
		<table border="1" id="DrinksTable">
			<tr>
				<th>Drink Name</th>
				<th>Difficulty</th>
				<th>Rating</th>
			</tr>

		<?
			$result = $database -> getDrinksByCategory($drinkCategory);
			$dbarray = mysql_fetch_array($result);
			while($dbarray!=NULL){
				$newName = str_replace(" ","!",$dbarray['DrinkName']);
				echo "<tr id=".$newName.">";
				echo "<td>".$dbarray['DrinkName']."</td>";
				echo "<td>".$dbarray['Difficulty']."</td>";
				echo "<td>".$dbarray['Rating']."</td>";
				#echo "<td> <button onclick=\"removeDrink(".$dbarray['DrinkName'].")\">Remove</button> </td>";
				#echo "<td> <button onclick=\"removeDrink('".$newName."')\">Remove</button> </td>";
				echo "</tr>";
				$dbarray = mysql_fetch_array($result);
			}
			
		?>
		
		</table>
		</div>
		</div>
	<body>
<html>
