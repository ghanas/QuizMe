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
		  echo 'Error: unable to connect to user database.';
		}

		$result = $dbc->query("SELECT  QWD.deck_name 
				FROM qw_deck QWD, qw_users QWU, qw_subjects QWS 
				WHERE QWD.owner_id = QWU.user_id 
				AND QWD.subject_id = QWS.id
				AND QWS.subject_name = {$_SESSION['subject']}
				AND QWU.username = {$_SESSION['username']}");

		if ($result == false) {
			echo 'Error: invalid querey to retrieve decks names.';
		}

		if ($result->num_rows == 0)
		{
			echo "No decks available";
		}
		else
		{
			while($row = $result->fetch_assoc()){
				echo "<tr>
					<td>{$row['deck_name']} </td>
					<td><A type=\"button\" class=\"btn btn-danger btn-xs\"> Edit</A></td>
					<td><A type=\"button\" class=\"btn btn-success btn-xs\"> Run</A></td>
				</tr>";
			}
	}
	$dbc = null;
	?>
	</table>
</div>

<br><br><br>

<center><A href="deckCreation.php" type="button" class="btn btn-primary btn-lg">Create A Deck</A></center>
<br><br><br>
<center><A type="button" class="btn btn-primary btn-lg">Find A Deck</A></center>
<br><br><br>
<?php
end_template();
?>
