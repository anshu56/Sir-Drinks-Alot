<?
include("database.php");
$item = $_GET['Item'];
if($item=="Ingredient"){
	$newName = str_replace("!"," ",$_GET['name']);
	#echo $newName;
	$result = $database -> getIngredientTypesOrdered($newName);
	if($result){
		$dbarray = mysql_fetch_array($result);
		echo "<table border=\"1\" id=\"recipe\">";
		echo "<tr><th>Ingredients</th><th>Quantity</th><th>Remove</th></tr>";
		$index=0;
		while($dbarray!=NULL){
			echo "<tr id=".$index."><td>";
			#echo $dbarray['TypeName'] . "  ";
			echo "<input type=\"text\" value=\"".$dbarray['TypeName']."\" id=\"type".$index."\"/>";
			echo "</td><td>";
			echo "<input type=\"text\" value=\"".$dbarray['Quantity']."\" id=\"quant".$index."\"/>";
			echo "</td>";
			echo "<td> <input type=checkbox id=check".$index."> </td>";
			echo "</tr>";
			$dbarray = mysql_fetch_array($result);
			$index+=1;
		}
		echo "</table>";
		echo "<td> <button onclick=\"addIngredientToRecipe()\">Add Ingredient</button> </td>";
		echo "<td> <button onclick=\"updateRecipe('".$_GET['name']."')\">Update Recipe</button> </td>";
		
	}
	else{
		echo "Not Found";
	}
}
elseif($item=="newRowForStore"){
    echo "<td>";
    $index = $_GET['index'];
		$ingredResult = $database->getIngredientsOrdered();
		$ingredArray = mysql_fetch_array($ingredResult);
		echo "<select id=\"ingred".$index."\">";
		while($ingredArray!=NULL){
		  echo "<option value=\"".$ingredArray['IngredientName']."\">". $ingredArray['IngredientName'] ."</option>";
		  $ingredArray = mysql_fetch_array($ingredResult);
		}
		echo "</select>";
		echo "</td><td>";
		echo "<input type=\"text\" value=\"\" id=\"price".$index."\"/>";
		echo "</td><td>";
		echo "<input type=\"text\" value=\"\" id=\"size".$index."\"/>";
		echo "</td>";
		echo "<td> <input type=checkbox id=remSold".$index."> </td>";
}
elseif($item=="IngredientFromStore"){
	$newName = str_replace("!"," ",$_GET['name']);
	#echo $newName;
	$result = $database -> getIngredientsSoldOrdered($newName);
	if($result){
		$dbarray = mysql_fetch_array($result);
		echo "<table border=\"1\" id=\"soldTable\">";
		echo "<tr><th>Ingredients</th><th>Price</th><th>Size</th><th>Remove</th></tr>";
		$index=0;
		while($dbarray!=NULL){
			echo "<tr id=".$index."><td>";
			#echo $dbarray['TypeName'] . "  ";
			echo "<select id=\"ingred".$index."\">";
			$ingredResult = $database->getIngredients();
			$ingredArray = mysql_fetch_array($ingredResult);
			while($ingredArray!=NULL){
				if($ingredArray['IngredientName']==$dbarray['IngredientName'])
			  	echo "<option value=\"".$ingredArray['IngredientName']."\" id=\"ingred".$index."\" selected='selected'>". $ingredArray['IngredientName'] ."</option>";
			  else
			  	echo "<option value=\"".$ingredArray['IngredientName']."\" id=\"ingred".$index."\">". $ingredArray['IngredientName'] ."</option>";
			  $ingredArray = mysql_fetch_array($ingredResult);
			}
			echo "</select>";
			//echo "<input type=\"text\" value=\"".$dbarray['IngredientName']."\" id=\"ingred".$index."\"/>";
			echo "</td><td>";
			echo "<input type=\"text\" value=\"".$dbarray['Price']."\" id=\"price".$index."\"/>";
			echo "</td><td>";
			echo "<input type=\"text\" value=\"".$dbarray['Size']."\" id=\"size".$index."\"/>";
			echo "</td>";
			echo "<td> <input type=checkbox id=remSold".$index."> </td>";
			echo "</tr>";
			$dbarray = mysql_fetch_array($result);
			$index+=1;
		}
		echo "</table>";
		echo "<td> <button onclick=\"addIngredientToStore()\">Add Ingredient</button> </td>";
		echo "<td> <button onclick=\"updateStoreSoldList('".$_GET['name']."')\">Update List</button> </td>";
		
	}
	else{
		echo "Not Found";
	}
	
}

#echo "CALLED";
?>
