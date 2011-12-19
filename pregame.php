<?
	include_once("sessions.php");
	
	include('contentTemplate.php');
?>
		<style type="text/css">
			input.picbutton{
				font-weight:bold;
				font-size:40px;
				height:100px;
				width:300px;
				margin:5px;
				
			}
			input.picbutton:hover{
				goLite(drinkbuttons,this);
			}
		
		</style>
		<script type="text/javascript">
			function goLite(FORM,BUTTON){
			window.document.forms[FORM].elements[BUTTON].style="background-image:url(DrinkButtonImages/winebuttonhover.jpg)";
			}
			function gotoBeer(){
			window.location="http://rustagi1.projects.cs.illinois.edu/DrinksAlot/drinkCategory.php?dname=Beer";
			}
			function gotoWine(){
			window.location="http://rustagi1.projects.cs.illinois.edu/DrinksAlot/drinkCategory.php?dname=Wine";
			}
			function gotoMixed(){
			window.location="http://rustagi1.projects.cs.illinois.edu/DrinksAlot/drinkCategory.php?dname=Mixed%20Drink";
			}
			function gotoShots(){
			window.location="http://rustagi1.projects.cs.illinois.edu/DrinksAlot/drinkCategory.php?dname=Shot";
			}
			function gotoBombs(){
			window.location="http://rustagi1.projects.cs.illinois.edu/DrinksAlot/drinkCategory.php?dname=Bomb";
			}
			function gotoRocks(){
			window.location="http://rustagi1.projects.cs.illinois.edu/DrinksAlot/drinkCategory.php?dname=Mixed%20Drink";
			}
			
			
		</script>
		<form name="drinkbuttons">
			<input type="button" class="picbutton" onclick="gotoBeer()" style="background-image:url(DrinkButtonImages/beerbutton.jpg)" value="Beer">
			<input type="button" class="picbutton" onclick="gotoWine()" style="background-image:url(DrinkButtonImages/winebutton.jpg)" value="Wine">
			<br/>
			<input type="button" class="picbutton" onclick="gotoMixed()" style="background-image:url(DrinkButtonImages/mixedbutton.jpg)" value="Mixed Drinks">
			<input type="button" class="picbutton" onclick="gotoRocks()" style="background-image:url(DrinkButtonImages/rocksbutton.jpg)" value="On the Rocks">	
			<br/>
			<input type="button" class="picbutton" onclick="gotoBombs()" style="background-image:url(DrinkButtonImages/saki_bomb.png)" value="Bombs">
			<input type="button" class="picbutton" onclick="gotoShots()" style="background-image:url(DrinkButtonImages/shotsbutton.jpg)" value="Shots">
		</form>
	</div>
	</div>
	</body>
</html>