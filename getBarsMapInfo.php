<?
include("database.php");
$result = $database->getAllBarsMapInfo();
echo "{";
	echo "\"barsArray\":[";
	$bar = mysql_fetch_array($result);
	$first = True;
	while($bar!=NULL){
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
		echo "}";
		$first=false;
		$store = mysql_fetch_array($result);
	}
	echo "]";
echo "}";
?>
