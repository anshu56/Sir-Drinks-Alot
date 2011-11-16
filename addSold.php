<?
include('database.php');
$store = str_replace("!"," ",$_POST['store']);
echo $_POST['store'];
$result = $database->deleteSold($store);
if($result){
	echo "deleted";
}
else{
	echo "failed";
}
$count = (count($_POST)-1)/2;
for($i=0;$i<$count;$i+=1){
	$ingred = $_POST['ingred'.$i];
	$price = $_POST['price'.$i];
	$size = $_POST['size'.$i];
	$ingredient = str_replace("!", " ", $ingred);
	$price = str_replace("!"," ",$price);
	$size = str_replace("!"," ", $size);
	#echo "Adding TO DB in php";
	$database->addSold($store,$ingredient,$price,$size);
}

?>