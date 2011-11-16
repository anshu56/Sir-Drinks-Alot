<?
include('database.php');
$drink = str_replace("!"," ",$_GET['drink']);
$database->deleteRecipe($drink);
$count = (count($_GET)-1)/2;
$increment=0;
for($i=0;$i<$count;$i+=1){
	$type = $_GET['type'.$increment];
	$quant = $_GET['quant'.$increment];
	$type = str_replace("!", " ", $type);
	$quant = str_replace("!"," ",$quant);
	$increment+=1;
	$database->addRecipe($drink,$type,$quant);
}

?>