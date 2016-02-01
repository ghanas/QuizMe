<?php

/** Preliminaries **/
//*****************************************************************************

// Include all other functions
require_once "includes/template.php";
require_once "includes/log.php";
require_once "includes/db_connect.php";

// Start a session.
session_start();

//*****************************************************************************

/** Functions **/
//*****************************************************************************
//*****************************************************************************

/** Main Routine **/
//*****************************************************************************

// Check that the user is logged in.
if (!is_logged_in()) {
	header("Location: signin.php");
}

// start the template
start_template();

// connect to the database
$dbc = db_connect();

// First section: User statistics
?>

<div class="container-fluid bg-1">
	<h2>Stats stuff will go here</h2>
	<h3>Blah, blah, blah.....</h3>
	<h3>Blah, blah, blah.....</h3>
</div>

<?php


// Second section: User subjects
?>

<div class="container-fluid bg-2">
	<h2>Your Subjects</h2>
	<?php
	$query = <<<MYSQL
	SELECT 
		b.subject_name, a.subj_id 
	FROM 
		qw_subj_user_rel a, qw_subjects b
	WHERE 
		a.subj_id = b.id AND
		user_id = (SELECT user_id FROM qw_users WHERE username = :name)
MYSQL;

	$stmt = $dbc->prepare($query);
	$stmt->bindParam(':name', $_SESSION['username']);
	$stmt->execute() or die('query broke');

	$counter = 0;
	echo '<div class="row">' . PHP_EOL;
	while ($row = $stmt->fetch()) {
		echo '<div class="col-md-4 text-centered">' . PHP_EOL;
		echo "<a class=\"subj_btn\" href=\"selectDecks.php?subj={$row['subj_id']}\">";
		echo "{$row['subject_name']}</a>" . PHP_EOL;
		echo '</div>' . PHP_EOL;
		$counter += 4;
		if ($counter == 12) {
			echo '</div>' . PHP_EOL; // close the row
			echo '<div class="row">' . PHP_EOL; // start a new one
			$counter = 0;
		}
	}
	echo '</div>' . PHP_EOL; // close the last row

	?>
	
</div>

<?php

// end the template code

end_template();
//*****************************************************************************

?>
