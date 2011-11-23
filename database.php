<?
/**************************************************
 *Database Class that handles all interactions
 *with the database.  May break this into more
 *classes when the database structure gets more
 *complex
 **************************************************/

include ("constants.php");

class MySQLDB {
	var $connection;

	function MySQLDB() {
		$this -> connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DB_NAME, $this -> connection) or die(mysql_error());
	}

	/**
	 * confirmUserPass - Checks whether or not the given
	 * username is in the database, if so it checks if the
	 * given password is the same password in the database
	 * for that user. If the user doesn't exist or if the
	 * passwords don't match up, it returns an error code
	 * (1 or 2). On success it returns 0.
	 */
	function confirmUserPass($username, $password) {

		/*Verify user is in database */
		$result = $this -> confirmUserExists($username);
		if ($result == False) {
			return 1;
		}
		/* Retrieve password from result, strip slashes */
		$dbarray = mysql_fetch_array($result);
		$dbarray['password'] = stripslashes($dbarray['password']);
		$password = stripslashes($password);
		/* Validate that password is correct */
		if ($password == $dbarray['password']) {
			return 0;
			//Success! Username and password confirmed
		} else {
			return 2;
			//Indicates password failure
		}
	}

	function confirmUserExists($username) {
		$q = "SELECT password FROM " . TBL_USERS . " WHERE username = '$username'";
		$result = mysql_query($q, $this -> connection);
		if (!$result || (mysql_numrows($result) < 1)) {
			return False;
			//Indicates username failure
		}
		return $result;
	}
	function getAdmin($username){
		$q = "SELECT Admin FROM " . TBL_USERS . " WHERE username = '$username'";
		$result = mysql_query($q, $this -> connection);
		$resultArray = mysql_fetch_array($result);
		if($resultArray['Admin']==0){
			return False;
		}
		else{
			return True;
		}
	}
	function confirmUserID($username, $userid) {

		/* Verify that user is in database */
		$q = "SELECT UserID FROM " . TBL_USERS . " WHERE username = '$username'";
		$result = mysql_query($q, $this -> connection);
		if (!$result || (mysql_numrows($result) < 1)) {
			return 1;
			//Indicates username failure
		}

		/* Retrieve userid from result, strip slashes */
		$dbarray = mysql_fetch_array($result);
		$dbarray['UserID'] = stripslashes($dbarray['UserID']);
		$userid = stripslashes($userid);

		/* Validate that userid is correct */
		if ($userid == $dbarray['UserID']) {
			return 0;
			//Success! Username and userid confirmed
		} else {
			return 2;
			//Indicates userid invalid
		}
	}

	function usernameTaken($username) {
		$q = "SELECT username FROM " . TBL_USERS . " WHERE username = '$username'";
		$result = mysql_query($q, $this -> connection);
		return (mysql_numrows($result) > 0);
	}

	function addNewUser($username, $password,$realname,$age,$gender,$location,$email) {
		if($gender == "Male"){
			$gender=1;
		}
		else{
			$gender=0;
		}
		$q = "INSERT INTO ".TBL_USERS ."(username, name,age,gender,password,location,email,userid)
VALUES ('$username','$realname',$age,$gender,'$password','$location','$email',0)";
		//echo "<br>";
		//echo $q;
		return mysql_query($q, $this -> connection);
	}

	function updateUserField($username, $field, $value) {
		$q = "UPDATE " . TBL_USERS . " SET " . $field . " = '$value' WHERE username = '$username'";
		//echo $q;
		return mysql_query($q, $this -> connection);
	}

	function getUserInfo($username) {
		$q = "SELECT * FROM " . TBL_USERS . " WHERE username = '$username'";
		$result = mysql_query($q, $this -> connection);
		/* Error occurred, return given name by default */
		if (!$result || (mysql_numrows($result) < 1)) {
			return NULL;
		}
		/* Return result array */
		$dbarray = mysql_fetch_array($result);
		return $dbarray;
	}

	function query($query) {
		return mysql_query($query, $this -> connection);
	}
	
	function addIngredient($Name,$Type,$Proof){
		$q = "INSERT INTO " .TBL_INGREDIENTS ."(IngredientName,TypeName,Proof) VALUES ('$Name','$Type',$Proof)";
		#echo $q;
		return mysql_query($q, $this -> connection);
	}
	function getIngredients(){
		$q = "SELECT * From ". TBL_INGREDIENTS;
		return mysql_query($q, $this -> connection);
	}
	function getIngredientsOrdered(){
		$q = "SELECT * From ". TBL_INGREDIENTS ." ORDER BY IngredientName";
		return mysql_query($q, $this -> connection);
	}
	function removeIngredient($Name){
		$q = "DELETE FROM " .TBL_INGREDIENTS ." WHERE IngredientName='$Name'";
		#echo $q;
		return mysql_query($q, $this -> connection);
	}


	function addDrink($Name,$Rating,$Difficulty,$Category,$Recipe){
		$q = "INSERT INTO " .TBL_DRINKS ."(DrinkName,Difficulty,Rating,Category,Recipe) VALUES ('$Name',$Rating,$Difficulty,'$Category','$Recipe')";
		#echo $q;
		return mysql_query($q, $this -> connection);
	}
	function getDrinks(){
		$q = "SELECT * From ". TBL_DRINKS;
		return mysql_query($q, $this -> connection);
	}
	function getDrinksOrdered(){
		$q = "SELECT * From ". TBL_DRINKS ." ORDER BY DrinkName";
		return mysql_query($q, $this -> connection);
	}
	function getAllDrinkCategories(){
		$q = "SELECT DISTINCT Category From ". TBL_DRINKS ." ORDER BY Category";
		return mysql_query($q, $this -> connection);		
	}
	function checkDrinkExists($DrinkName){
		$q = "SELECT COUNT(DrinkName) From ". TBL_DRINKS ." WHERE DrinkName='$DrinkName'";
		$result = mysql_query($q, $this -> connection);	
		$result = (mysql_fetch_array($result));
		if(intval($result['COUNT(DrinkName)']) >0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	function checkDrinkCategoryExists($category){
		$q = "SELECT COUNT(Category) From ". TBL_DRINKS ." WHERE Category='$category'";
		$result = mysql_query($q, $this -> connection);	
		$result = (mysql_fetch_array($result));
		if(intval($result['COUNT(Category)']) >0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	function checkIngredientTypeExists($typeName){
		$q = "SELECT COUNT(TypeName) From ". TBL_MAKES ." WHERE TypeName='$typeName'";
		$result = mysql_query($q, $this -> connection);	
		$result = (mysql_fetch_array($result));
		if(intval($result['COUNT(TypeName)']) >0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	function getNumDrinks(){
		$q = "SELECT Count(DrinkName) From ". TBL_DRINKS;
		$result =  mysql_query($q, $this -> connection);	
		$result = (mysql_fetch_array($result));
		return $result['Count(DrinkName)'];
	}
	function removeDrink($Name){
		$q = "DELETE FROM " .TBL_DRINKS ." WHERE DrinkName='$Name'";
		mysql_query($q, $this -> connection);
		$q = "DELETE FROM " .TBL_MAKES ." WHERE DrinkName='$Name'";
		return mysql_query($q, $this -> connection);
	}
	function getDrinksByCategory($category){
		$q = "SELECT * From ". TBL_DRINKS ." WHERE Category='$category' ORDER BY DrinkName";
		return mysql_query($q, $this -> connection);
	}
	function getDrinkByName($name){
		$q = "SELECT * From ". TBL_DRINKS ." WHERE DrinkName='$name'";
		return mysql_query($q, $this -> connection);
	}
	function getDrinksByIngredientType($typeName){
		$q = "SELECT DISTINCT m.TypeName, m.DrinkName, d.Rating, d.Difficulty, d.Category From ". TBL_MAKES .' m ,'.TBL_DRINKS." d WHERE d.DrinkName = m.DrinkName
AND m.TypeName = '$typeName'";
		return mysql_query($q, $this -> connection);
	}
	function addStore($Name,$Address,$Rating){
		$q = "INSERT INTO " .TBL_STORES ."(StoreName,Address,StoreRating) VALUES ('$Name','$Address',$Rating)";
		#echo $q;
		return mysql_query($q, $this -> connection);
	}
	function removeStore($Name){
		$q = "DELETE FROM " .TBL_STORES ." WHERE StoreName='$Name'";
		echo $q;
		return mysql_query($q, $this -> connection);
	}
	function getStores(){
		$q = "SELECT * From ". TBL_STORES;
		return mysql_query($q, $this -> connection);
	}
	
	function getIngredientTypes($drink){
		$q = "SELECT * FROM " . TBL_MAKES ." WHERE DrinkName = '$drink'";
		return mysql_query($q, $this -> connection);
	}
	function getIngredientTypesOrdered($drink){
		$q = "SELECT * FROM " . TBL_MAKES ." WHERE DrinkName = '$drink' ORDER BY TypeName";
		return mysql_query($q, $this -> connection);
	}
	function getAllIngredientTypesOrdered(){
		$q = "SELECT DISTINCT TypeName FROM " . TBL_MAKES ." ORDER BY TypeName";
		return mysql_query($q, $this -> connection);
	}
	function getAllAlcoholicIngredientTypesOrdered(){
		$q = "SELECT DISTINCT TypeName FROM " . TBL_MAKES ." WHERE Alcoholic=1 ORDER BY TypeName";
		return mysql_query($q, $this -> connection);
	}
	function getIngredientsSoldOrdered($store){
		$q = "SELECT * FROM " . TBL_SELLS ." WHERE StoreName = '$store' ORDER BY IngredientName";
		return mysql_query($q, $this -> connection);
		
	}
	function deleteRecipe($drink){
		$q = "DELETE FROM " .TBL_MAKES ." WHERE DrinkName='$drink'";
		return mysql_query($q, $this -> connection);
	}
	function addRecipe($drink,$type,$quantity){
		$q = "INSERT INTO " .TBL_MAKES ."(TypeName,Drinkname,Quantity) VALUES ('$type','$drink','$quantity')";
		//echo $q;
		//echo "<br>";
		return mysql_query($q, $this -> connection);
	}
	function addSold($ingred,$store,$price,$size){
		$q = "INSERT INTO " .TBL_SELLS ."(StoreName,IngredientName,Price,Size) VALUES ('$ingred','$store',$price,'$size')";
		echo $q;
                 return mysql_query($q, $this -> connection);
	}
	function deleteSold($store){
		$q = "DELETE FROM " .TBL_SELLS ." WHERE StoreName='$store'";
		#echo $q;
		return mysql_query($q, $this -> connection);
	}
	function deletePreferredDrink($user,$drink){
		$q = "DELETE FROM " .TBL_DRINKPREF ." WHERE DrinkName='$drink' AND UserName='$user'";
		return mysql_query($q, $this -> connection);
	}
	function addPreferredDrink($user,$drink){
		$q = "INSERT INTO " .TBL_DRINKPREF ." (UserName,DrinkName) VALUES ('$user','$drink')";
		//echo $q;
		//echo "<br>";
		return mysql_query($q, $this -> connection);
	}
	function getPreferredDrinks($user){
		$q = "SELECT * FROM " .TBL_DRINKPREF ." WHERE UserName='$user'";
		//echo $q;
		//echo "<br>";
		return mysql_query($q, $this -> connection);
	}
	function getAllBarsMapInfo(){
		$q = "SELECT * FROM ". TBL_BARS;
		return mysql_query($q,$this->connection);
	}
};

$database = new MySQLDB;
?>
