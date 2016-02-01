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
  <center><h2>Deck Creation</h2></center>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="front">Front:</label>
			<textarea class="form-control" rows="5" id="front"></textarea>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="back">Back:</label>
			<textarea class="form-control" rows="5" id="back"></textarea>
	</div>
	</div>
</div>

<center><A type="button" class="btn btn-primary btn-lg">Add Card</A></center>



<div class="container-fluid bg-2">

<table>
	<tr>
		<td>number</td><td>front side</td><td>back side</td>
	</tr>
</table>
</div>


<center><A type="button" class="btn btn-primary btn-lg">Add Deck</A></center>
<br><br><br>

<?php
	end_template();
?>
