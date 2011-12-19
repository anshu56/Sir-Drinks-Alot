<?
	include('database.php');
	$poll_id = $_GET['pollId'];
	unset($_GET['pollId']);
	$database -> query("INSERT INTO Polls(poll_id) VALUES ($poll_id)");
	foreach ($_GET as &$value) {
		$q="INSERT INTO PollOptions(poll_id,title) VALUES ($poll_id,'$value')";
		echo $q;
		$database -> query($q);
	}
?>
