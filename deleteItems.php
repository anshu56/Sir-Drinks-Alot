<?
/*if (isset($_POST['DeleteDrink'])) {
 #echo $_POST['DeleteDrink'];
 include("database.php");
 #echo $_POST['DeleteDrink'];
 $newName = str_replace("#"," ",$_POST['DeleteDrink']);
 $result = $database->removeDrink($newName);
 if($result){
 #echo "Location: http://rustagi1.projects.cs.illinois.edu/".$_POST['Sender'];
 header("Location: http://rustagi1.projects.cs.illinois.edu/".$_POST['Sender']);
 }
 }*/
$item = $_GET['Item'];
include ("database.php");
if ($item == "Ingredient") {
	$newName = str_replace("!"," ",$_GET['name']);
	$result = $database -> removeIngredient($newName);
	if ($result) {
		$result = $database -> getDrinks();
		$dbarray = mysql_fetch_array($result);
	} else {
		echo "Failure";
	}
}
else if($item == "Drink"){
	$newName = str_replace("!"," ",$_GET['name']);
	echo $_GET['name'];
	$result = $database -> removeDrink($newName);
	if (!$result) {
		echo "Failure";
	}
}
else if($item == "Store"){
	$newName = str_replace("!"," ",$_GET['name']);
	echo $_GET['name'];
	$result = $database -> removeStore($newName);
	if (!$result) {
		echo "Failure";
	}
}
?>