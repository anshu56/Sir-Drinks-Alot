<?
	include_once("sessions.php");
	$drinkName = $_GET['dname'];
	if($drinkName==Null or ($database->checkDrinkExists($drinkName)==False && $_GET['dtype']!='Beer'  && $_GET['dtype']!='Wine')){
		header("Location: home.php");
	}
	else{
		include("contentTemplate.php");
	}
	if($_GET['dtype']==NULL){
		echo '<div id="drinkDetails">';
		$drink = $database->getDrinkByName($drinkName);
		$drinksArr = mysql_fetch_array($drink);
		echo "<h3 style='text-align:left'> ".$drinkName."</h3>";
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
		echo '</div>';
	

		echo "</br>";
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
		if(count($storeInfoArray)==0){
			echo "No store in your area sells the ingredients needed for this drink";
		}
		else{
			$alcoholicIngredients = $database->getAlcoholicIngredientTypes($drinkName);
			$alcoholicIngredientType = mysql_fetch_array($alcoholicIngredients);
			echo "Select Brands</br>";
			echo "<div id='selectDiv'>";
			$index=0;
			while($alcoholicIngredientType!=NULL){
				echo "<select id=select".$index.">";
				$index+=1;
				$ingredsResult = $database->getIngredientsByType($alcoholicIngredientType['TypeName']);
				$ingred = mysql_fetch_array($ingredsResult);
				while($ingred!=NULL){
					if($storeInfoArray[$cheapestStore][$alcoholicIngredientType['TypeName']]['name'] ==$ingred['IngredientName']){
						echo "<option value=\"".$ingred['IngredientName']."\" selected='selected'>". $ingred['IngredientName'] . "</option>";
					}
					else{
						echo "<option value=\"".$ingred['IngredientName']."\">". $ingred['IngredientName'] . "</option>";
					}
					$ingred= mysql_fetch_array($ingredsResult);
				}
				echo "</select>";
				$alcoholicIngredientType = mysql_fetch_array($alcoholicIngredients);
			}
			echo "</div>";
			echo "<button type='button' onClick=\"reCalculate('".$drinkName."')\">Re-Calculate Cheapest</button>";
			echo "</br>";
			echo "<div id='cheapContainer'>";
			echo "<div id='cheapestInformation' style='float:left; padding:10;'>";
			echo "<div id='priceComparison'>";
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
			echo "</div>";
			//echo "</br> <button type='button' onClick=\"mapCheapest('".$cheapestStore."')\">Map It!</button>";
			echo "</br><a href=\"#displayMap\" style=\"text-decoration: none;\" id='fakebutton' class=\"nyroModalMap\" onclick=\"mapCheapest()\">Map It!</a>";
			echo "<div id=priceBreakdown>";
			echo "</br> Price Breakdown: </br>";
			echo "<table>";
			$storeInfo = $storeInfoArray[$cheapestStore];
			foreach($storeInfo as &$ingred){
				echo "<tr><td>".$ingred['name']."</td><td>$".$ingred['price']."</td></tr>";
			}
			echo "</table>";
			echo "</div>";
			echo "</div>";
			echo "<div id=cheapByIngredient style='padding:10; padding-left:30;'>";
		
			foreach($storeInfo as &$ingred){
				$storesSellingResult = $database->getStoresSellingIngredient($ingred['name']);
				$store = mysql_fetch_array($storesSellingResult);
				echo "Cheapest Store For " .$ingred['name'] ."</br>";
				echo $store['StoreName'] . "   $" . $store['Price'];
				echo "</br>";
			}
			echo "</div>";
			echo "</div>";
		}
	}
	else{
		$ingredient = $drinkName;
		$storeResult = $database->getStoresSellingIngredient($ingredient);
		echo $ingredient;
		$store = mysql_fetch_array($storeResult);
		$cheapestStore;
		$cheapestPrice;
		if($store!=NULL){
			$cheapestStore=$store['StoreName'];
			$cheapestPrice=$store['Price'];
		}
		echo "<table>";
		while($store!=Null){

			echo "<tr><td>".$store['StoreName']."</td><td>$".$store['Price']."</td></tr>";
			$store=mysql_fetch_array($storeResult);
		}	
		echo "</table>";
		if($cheapestStore!=Null)
			echo "</br> The Cheapest Store is ".$cheapestStore."  selling $ingredient at $".  $cheapestPrice;
		else
			echo "No store in your area sells the ingredients needed for this drink";
	}
?>

<script type="text/javascript">
	function mapCheapest(){
		
		var width = 810;
		var height = 410;
		var x = document.getElementById('storeName');
		var store=x.innerHTML;
		setDirections(store);
				
		  //alert("called");
	}
	function reCalculate(drink){
		
		var selectDiv = document.getElementById('selectDiv');
		var numSelects = selectDiv.childElementCount;
		var i;
		var string="";
		for(i=0;i<numSelects;i++){
			var select = document.getElementById("select"+String(i));
			string+="ingred"+String(i)+"="+(select.options[select.selectedIndex].value)+"&";
		}
		string = string.slice(0,-1);
	 	var xmlhttp;
	 	//document.getElementById('tb').value = ingr;
	 	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//document.getElementById('cheapContainer').innerHTML =xmlhttp.responseText;
				var jsondata = eval('(' + xmlhttp.responseText + ')');
				document.getElementById('priceComparison').innerHTML =jsondata.priceComparison;
				document.getElementById('priceBreakdown').innerHTML =jsondata.priceBreakdown;
				document.getElementById('cheapByIngredient').innerHTML =jsondata.cheapByIngredient;
				
			}
		}
		
		xmlhttp.open("GET","calculateCheapest.php?drink="+drink+"&"+string,true);
		xmlhttp.send();
	}
</script>


</div>
</div>
</html
