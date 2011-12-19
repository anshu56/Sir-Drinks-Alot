<?
	include_once("sessions.php");
	$drinkName = str_replace("!"," ",$_GET['dname']);
	$drinkCategory = $_GET['dType'];
	if($drinkName==Null or ($database->checkDrinkExists($drinkName)==False && $_GET['dType']!='Beer'  && $_GET['dType']!='Wine')){
		header("Location: home.php");
	}
	else{
		include("contentTemplate.php");
		//echo "<h1> ". $drinkCategory."</h1>";
	}
	
	if($drinkCategory!='Beer' && $drinkCategory!='Wine'){
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
				echo "</br><a href='findCheapest.php?dname=".$drinkName."' style=\"text-decoration: none;\" id='fakebutton'>Find Cheapest</a>";
			echo '</div>';
		}
		else{
			$result = $database->getIngredientInformation($drinkName);
			$result = mysql_fetch_array($result);
			echo "<TABLE style='border:1;'>";
			echo "<TH>Name</TH><TH>ABV</TH><TH></TH>";
			echo "<TR><TD>".$result['IngredientName']."</TD><TD>";
			echo $result['Proof']/2.0;
			echo "</TD>";
			echo "<td> <button style=\"background-color:#EAAA5D\" onClick=\"window.location='findCheapest.php?dtype=".$drinkCategory."&dname=".$result['IngredientName']."'\">Find Cheapest</button> </td>";
			echo "</tr>";
			echo "</TABLE>";
		}
?>

		</div>
		</div>
	<body>
<html>
