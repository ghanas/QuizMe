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
MYSQL;

	while ($row = $res->fetch_assoc()) {
	}
	?>
	<div class="row">
		<div class="col-md-4 text-centered">
			<a class="subj_btn" href="">
				Japanese
			</a>
		</div>
		<div class="col-md-4 text-centered">
			<a class="subj_btn" href="">
				Computer Science
			</a>
		</div>
		<div class="col-md-4 text-centered">
			<a class="subj_btn" href="">
				Electrical Engineering
			</a>
		</div>
	</div>
</div>

<?php

// end the template code

end_template();
//*****************************************************************************

?>
