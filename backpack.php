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
	<div class="row">
		<div class="col-md-4 text-centered">
			<button class="btn btn-lg bordered-1">
				<h3>Japanese</h3>
			</button>
		</div>
		<div class="col-md-4 text-centered">
			<button class="btn btn-lg bordered-1">
				<h3>Computer Science</h3>
			</button>
		</div>
		<div class="col-md-4 text-centered">
			<button class="btn btn-lg bordered-1">
				<h3>Electrical Engineering</h3>
			</button>
		</div>
	</div>
</div>

<?php

// end the template code

end_template();
//*****************************************************************************

?>
