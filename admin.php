<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styling.css" />
	</head>
	<body>
		<?
			include("mikestyling.php");
		?>
		<p>
			
		</p>
		<br>
		<div id="topMenuContainer">
			<div id="topMenuContent">
			<ul id="menulist">
				<li>Home</li>
				<li>Pre Game</li>
				<li>The Game</li>
				<li>Post Game</li>
				<li> <a href="process.php" text-align='right'>logout</a></li>
				<?
					if($database->getAdmin($_GET["uname"])){
						echo "<li>Maintenance</li>";
					}
				?>
			</ul>
			</div>
		</div>
		<div id="menuContainer">
			<div id="menuContent">
				Menu
			</div>
		</div>
		<div id="container">
		<div id="content">
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
		
		<script type="text/javascript">
		 	
		 	function showDrinkDetails(drink){
			 	var xmlhttp;
			 	if(drink==""){
			 		document.getElementById("ingredList").innerHTML =""
			 		return;
			 	}
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
						document.getElementById("ingredList").innerHTML = xmlhttp.responseText;
					}
				}
				var newName = drink.replace("!"," ");
				xmlhttp.open("GET","getItems.php?Item=Ingredient&name="+drink,true);
				xmlhttp.send();
			}
			function addIngredientToRecipe(){
				var tbl = document.getElementById('recipe');
				var lastRow = tbl.rows.length;
				// if there's no header row in the table, then iteration = lastRow + 1
				var newRow = tbl.insertRow(lastRow);
				lastRow = lastRow-1;
				newRow.setAttribute('id',lastRow);
				var newCell = newRow.insertCell(0);
				var el = document.createElement('input');
				el.type = 'text';
				el.id = "type"+lastRow;
				newCell.appendChild(el);
				
				var newCell2 = newRow.insertCell(1);
				var el2 = document.createElement('input');
				el2.id = "quant"+lastRow;
				el2.type = 'text';
				newCell2.appendChild(el2);
				//document.getElementById("ingredList").innerHTML = "xmlhttp.responseText";
				
				var newCell3 = newRow.insertCell(2);
				var button1 = document.createElement("input");
				button1.setAttribute('type','checkbox');
				button1.setAttribute('value','Remove');
				button1.setAttribute('name','Remove');
				button1.setAttribute('id','check'+lastRow);
				button1.onclick
				newCell3.appendChild(button1);
			}
			function removeRecipeIngredient(index){
				document.getElementById(index).innerHTML ="";
			}
			function updateRecipe(drink){
				var tbl = document.getElementById("recipe");
				//document.getElementById(0).innerHTML = "Hello";
				var lastRow = tbl.rows.length;
				for(var i=0;i<lastRow;i++){
					var check = document.getElementById('check'+i);
					if(check!=null && check.checked){
						document.getElementById(""+i).innerHTML ="";
					}
				}
				
				var string ="?drink="+drink;
				var numMaterials = 0;
				for(var i=0; i<lastRow;i++){
					string +="&";
					var ingred = document.getElementById('type'+i);
					var quant = document.getElementById('quant'+i);
					if(ingred!=null && quant!=null && ingred.value!="" && quant.value!=""){
						var ing = ingred.value;
						var ing2 = ingred.value.replace(" ","!");
						while(ing!=ing2){
							ing = ing2;
							ing2 = ing2.replace(" ","!");
						}
						var q = quant.value;
						var q2 = quant.value.replace(" ","!");
						while(q!=q2){
							q = q2;
							q2 = q2.replace(" ","!");
						}
						string+="type"+numMaterials + "="+ing;
						string+="&quant"+numMaterials + "=" + q2;
						numMaterials++;
					}
					else{
						string = string.slice(0,-1);
					}
				}
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
						document.getElementById(0).innerHTML =string;
					}
				}
				xmlhttp.open("GET","addRecipe.php"+string,true);
				xmlhttp.send();
			}
		</script>
		
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
				<th></th>
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