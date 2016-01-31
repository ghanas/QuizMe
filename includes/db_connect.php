<?php

function db_connect()
{
	// this user needs to be more generic. For the time being, my user will
	// do
	$dbc = new PDO(	'mysql:host=dbs.eecs.utk.edu;dbname=sbradfo5', 
					'sbradfo5', 
					'youCantHaveMyRealPass' );

	if ($dbc) {
		return $dbc;
	}
	else {
		return false;
	}
}

?>
