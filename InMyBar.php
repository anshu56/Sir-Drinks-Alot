<?
	include_once("sessions.php");
	
	include('contentTemplate.php');
?>
	<script type="text/javascript">
		var arSelected = new Array();
		function findDrinks(){
		 	var nm1 = $('#imgFiche').nyroModal({closeOnClick: false,showCloseButton:true,callbacks : {
                afterShowCont: function() {
                    getPossibleDrinks();
                    //alert("called");
                }
            }});
            $('#imgFiche').nmCall();
       }
       function getPossibleDrinks(){
			var selected = new Array();
			var indexes = new Array();
   			var typesSelect = document.forms["frmSelect"].elements["availableIngredients"];
			
		   while(typesSelect.selectedIndex != -1)
		   {
		      if(typesSelect.selectedIndex != 0)
		      {
		         selected.push(typesSelect.options[typesSelect.selectedIndex].value);
		         indexes.push(typesSelect.selectedIndex);
		     //    typesSelect.options[typesSelect.selectedIndex].selected=1;
		      }
		 
		   	 typesSelect.options[typesSelect.selectedIndex].selected = false;
		   }
		   for(i in indexes){
		   
		   		//alert(i);
		   	 typesSelect.options[indexes[i]].selected = true;
		   }
		 	var xmlhttp;
		 	//document.getElementById('tb').value = ingr;
		 	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			}
			else{// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			var string ="";
			var index=0;
			for(x in selected){
				string+=String(index)+"="
				string+=String(selected[x]);
				string+='&';
				index++;
			}
			string=string.substring(0,string.length-1);
			//document.getElementById('working').innerHTML="Working";
			//$(function() {

	
			//});
			
			//function getPossibleDrinks(){
			document.getElementById('possibleDrinks').innerHTML ="";
			xmlhttp.open("GET","findPossibleDrinks.php?"+string,true);
			xmlhttp.send();
			//nm1.close();
			var obj = $.nmTop();
			for (var key in obj) {
			    if (obj.hasOwnProperty(key)) {
			    }
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					$.nmTop().close();
					document.getElementById('possibleDrinks').innerHTML =xmlhttp.responseText;
				}
			}
			//}

		}
	</script>
	<div id=working style="position:absolute; left:-100000">
	<a href="modalWindowImages/ajaxLoader.gif" id="imgFiche" class="nyroModal" rel="gal"></a>
	</div>
	<H4 style="text-align: left">Select All Drinks You Have</H4>
	<form name='frmSelect'>
	<select multiple="multiple" size=20 id="availableIngredients">
		<?
			$result = $database->getAllAlcoholicIngredientTypesOrdered();
			$dbArray = mysql_fetch_array($result);
			while($dbArray!=NULL){
				echo "<option style='background-color:#EAAA5D' value='".$dbArray['TypeName']."'>".$dbArray['TypeName']."</option>";
				$dbArray = mysql_fetch_array($result);
			}
			
		?>
	</select>
	</br>
	</form>
	<input type="submit" name="submit" value="Find Drinks" onclick="findDrinks();"/>
	
	
	<div id="possibleDrinks">
		
	</div>
	</div>
	</div>
	</body>
</html>