<?
	include_once("sessions.php");
	
	include('contentTemplate.php');
?>
	<H4 style="text-align: left">Select All Drinks You Have</H4>
	<select multiple="" size=20>
		<?
			$result = $database->getAllAlcoholicIngredientTypesOrdered();
			$dbArray = mysql_fetch_array($result);
			while($dbArray!=NULL){
				echo "<option style='background-color:#EAAA5D'>".$dbArray['TypeName']."</option>";
				$dbArray = mysql_fetch_array($result);
			}
		?>
	</select>
	</br>
	<input type="submit" name="submit" value="Find Drinks" />
	</div>
	</div>
	</body>
</html>