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
	start_template(array("css/margin.css"));

	// First section: User statistics
?>

<div class="container-fluid bg-1">
</div>

<form method="post" action="">

	<div class="form-group">
		<label for="deckName">Deck Name:</label>
		<input type="text" class="form-control" id="deckName" name="deckName">
	</div>

  <div class="form-group">
		<label for="description">Description:</label>
		<textarea class="form-control" rows="5" id="description" name="description" maxlength="500"></textarea>
	</div>

	<center><A type="submit" value="createDeck" class="btn btn-primary btn-lg">Create Deck</A></center>

	<br><br><br>
</form>



<?php
	end_template();
?>
