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
	echo "]";
echo "}";
?>