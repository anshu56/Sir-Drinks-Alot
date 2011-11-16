<?
include ("sessions.php");
class Process {
	function Process() {
		global $session;
		/* User submitted login form */
		if (isset($_POST['sublogin'])) {
			$this -> procLogin();
		}
		/* User submitted registration form */
		else if (isset($_POST['subjoin'])) {
			$this -> procRegister();
		}
		/* User submitted forgot password form */
		else if (isset($_POST['subforgot'])) {
			$this -> procForgotPass();
		}
		/* User submitted edit account form */
		else if (isset($_POST['subedit'])) {
			$this -> procEditAccount();
		}
		else if (isset($_POST['subaddingredient'])) {
			$this -> procAddIngredient();
		}
		else if(isset($_POST['subadddrink'])){
			$this -> procAddDrink();
		}
		else if(isset($_POST['subaddstore'])){
			$this -> procAddStore();
		}
		/**
		 * The only other reason user should be directed here
		 * is if he wants to logout, which means user is
		 * logged in currently.
		 */
		else if ($session -> logged_in) {
			$this -> procLogout();
		}
		/**
		 * Should not get here, which means user is viewing this page
		 * by mistake and therefore is redirected.
		 */
		else {
			header("Location: main.php");
		}
	}

	/**
	 * procLogin - Processes the user submitted login form, if errors
	 * are found, the user is redirected to correct the information,
	 * if not, the user is effectively logged in to the system.
	 */
	function procLogin() {
		global $session, $form;
		/* Login attempt */
		$retval = $session -> login($_POST['user'], $_POST['pass'], isset($_POST['remember']));

		/* Login successful */
		if ($retval) {
			header("Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot");
		}
		/* Login failed */
		else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form -> getErrorArray();
			print_r($form -> getErrorArray());
			//header("Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot");
		}
	}

	/**
	 * procLogout - Simply attempts to log the user out of the system
	 * given that there is no logout form to process.
	 */
	function procLogout() {
		global $session;
		$retval = $session -> logout();
		header('Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot');
	}

	function procRegister() {
		global $session, $form;
		/* Convert username to all lowercase (by option) */
		if (ALL_LOWERCASE) {
			$_POST['user'] = strtolower($_POST['user']);
		}
		/* Registration attempt */
		$retval = $session -> register($_POST['user'], $_POST['pass'], $_POST['name'], $_POST['age'], $_POST['gender'], $_POST['location'], $_POST['email']);
		/* Registration Successful */
		if ($retval == 0) {
			$_SESSION['reguname'] = $_POST['user'];
			$_SESSION['regsuccess'] = true;
			header("Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot");
		}
		/* Error found with form */
		else if ($retval == 1) {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form -> getErrorArray();
			echo count($form -> getErrorArray());
			print_r($form -> getErrorArray());
			header("Location: " . $session -> referrer);
		}
		/* Registration attempt failed */
		else if ($retval == 2) {
			$_SESSION['reguname'] = $_POST['user'];
			$_SESSION['regsuccess'] = false;
			header("Location: " . $session -> referrer);
		}

	}
	function procAddIngredient(){
		global $database;
		$retval = $database->addIngredient($_POST['ingredientname'],$_POST['type'],$_POST['proof']);
		if($retval){
			header("Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot/maintenance.php");
		}
		else{
			echo "ERROR";
		}
	}
	function procAddDrink(){
		global $database;
		$retval = $database->addDrink($_POST['drinkname'],$_POST['rating'],$_POST['difficulty'],$_POST['category'],$_POST['recipe']);
		if($retval){
			header("Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot/maintenance.php");
		}
		else{
			echo "ERROR";
		}		
	}
	function procAddStore(){
		global $database;
		$retval = $database->addStore($_POST['storename'],$_POST['storeaddress'],$_POST['storerating']);
		if($retval){
			header("Location: http://rustagi1.projects.cs.illinois.edu/DrinksAlot/maintenance.php");
		}
		else{
			echo "ERROR";
		}
	}
}

$process = new Process;
?>
