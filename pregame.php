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
				background-image:url(winebuttonhover.jpg);
			}
		
		</style>
		<script type="text/javascript">
			function goLite(FORM,BUTTON){
			window.document.forms[FORM].elements[BUTTON].style.backgroundImage="url(winebuttonhover.jpg)";
			}
		</script>
		<form name="drinkbuttons">
		<input type="button" class="picbutton" style="background-image:url(DrinkButtonImages/beerbutton.jpg)" value="Beer">
		
		<input type="button" class="picbutton" style="background-image:url(DrinkButtonImages/winebutton.jpg)" value="Wine">
		<br/>
		<input type="button" class="picbutton" style="background-image:url(DrinkButtonImages/mixedbutton.jpg)" value="Mixed Drinks">
		<input type="button" class="picbutton" style="background-image:url(DrinkButtonImages/rocksbutton.jpg)" value="On the Rocks">
		<br/>
		<input type="button" class="picbutton" style="background-image:url(DrinkButtonImages/bombbutton.jpg)" value="Bombs">
		<input type="button" class="picbutton" style="background-image:url(DrinkButtonImages/shotsbutton.jpg)" value="Shots">
		</form>
	</div>
	</div>
	</body>
</html>