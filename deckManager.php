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
function addCard()
{
	//Get database connection
	$dbc = db_connect();
	if ($dbc == false) {
		echo 'Error: unable to connect to user database.';
	}

	$stmt = $dbc->prepare("INSERT INTO qw_flash_cards (front, back)
			VALUES(:front, :back)");

	// check stmt
	if (!$stmt) {
		echo 'Unable to add card.';
	}

	$front = htmlentities(strip_tags($_POST['front']));
	$back = htmlentities(strip_tags($_POST['back']));

	$stmt->bindParam(':front', $front);
	$stmt->bindParam(':back', $back);
	$stmt->execute() or die('query is broke');

	$dbc = null;
}


function displayCards()
{
	//Get database connection
	$dbc = db_connect();
	if ($dbc == false) {
		echo 'Error: unable to connect to user database.';
	}
	

	$dbc = null;


}






/** Main Routine **/
//*****************************************************************************

// Check that the user is logged in.
	if (!is_logged_in()) {
		header("Location: signin.php");
	}

	// start the template
	start_template(array("css/margin.css", "css/deckList"));
	if (isset($_POST['processCard']) && $_POST['processCard'] == "true") {
		addCard();
	}
	
	// First section: User statistics
?>


<!-- Create the two text areas representing the two sides-->
<!-- of a flash card.-->
<div class="container-fluid bg-1">
  <center><h2>Deck Creation</h2></center>
</div>


<form method="post" action="">

	<div class="form-group">
	  <div class="text-centered">
			<label for="deckName">Deck Name:</label>
			<input type="text" class="form-control" id="deckName" name="deckName">
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="front">Front:</label>
				<textarea class="form-control" rows="5" id="front" name="front" maxlength="500"></textarea>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="back">Back:</label>
				<textarea class="form-control" rows="5" id="back" name="back" maxlength="500"></textarea>
			</div>
		</div>
	</div>
	<input type="hidden" name="processCard" value="true" />
	<center><A type="submit" value="Add Card" class="btn btn-primary btn-lg">Add Card</A></center>
</form>







<!--Display a table of flashcards that are currently in the deck being created.-->
<div class="container-fluid bg-2"> 
	<div id="deckList">
	<table class="table">
		<tr>
			<td>number</td><td>front side</td><td>back side</td>
		</tr>
	</table>
	</div>

	<center><A type="button" class="btn btn-primary btn-lg">Add Deck</A></center>
	<br><br><br>
</div>

<?php
	end_template();
?>
