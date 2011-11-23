<?
	include_once("sessions.php");
	$ingredient = $_GET['iname'];
	if($ingredient==Null or $database->checkIngredientTypeExists($ingredient)==False){
		header("Location: home.php");
	}
	else{
		include("contentTemplate.php");
		//echo "<h1> ". $drinkCategory."</h1>";
	}
?>
		<h3 style="text-align:left"> All Drinks Containing <?echo $ingredient;?></h3>
		<table border="1" id="DrinksTable">
			<tr>
				<th>Drink Name</th>
				<th>Drink Category</th>
				<th>Difficulty</th>
				<th>Rating</th>
				<th></th>
			</tr>

		<?
			$result = $database -> getDrinksByIngredientType($ingredient);
			$dbarray = mysql_fetch_array($result);
			while($dbarray!=NULL){
				$newName = str_replace(" ","!",$dbarray['DrinkName']);
				echo "<tr id=".$newName.">";
				$drinksNameFixed = str_replace(" ","!",$dbarray['DrinkName']);
				echo "<td> <a href='drinkDetails.php?dname=$drinksNameFixed'>".$dbarray['DrinkName']."</a></td>";
				echo "<td>".$dbarray['Category']."</td>";
				echo "<td>".$dbarray['Difficulty']."</td>";
				echo "<td>".$dbarray['Rating']."</td>";
				echo "<td> <button style=\"background-color:#EAAA5D\">Find Cheapest</button> </td>";
				#echo "<td> <button onclick=\"removeDrink('".$newName."')\">Remove</button> </td>";
				echo "</tr>";
				$dbarray = mysql_fetch_array($result);
			}
			
		?>
		
		</table>
	</div>
	</div>
</body>
</html>