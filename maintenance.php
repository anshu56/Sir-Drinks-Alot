<?
include_once("sessions.php");
if($session->logged_in && $database->getAdmin($session->getUser())){
include("contentTemplate.php");
	
?>
		<h1> Add Ingredient </h1>
		<form action="process.php" method="post" enctype="multipart/form-data">
			Ingredient Name:
			<input type="text" maxlength="25" name="ingredientname" />
			<br />
			Ingredient Type:
			<input type="text" maxlength="25" name="type" />
			<br />
			Proof:
			<input type="text" maxlength="3" name="proof" />
			<input type="hidden" name="subaddingredient" value="1" />
			<br />
			<input type="submit" name="submit" value="Add Ingredient" />
		</form>
		<br>

		<br>
		<h1> Add Drink </h1>
		<form action="process.php" method="post" enctype="multipart/form-data">
			Drink Name:
			<input type="text" maxlength="25" name="drinkname" />
			<br />
			Drink Rating:
			<input type="text" maxlength="25" name="rating" />
			<br />
			Drink Difficulty:
			<input type="text" maxlength="25" name="difficulty" />
			<br />
			Drink Category:
			<input type="text" maxlength="25" name="category" />
			<br />
			Drink Recipe:<br/>
			<textarea rows='5' cols='80' name="recipe" ></textarea>
			<input type="hidden" name="subadddrink" value="1" />
			<br />
			<input type="submit" name="submit" value="Add Drink" />
		</form>
		<br>
		<br>
		<h1> Add Store </h1>
		<form action="process.php" method="post" enctype="multipart/form-data">
			Store Name:
			<input type="text" maxlength="25" name="storename" />
			<br />
			Store Address:
			<input type="text" maxlength="100" name="storeaddress" />
			<br />
			Store Rating:
			<input type="text" maxlength="25" name="storerating" />
			<br />
			
			<input type="hidden" name="subaddstore" value="1" />
			<br />
			<input type="submit" name="submit" value="Add Store" />
		</form>
		<br>
		<br>
		<script src="AddIngredients.js" type="text/javascript"></script>		
		<h1> Add Ingredients to a drink </h1>
		<select name="Drinks" onchange="showDrinkDetails(this.value)">
			<option value="">Select a drink:</option>
			<?
				include_once ("database.php");
				$result = $database -> getDrinks();
				$dbarray = mysql_fetch_array($result);
				while($dbarray!=NULL){
					$newName = str_replace(" ","!",$dbarray['DrinkName']);
					echo "<option value=".$newName.">". $dbarray['DrinkName'] ."</option>";
					$dbarray = mysql_fetch_array($result);
				}
			?>
		</select>
		<div id="ingredList"> Ingredients Will Be Listed Here </div>
		
		<h1> Add Ingredients Sold In Store</h1>
		<select name="Drinks" onchange="showStoreDetails(this.value)">
			<option value="">Select a store:</option>
			<?
				include_once ("database.php");
				$result = $database -> getStores();
				$dbarray = mysql_fetch_array($result);
				while($dbarray!=NULL){
					$newName = str_replace(" ","!",$dbarray['StoreName']);
					echo "<option value=".$newName.">". $dbarray['StoreName'] ."</option>";
					$dbarray = mysql_fetch_array($result);
				}
			?>
		</select>
		<div id="ingredSoldList"> Ingredients Will Be Listed Here </div>
		
		<script type="text/javascript">
		 	function removeIngredient(ingr){
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
						document.getElementById(ingr).innerHTML ="";
					}
				}
				xmlhttp.open("GET","deleteItems.php?Item=Ingredient&name="+ingr,true);
				xmlhttp.send();
			}
		 	function removeDrink(drink){
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
						document.getElementById(drink).innerHTML ="";
					}
				}
				xmlhttp.open("GET","deleteItems.php?Item=Drink&name="+drink,true);
				xmlhttp.send();
			}
		 	function removeStore(store){
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
						document.getElementById(store).innerHTML ="";
					}
				}
				xmlhttp.open("GET","deleteItems.php?Item=Store&name="+store,true);
				xmlhttp.send();
			}
		</script>
		
		<h1> All Ingredients </h1>
		<table border="1" id="IngredientsTable">
			<tr>
				<th>Ingredient Name</th>
				<th>Ingredient Type</th>
				<th>Ingredient Proof</th>
			</tr>

		<?
			include_once ("database.php");
			$result = $database -> getIngredients();
			$dbarray = mysql_fetch_array($result);
			while($dbarray!=NULL){
				$newName = str_replace(" ","!",$dbarray['IngredientName']);
				echo "<tr id=".$newName.">";
				echo "<td>".$dbarray['IngredientName']."</td>";
				echo "<td>".$dbarray['TypeName']."</td>";
				echo "<td>".$dbarray['Proof']."</td>";
				echo "<td> <button onclick=\"removeIngredient('".$newName."')\">Remove</button> </td>";
				echo "</tr>";
				$dbarray = mysql_fetch_array($result);
			}

		?>
		</table>
		<h1> All Drinks </h1>
		<table border="1" id="DrinksTable">
			<tr>
				<th>Drink Name</th>
				<th>Difficulty</th>
				<th>Rating</th>
				<th>Category</th>
				<td></td>
			</tr>

		<?
			include_once ("database.php");
			$result = $database -> getDrinks();
			$dbarray = mysql_fetch_array($result);
			while($dbarray!=NULL){
				$newName = str_replace(" ","!",$dbarray['DrinkName']);
				echo "<tr id=".$newName.">";
				echo "<td>".$dbarray['DrinkName']."</td>";
				echo "<td>".$dbarray['Difficulty']."</td>";
				echo "<td>".$dbarray['Rating']."</td>";
				echo "<td>".$dbarray['Category']."</td>";
				#echo "<td> <button onclick=\"removeDrink(".$dbarray['DrinkName'].")\">Remove</button> </td>";
				echo "<td> <button onclick=\"removeDrink('".$newName."')\">Remove</button> </td>";
				echo "</tr>";
				$dbarray = mysql_fetch_array($result);
			}
			
		?>
		
		</table>
		<h1> All Stores </h1>
		<table border="1" id="StoresTable">
			<tr>
				<th>Store Name</th>
				<th>Store Address</th>
				<th>Store Rating</th>
				<th>Delete</th>
			</tr>
		<?
			include_once ("database.php");
			$result = $database -> getStores();
			$dbarray = mysql_fetch_array($result);
			while($dbarray!=NULL){
				$newName = str_replace(" ","!",$dbarray['StoreName']);
				echo "<tr id=".$newName.">";
				echo "<td>".$dbarray['StoreName']."</td>";
				echo "<td>".$dbarray['Address']."</td>";
				echo "<td>".$dbarray['StoreRating']."</td>";
				echo "<td> <button onclick=\"removeStore('".$newName."')\">Remove</button> </td>";
				echo "</tr>";
				$dbarray = mysql_fetch_array($result);
			}
		?>
		
		</table>
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