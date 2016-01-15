<?php

function start_template() 
{
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
	<title>QuizMe</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/template.css">
	</head>
	<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button 
					type="button" 
					class="navbar-toggle" 
					data-toggle="collapse" 
					data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">QM</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="backpack.php">Backpack</a></li>
					<li><a href="flashcards.php">Flash Cards</a></li>
					<li><a href="portfolio.php">Quizzes</a></li>
					<li><a href="studyguides.php">Study Guides</a></li>
					<li><a href="signin.php">Sign In</a></li>
				</ul>
			</div>
		</div>
	</nav>
<?php
}

function end_template()
{
?>
	<footer class="container-fluid bg-blue white-text text-center">
		<h1>QuizMe</h1>
	</footer>
	<script src="js/jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	</body>
	</html>
<?php
}

?>
