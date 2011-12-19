<?
include('database.php');
function ifIngredientSelected($ingredient){
	foreach($_GET as $value){
		if($value==$ingredient)
			return True;
	}
	return False;
}
$drinkArr = array();
foreach($_GET as $value){
	//echo("<H3 style='text-align:left;'>".$value."</H3>");
	//echo"</br>";
	$result = $database->getDrinksByIngredientType($value);
	$drink = mysql_fetch_array($result);
	while($drink!=NULL){
		//echo ($drink['DrinkName']."</br>");
		$drinkArr[$drink['DrinkName']]=0;
		$drink = mysql_fetch_array($result);
	}
	//echo('</br>');
}
$drinkArr = array_keys($drinkArr);
$numExtraDrinksArr = array();
foreach($drinkArr as $drink){
	$result=$database->getAlcoholicIngredientTypes($drink);
	$ingredient = mysql_fetch_array($result);
	$numExtraDrinks=0;
	while($ingredient!=NULL){
		if(!ifIngredientSelected($ingredient['TypeName'])){
			$numExtraDrinks+=1;
		}
		$ingredient = mysql_fetch_array($result);
	}
	$numExtraDrinksArr[$drink]=$numExtraDrinks;
	#echo($drink);
	#echo"</br>";
}
$numExtra=0;
//print_r($numExtraDrinksArr);
echo"</br>";
while(count($numExtraDrinksArr)>0){
	$keys = array_keys($numExtraDrinksArr);
	echo "<H4 style='text-align:left'> $numExtra Extra Alcoholic Ingredients </H4>";
	foreach($keys as $drink){
		if($numExtraDrinksArr[$drink]==$numExtra){
			echo "<a href='drinkDetails.php?dname=$drink' target='_blank'>".$drink."</a>";
			echo "</br>";
			unset($numExtraDrinksArr[$drink]);
		}
	}
	echo"</br>";
	$numExtra++;
}
//print_r($numExtraDrinksArr);
?>