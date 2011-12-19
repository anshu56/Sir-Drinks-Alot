<?
include("database.php");
$drinkName = $_GET['drink'];
unset($_GET['drink']);
$storeResult = $database->getStores();
$curMin = 100000;
$cheapestStore="";
$store = mysql_fetch_array($storeResult);
$storeInfoArray = array();
while($store!=Null){
	$tempInfo = array();
	$alcoholicIngredients = $database->getAlcoholicIngredientTypes($drinkName);
	$alcoholicIngredientType = mysql_fetch_array($alcoholicIngredients);
	$curPrice=0;
	$hasIngredients = true;
	while($alcoholicIngredientType!=NULL){
		$result = $database->getTypeSoldOrdered($alcoholicIngredientType['TypeName'],$store['StoreName']);
		$sold = mysql_fetch_array($result);
		while($sold!=null && !in_array($sold['IngredientName'],$_GET)){
			$sold = mysql_fetch_array($result);
		}
		if($sold==null){
			$hasIngredients=false;
			break;
		}

		$curPrice+=$sold['Price'];
		$tempInfo[$alcoholicIngredientType['TypeName']] = array("name"=>$sold['IngredientName'], "price"=>$sold['Price'],"storeName"=>$store['StoreName']);
		$alcoholicIngredientType = mysql_fetch_array($alcoholicIngredients);

	}
	if($curPrice!=0 && $hasIngredients){
		$storeInfoArray[$store['StoreName']]=$tempInfo;
		if($curPrice<$curMin){
			$curMin=$curPrice	;
			$cheapestStore = $store['StoreName'];
		}
	}
	$store = mysql_fetch_array($storeResult);
	$hasIngredients = true;
	
}
echo "{";
echo "\"priceComparison\":\"";
echo "<table>";
foreach ($storeInfoArray as &$store) {
	$storeName;
	$sum=0;
	foreach($store as &$ingred){
		$storeName = $ingred['storeName'];
		$sum += $ingred['price'];
	}
	echo "<tr><td>".$storeName."</td><td>$". $sum ."</td></tr>";
}
echo "</table>";
echo "</br>";
echo "Cheapest Store For ".$drinkName.":</br>";
echo "<span id=storeName>".$cheapestStore."</span>" . " $" . $curMin;
echo "\",";
echo "\"priceBreakdown\":\"";
echo "</br> Price Breakdown: </br>";
echo "<table>";
$storeInfo = $storeInfoArray[$cheapestStore];
foreach($storeInfo as &$ingred){
	echo "<tr><td>".$ingred['name']."</td><td>$".$ingred['price']."</td></tr>";
}
echo "</table>";
echo "\",";

echo "\"cheapByIngredient\":\"";
foreach($storeInfo as &$ingred){
	$storesSellingResult = $database->getStoresSellingIngredient($ingred['name']);
	$store = mysql_fetch_array($storesSellingResult);
	echo "Cheapest Store For " .$ingred['name'] ."</br>";
	echo $store['StoreName'] . "   $" . $store['Price'];
	echo "</br>";
}
echo "\"";
echo "}";
?>
