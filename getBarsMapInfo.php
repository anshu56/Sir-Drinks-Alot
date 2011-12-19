<?
include("database.php");
$result = $database->getAllBarsMapInfo();
echo "{";
	echo "\"barsArray\":[";
	$bar = mysql_fetch_array($result);
	$first = True;
	while($bar!=NULL){
		$dealResult = $database->getBarSpecialsByDay($bar['Name'],date('l'));
		$deal = mysql_fetch_array($dealResult);
		if(!$first)
			echo ",";
		echo "{";
		echo "\"barName\":"."\"".$bar['Name']."\"";
		echo ",";
		echo "\"Address\":"."\"".$bar['Address']."\"";
		echo ",";
		echo "\"Description\":"."\"".$bar['Description']."\"";
		echo ",";
		echo "\"Latitude\":"."\"".$bar['Latitude']."\"";
		echo ",";
		echo "\"Longitude\":"."\"".$bar['Longitude']."\"";
		echo ",";
		echo "\"Open\":"."\"".$bar['Open']."\"";
		echo ",";
		echo "\"Close\":"."\"".$bar['Close']."\"";
		echo ",";
		echo "\"deals\":[";	
			$first2= True;
			while($deal!=NULL){
				if(!$first2)
					echo ",";
				echo "{";
				echo "\"deal\":"."\"".$deal['Deal']."\"";
				echo ",";
				echo "\"price\":"."\"".$deal['Price']."\"";
				echo "}";
				$deal = mysql_fetch_array($dealResult);
				$first2=false;
			}
		echo "]";
		echo "}";
		$first=false;
		$bar = mysql_fetch_array($result);
	}
	echo "],";
	echo "\"liquorStoreArray\":[";
	$result=$database->getStores();
	$store = mysql_fetch_array($result);
	$first = True;
	while($store!=NULL){
		if(!$first)
			echo ",";
		echo "{";
		echo "\"storeName\":"."\"".$store['StoreName']."\"";
		echo ",";
		echo "\"Address\":"."\"".$store['Address']."\"";
		echo ",";
		echo "\"Latitude\":"."\"".$store['Latitude']."\"";
		echo ",";
		echo "\"Longitude\":"."\"".$store['Longitude']."\"";
		echo ",";
		echo "\"Open\":"."\"".$store['Open']."\"";
		echo ",";
		echo "\"Close\":"."\"".$store['Close']."\"";
		echo "}";
		$first=false;
		$store = mysql_fetch_array($result);
	}
	echo "]";
echo "}";
?>
