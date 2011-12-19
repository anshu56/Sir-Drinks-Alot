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
			<select name="type">
			<?
				$result = $database -> getAllIngredientTypesOrdered();
				$dbarray = mysql_fetch_array($result);
				while($dbarray!=NULL){
					echo "<option value=\"".$dbarray['TypeName']."\">". $dbarray['TypeName'] ."</option>";
					$dbarray = mysql_fetch_array($result);
				}
			?>
			</select>
			<br />
			Proof:
			<input type="text" maxlength="10" name="proof" />
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
			<select name="category">
			<?
				$result = $database -> getAllDrinkCategories();
				$dbarray = mysql_fetch_array($result);
				while($dbarray!=NULL){
					echo "<option value=\"".$dbarray['Category']."\">". $dbarray['Category'] ."</option>";
					$dbarray = mysql_fetch_array($result);
				}
			?>
			</select>
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
		
		<br>
		<br>
		<script type="text/javascript">
			function addPollOption(){
					
				var tbl = document.getElementById('addPollTable');
				var lastRow = tbl.rows.length;
				// if there's no header row in the table, then iteration = lastRow + 1
				var newRow = tbl.insertRow(lastRow);
				lastRow = lastRow;
				newRow.setAttribute('id',lastRow);
				var newCell = newRow.insertCell(0);
				var el = document.createElement('input');
				el.type = 'text';
				el.id = "poll"+lastRow;
				newCell.appendChild(el);
			}
			function createNewPoll(id){
				var tbl = document.getElementById("addPollTable");
				//document.getElementById(0).innerHTML = "Hello";
				var lastRow = tbl.rows.length;
				var str = "";
				for(var i=0;i<lastRow;i++){
					var poll = document.getElementById('poll'+i);
					if(poll.value!=null){
						alert(poll.value);
						str+="val"+i+"="+poll.value+"&";
					}
				}
				string = str.slice(0,-1);
				
				var xmlhttp;
				if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						//document.getElementById(0).innerHTML =xmlhttp.responseText;
						alert(xmlhttp.responseText);
					}
				}
				alert(string);
				xmlhttp.open("GET","addPoll.php?pollId="+id+"&"+string,true);
				xmlhttp.send();
			}
		</script>	
		<h1> Add Poll </h1>
			<?
				$result = $database -> query("SELECT Max(poll_id) FROM Polls");
				$dbarray = mysql_fetch_array($result);
				$poll_id = $dbarray['Max(poll_id)']+1;
				//$database -> query("INSERT INTO Polls(poll_id) VALUES ($poll_id)");
			?>
			<table id='addPollTable'>
			<tr><td><input type="text" maxlength="25" id="poll0"/></td></tr>
			</Table>
			<button onclick=addPollOption()>Add Option</button>
			<?
			echo "<button onclick=createNewPoll('".$poll_id."')>Submit Poll</button>";
			?>
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
