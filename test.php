<?
include("database.php");
$fp = fopen('./sql.txt', 'r');
while (($line = fgets($fp, 4096)) !== false) {
	echo($line);
	$database->query($line);
	echo"</br>";
}
fclose($fp);
?>