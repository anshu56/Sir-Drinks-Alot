<?
	include('database.php');
	$storeName = $_GET['store'];
	$result= $database->getStoreInfo($storeName);
	$store = mysql_fetch_array($result);
	echo "{";
	echo "\"storeArray\":[";
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
	echo "]";
	echo "}";
?>
