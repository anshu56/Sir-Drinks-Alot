function showDrinkDetails(drink){
 	var xmlhttp;
 	if(drink==""){
 		document.getElementById("ingredList").innerHTML ="";
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
			//document.getElementById(0).innerHTML =xmlhttp.responseText;
			showDrinkDetails(drink);
		}
	}
	xmlhttp.open("GET","addRecipe.php"+string,true);
	xmlhttp.send();
}

function showStoreDetails(store){
 	var xmlhttp;
 	if(store==""){
 		document.getElementById("ingredSoldList").innerHTML ="";
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
			document.getElementById("ingredSoldList").innerHTML = xmlhttp.responseText;
		}
	}
	var newName = store.replace("!"," ");
	xmlhttp.open("GET","getItems.php?Item=IngredientFromStore&name="+store,true);
	xmlhttp.send();
}

function addIngredientToStore(){
	var tbl = document.getElementById('soldTable');
	var lastRow = tbl.rows.length;
	// if there's no header row in the table, then iteration = lastRow + 1
	var newRow = tbl.insertRow(lastRow);
	lastRow = lastRow-1;
	newRow.setAttribute('id',"sold"+lastRow);
	var newCell = newRow.insertCell(0);
	var el = document.createElement('input');
	el.type = 'text';
	el.id = "ingred"+lastRow;
	newCell.appendChild(el);
	
	var newCell2 = newRow.insertCell(1);
	var el2 = document.createElement('input');
	el2.id = "price"+lastRow;
	el2.type = 'text';
	newCell2.appendChild(el2);
	
	var newCell3 = newRow.insertCell(2);
	var el3 = document.createElement('input');
	el3.id = "size"+lastRow;
	el3.type = 'text';
	newCell3.appendChild(el3);
	//document.getElementById("ingredList").innerHTML = "xmlhttp.responseText";
	
	var newCell4 = newRow.insertCell(3);
	var button1 = document.createElement("input");
	button1.setAttribute('type','checkbox');
	button1.setAttribute('value','Remove');
	button1.setAttribute('name','Remove');
	button1.setAttribute('id','remSold'+lastRow);
	button1.onclick
	newCell4.appendChild(button1);
}
function updateStoreSoldList(store){
	var tbl = document.getElementById("soldTable");
	var lastRow = tbl.rows.length;
	for(var i=0;i<lastRow;i++){
		var check = document.getElementById('remSold'+i);
		if(check!=null && check.checked){
			document.getElementById(""+i).innerHTML ="";
		}
	}
	//document.getElementById("ingredSoldList").innerHTML = "Blanks Removed";
	var string ="store="+store;
	var numMaterials = 0;
	for(var i=0; i<lastRow;i++){
		string +="&";
		var ingred = document.getElementById('ingred'+i);
		var price = document.getElementById('price'+i);
		var size = document.getElementById('size'+i);
		if(ingred!=null && price!=null && size!=null && ingred.value!="" && price.value!="" && size.value!=null){
			var ing = ingred.value;
			var ing2 = ingred.value.replace(" ","!");
			while(ing!=ing2){
				ing = ing2;
				ing2 = ing2.replace(" ","!");
			}
			var p = price.value;
			var p2 = price.value.replace(" ","!");
			while(p!=p2){
				p = p2;
				p2 = p2.replace(" ","!");
			}
			
			var s = size.value;
			var s2 = size.value.replace(" ","!");
			while(s!=s2){
				s = s2;
				s2 = s2.replace(" ","!");
			}
			string+="ingred"+numMaterials + "="+ing;
			string+="&price"+numMaterials + "=" + p2;
			string+="&size"+numMaterials + "=" + s2;
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
		//if (xmlhttp.readyState==4 && xmlhttp.status==200)
	//	{
			//document.getElementById("ingredSoldList").innerHTML =xmlhttp.responseText;
			showStoreDetails(drink);
		//
	}
	//document.getElementById("ingredSoldList").innerHTML = "addSold.php"+string;
	//xmlhttp.open("GET","addSold.php"+string,true);
	xmlhttp.open("POST","addSold.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xmlhttp.setRequestHeader("Content-length", string.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(string);
}
