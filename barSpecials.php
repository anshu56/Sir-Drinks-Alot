<?
	include_once("sessions.php");
	
	include('contentTemplate.php');
?>
	<table border='1'>
	<tr>
	<th></th>
	<th>Sunday</th>
	<th>Monday</th>
	<th>Tuesday</th>
	<th>Wednesday</th>
	<th>Thursday</th>
	<th>Friday</th>
	<th>Saturday</th>
	</tr>
	<?
		function printDealsByDay($bar,$db,$day){
			$dealResult = $db->getBarSpecialsByDay($bar,$day);
			$deal = mysql_fetch_array($dealResult);
			echo "<td>";
			echo "<table>";
			while($deal!=Null){
				echo "<tr>";
				echo "<td>";
				if($deal['Price']!=null){
					if($deal['Price']==0)
						echo 'Free ';
					else{
						if(floor($deal['Price']*10)== $deal['Price']*10 && floor($deal['Price'])!= $deal['Price']){
							echo '$'.$deal['Price'].'0';
							echo ' ';
						}else{
							echo '$'.$deal['Price'];
							echo ' ';
						}
					}
				}
				echo $deal['Deal'];
				echo "</td>";
				echo "</tr>";
				$deal = mysql_fetch_array($dealResult);
			}
			echo "</table>";
			echo "</td>";
		}
		function printDeals($bar,$db){
			printDealsByDay($bar,$db,"Sunday");
			printDealsByDay($bar,$db,"Monday");
			printDealsByDay($bar,$db,"Tuesday");
			printDealsByDay($bar,$db,"Wednesday");
			printDealsByDay($bar,$db,"Thursday");
			printDealsByDay($bar,$db,"Friday");
			printDealsByDay($bar,$db,"Saturday");

		}
		$result = $database->getBarNames();
		$bar = mysql_fetch_array($result);
		
		while($bar!=null){
			echo "<tr><td>".$bar['Name']."</td>";
			printDeals($bar['Name'],$database);
			echo "</tr>";
			$bar = mysql_fetch_array($result);
		}
	?>
	</table>
	
	</div>
	</div>
	</body>
</html>
