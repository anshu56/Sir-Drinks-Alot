<?
include_once("sessions.php");
		if($session->logged_in && $session->getUser() == $_GET["uname"]){
		include("contentTemplate.php");
			
		?>
		<p>
			<div id="drinkOfTheDay" style='overflow: auto;'>
					<?
					$numDrinks = $database -> getNumDrinks();
					$drinksResult = $database -> getDrinksOrdered();
					$drinksArr = mysql_fetch_array($drinksResult);
					$date = getdate();
					$seed = $date['year']*10000;
					$seed = $seed + $date['mon']*100;
					$seed = $seed + $date['mday'];
					srand($seed);
					$num = rand(0, $numDrinks - 1);
					for ($i = 0; $i < $num; $i++) {
						$drinksArr = mysql_fetch_array($drinksResult);
					}
					echo "<h4>Drink of the day</h4>";
					echo $drinksArr['DrinkName'];
					echo "<br/>";
					echo "<div>";
					echo "<div style='float:left;'>";
					echo "<br/> <br/> Ingredents: <br/>";
					$ingredients = $database->getIngredientTypes($drinksArr['DrinkName']);
					$ingredientsArr = mysql_fetch_array($ingredients);
					echo "<TABLE style='margin: 0 auto;'>";
					while($ingredientsArr!=NULL){
						echo '<tr>';
						echo '<td>'.$ingredientsArr['TypeName']."</td>";
						echo '<td>'.$ingredientsArr['Quantity']."</td>";
						$ingredientsArr = mysql_fetch_array($ingredients);
						echo '</tr>';
					}
					echo '</TABLE>';
					echo "</br>";
					echo "</div>";
					echo "<div>";
					if ($drinksArr['imagePath'] != NULL) {
						
						echo "<img src=DrinkImages/" . $drinksArr['imagePath'] . " alt=\"No Image Found\"/>";
						//echo "dsflsdfsd";
					}
					echo "</div>";
					echo "</div>";
					
					echo "</br>Recipe: <br/>";

					echo $drinksArr['Recipe'];
					echo "<br/>";
					echo "<br/>";
					echo "<br/>";
					?>
			</div>
			<div id="preferredDrinks">
				<?
					/*$result = $database -> getPreferredDrinks($session->getUser());
					if($result){
						$dbarray = mysql_fetch_array($result);
						echo "<table border=\"1\" id=\"recipe\">";
						echo "<tr><th>Favorite Drinks</th><th>Remove</th></tr>";
						$index=0;
						while($dbarray!=NULL){
							echo "<tr id=".$index."><td>";
							#echo $dbarray['TypeName'] . "  ";
							echo "<input type=\"text\" value=".$dbarray['TypeName']." id=\"type".$index."\"/>";
							echo "</td><td>";
							echo "<input type=\"text\" value=\"".$dbarray['Quantity']."\" id=\"quant".$index."\"/>";
							echo "</td>";
							echo "<td> <input type=checkbox id=check".$index."> </td>";
							echo "</tr>";
							$dbarray = mysql_fetch_array($result);
							$index+=1;
						}
						echo "</table>";
						echo "<td> <button onclick=\"addIngredientToRecipe()\">Add Drink</button> </td>";
						echo "<td> <button onclick=\"updateRecipe('".$_GET['name']."')\">Update Favorites</button> </td>";
		
					}
					else{
						echo "Not Found";
					}*/
				?>
			</div>
		</p>
		<p>
			<div id="favorites">
			
			</div>
		</p>
		</div>
		</div>
	<body>
<html>

<?
}
else{
header('Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot');
}
?>
