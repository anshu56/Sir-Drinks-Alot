<?
function showPoll($poll_id = NULL) {
	global $username;

	if(is_null($poll_id)) {
		$poll_id = (int)$_GET['poll_id'];
	}

	$get_poll = mysql_query("SELECT * FROM Polls WHERE poll_id = $poll_id LIMIT 1")or die(mysql_error());
	$poll = mysql_fetch_assoc($get_poll);

	if(empty($poll)) { //poll not found?
		die("Poll not found.");
	}

	$poll_name = $poll['title'];
	$poll_question = $poll['question'];

	echo "<h5>{$poll_name} </h5>";
	echo $poll_question." <br />";
	if($_POST['vote']) {

		
		
		$option_id = (int)$_POST['answer_id'];

		if($option_id <= 0) {
			die("<p>Invalid answer.</p>");
		}

		$check_double = mysql_query("SELECT * FROM PollVotes WHERE username = '$username' AND poll_id = '$poll_id' "); //check user already voted for this poll

		if(mysql_num_rows($check_double) > 0) { //already voted for this poll?
			echo "<p>Sorry, you may only vote ONCE for a poll.</p>";
		}else{
			$vote = mysql_query("INSERT INTO PollVotes(vote_id, poll_id, option_id, username)VALUES('$ip', '$poll_id', '$option_id', '$username')");
			if($vote) {
				echo "<p>Successfully voted!</p>";
			}else{
			echo "<p>Error occured.</p>";
			}
		}

	}
	if($_POST['vote'] || $_GET['showResults'] == 1) {
		$get_votes = mysql_query("SELECT * FROM PollVotes WHERE poll_id = '$poll_id' "); //select all votes to this poll
		$votes = array(); //the array that will be containing all votes ( we add them as we retrieve them in a while loop )
		$total_votes = 0;

		while($vote = mysql_fetch_assoc($get_votes)) { //retrieve them
			$option_id = $vote['option_id'];
			$votes[$option_id] = (int)$votes[$option_id]+1; //add 1 vote for this particulair answer
			$total_votes++;
		}

		//now loop through the answers and get their corresponding amount of votes from $votes[id_of_answer]

		$get_answers = mysql_query("SELECT * FROM PollOptions WHERE poll_id = '$poll_id' ");

		while($answer = mysql_fetch_assoc($get_answers)) { //loop through all answers this poll has

			$poll_id1 = $answer['id']; //the id of the answer -> the amount of votes for each answer we stored in $votes[id_of_answer] so for this id it would be 	$votes[$poll_id]
			$width = round((int)$votes[$poll_id1]/$total_votes*299+1); //400px = max, 100% of votes

			echo "<p>".$answer['answer']." (".(int)$votes[$poll_id1]." vote".((int)$votes[$poll_id1] != 1 ? "s":"").")<br /> <div style='background-color: #BABABA; width: {$width} px; height: 15px;'> </div> </p>";
		}
		echo "<a href='".$_SERVER['PHP_SELF']."?poll_id=".$_GET['poll_id']."'>[Show Poll]</a>";
	}else{

		$get_answers = mysql_query("SELECT * FROM PollOptions WHERE poll_id = $poll_id ");
		echo "<form method='POST' action='".$_SERVER['PHP_SELF']."?poll_id=".$_GET['poll_id']."'>";
		while($answer = mysql_fetch_assoc($get_answers)) { //loop through all answers this poll has
			echo "<input type='radio' name='answer_id' value='".$answer['id']."'>".$answer['title']." <br />";
		}
		echo "<input type='submit' name='vote' value='Vote!' />";
		echo "</form>";
		echo "<a href='".$_SERVER['PHP_SELF']."?poll_id=".$_GET['poll_id']."&showResults=1'>[Show Results]</a>";

	}

	

}


?>
