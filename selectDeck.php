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
	start_template(array("css/deckList.css"));

	// First section: User statistics
?>


<div class="container-fluid bg-1">
  <center><h2>Select A Deck</h2></center>
</div>

<div id="deckList">
	<table class="table">
	<?php

		//Get database connection
		$dbc = db_connect();
		if ($dbc == false) {
		  show_forms('Error: unable to connect to user database.');
		}

		$dbc->query("")


		<tr>
			<td>deck</td>
			<td><A type="button" class="btn btn-danger btn-xs"> Edit</A></td>
			<td><A type="button" class="btn btn-success btn-xs"> Run</A></td>
		</tr>
	?>
		<tr>
			<td>deck</td><td>edit</td><td>run</td>
		</tr>
	</table>
</div>

<br><br><br>

<center><A type="button" class="btn btn-primary btn-lg">Create A Deck</A></center>
<br><br><br>
<center><A type="button" class="btn btn-primary btn-lg">Find A Deck</A></center>
<br><br><br>
<?php
end_template();
?>
