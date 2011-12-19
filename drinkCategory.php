<?
	include_once("sessions.php");
	$drinkCategory = $_GET['dname'];
	if($drinkCategory==Null or ($database->checkDrinkCategoryExists($drinkCategory)==False && $drinkCategory!='Beer' && $drinkCategory!='Wine')){
		header("Location: home.php");
	}
	else{
		include("contentTemplate.php");
		//echo "<h1> ". $drinkCategory."</h1>";
	}
	
	if($drinkCategory!='Beer' && $drinkCategory!='Wine'){
?>
		<h3 style="text-align:left"> All Drinks </h3>
		<table border="1" id="DrinksTable">
			<tr>
				<th>Drink Name</th>
				<th>Difficulty</th>
				<th>Rating</th>
				<th></th>
			</tr>

		<?
			$result = $database -> getDrinksByCategory($drinkCategory);
			$dbarray = mysql_fetch_array($result);
			while($dbarray!=NULL){
				$newName = str_replace(" ","!",$dbarray['DrinkName']);
				echo "<tr id=".$newName.">";
				$drinksNameFixed = str_replace(" ","!",$dbarray['DrinkName']);
				echo "<td> <a href='drinkDetails.php?dname=$drinksNameFixed'>".$dbarray['DrinkName']."</a></td>";
				echo "<td>".$dbarray['Difficulty']."</td>";
				echo "<td>".$dbarray['Rating']."</td>";
				echo "<td> <button style=\"background-color:#EAAA5D\" onClick=\"window.location='findCheapest.php?dname=".$dbarray['DrinkName']."'\">Find Cheapest</button> </td>";
				#echo "<td> <button onclick=\"removeDrink('".$newName."')\">Remove</button> </td>";
				echo "</tr>";
				$dbarray = mysql_fetch_array($result);
			}
			
		?>
		
		</table>
		<?
		}
		else{
		?>
		
				<h3 style="text-align:left"> All Drinks </h3>
		<table border="1" id="DrinksTable">
			<tr>
				<th>Drink Name</th>
				<th>ABV</th>
				<th></th>
			</tr>

		<?
			$result = $database->getIngredientsByType($drinkCategory);
			$dbarray = mysql_fetch_array($result);
			while($dbarray!=NULL){
				$newName = str_replace(" ","!",$dbarray['IngredientName']);
				echo "<tr id=".$newName.">";
				$drinksNameFixed = str_replace(" ","!",$dbarray['IngredientName']);
				echo "<td> <a href='drinkDetails.php?dname=$drinksNameFixed&dType=$drinkCategory'>".$dbarray['IngredientName']."</a></td>";
				echo "<td> ".$dbarray['Proof']/2.0."</td>";
				echo "<td> <button style=\"background-color:#EAAA5D\" onClick=\"window.location='findCheapest.php?dtype=".$drinkCategory."&dname=".$dbarray['IngredientName']."'\">Find Cheapest</button> </td>";
				#echo "<td> <button onclick=\"removeDrink('".$newName."')\">Remove</button> </td>";
				echo "</tr>";
				$dbarray = mysql_fetch_array($result);
			}
			
		?>
		</table>
		<?
		}
		?>
