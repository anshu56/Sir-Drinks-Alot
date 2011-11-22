<?
	include_once("sessions.php");
	$drinkName = str_replace("!"," ",$_GET['dname']);
	if($drinkName==Null or $database->checkDrinkExists($drinkName)==False){
		header("Location: home.php");
	}
	else{
		include("contentTemplate.php");
		//echo "<h1> ". $drinkCategory."</h1>";
	}
			echo '<div id="drinkDetails">';
				$drink = $database->getDrinkByName($drinkName);
				$drinksArr = mysql_fetch_array($drink);
				echo "<h3 style='text-align:left'> ".$drinkName."</h3>";
				echo $drinksArr['DrinkName'];
				echo "<br/>";
				echo "Ingredents: <br/>";
				$ingredients = $database->getIngredientTypes($drinkName);
				$ingredientsArr = mysql_fetch_array($ingredients);
				echo '<TABLE>';
				while($ingredientsArr!=NULL){
					echo '<tr>';
					echo '<td>'.$ingredientsArr['TypeName']."</td>";
					echo '<td>'.$ingredientsArr['Quantity']."</td>";
					$ingredientsArr = mysql_fetch_array($ingredients);
					echo '</tr>';
				}
				echo '</TABLE>';
				echo "<br/>Recipe: <br/>";
	
				echo $drinksArr['Recipe'];
				echo "<br/>";
				if ($drinksArr['imagePath'] != NULL) {
					echo "<img src=DrinkImages/" . $drinksArr['imagePath'] . " alt=\"No Image Found\"/>";
				}
			echo '</div>';
?>

		</div>
		</div>
	<body>
<html>