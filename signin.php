<?php

/** Preliminaries **/
//*****************************************************************************

// let's start a session
session_start();

// and include the template
require_once('includes/template.php');

//*****************************************************************************

/** Functions **/
//*****************************************************************************
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

function process_signin()
{
	$dbc = db_connect();

	if ($dbc == false) {
		show_forms('Error: unable to connect to user database.');
	}

	$userOrEmail = '';
		
	// check for an '@' sign in the input field. If one exists, assume what
	// they entered is an email
	if (strpos($_POST['user_or_email'], '@') === FALSE) {
		$userOrEmail = 'username';
	}
	else {
		$userOrEmail = 'email';
	}

	// Set up a prepared statement to check if the user name or email is 
	// contained in the database. If it is not, display an error.
	// Prepared statements are great for ensuring that SQL injection is near
	// impossible.
	$query = <<<MYSQL
	SELECT password, salt, username, email, user_type
	FROM qw_users a, qw_passwords b
	WHERE
		a.user_id = b.user_id AND
		$userOrEmail = :identifier
MYSQL;

	$stmt = $dbc->prepare($query);
	$stmt->bindParam(':identifier', $_POST['user_or_email']);

	$stmt->execute() or show_forms('Error: issue when querying database.');

	if ( $stmt->rowCount() == 0 ) {
		show_forms('Error: bad username or password.');
	}

	// If the script gets this far, the user name or email exists.
	// Hash the supplied password and check it against the one stored in the 
	// database. If they match, they entered the information correctly.
	// Otherwise, display an error.
	$row = $stmt->fetch();
	
	// We are done with the database now. Close the connection
	$stmt = NULL;
	$dbc = NULL;

	// let's compare the entered pass to the real one
	$enteredPass = hash('sha256', $row['salt'] . $_POST['password']);
	
	if ($enteredPass == $row['password']) {
		// set session variables to 'log user in'
		$_SESSION['username'] = $row['username'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['userType'] = $row['userType'];

		// all is well, take them back to the backpack page
		header('Location: backpack.php');	
	}
	else {
		show_forms('Error: bad username or password.');
	}
}

function process_create_user()
{
	// Connect to the database
	$dbc = db_connect();

	$fail = '';
	$desiredUsername = strtolower(htmlentities(strip_tags($_POST['des_username'])));
	$desiredEmail = strtolower(htmlentities(strip_tags($_POST['des_email'])));
	$desiredPass = htmlentities(strip_tags($_POST['des_pwd']));
	$desiredPass2 = htmlentities(strip_tags($_POST['des_pwd2']));
	$type = intval($_POST['type']);

	if ($dbc == false) {
		show_forms('', 'Error: unable to connect to the database.');
	}

	// Verify that the username doesn't exist
	$query = <<<MYSQL
	SELECT *
	FROM qw_users
	WHERE
		username = :name
	LIMIT 1
MYSQL;

	$stmt = $dbc->prepare($query);
	$stmt->bindParam(':name', $desiredUsername);
	
	$stmt->execute() or show_forms('', 'Error: issue when querying database.');
	
	if ($stmt->rowCount() > 0) {
		$fail .= 'That username already exists. Please try another.<br>';
	}

	// Verify that the email doesn't exist
	$query = <<<MYSQL
	SELECT *
	FROM qw_users
	WHERE
		email = :em
	LIMIT 1
MYSQL;

	$stmt = $dbc->prepare($query);
	$stmt->bindParam(':em', $_POST['des_email']);
	
	$stmt->execute() or show_forms('', 'Error: issue when querying database.');
	
	if ($stmt->rowCount() > 0) {
		$fail .= 'That email is already in use.<br>';
	}

	// Verify that the password is at least 4 characters long.
	if (strlen($desiredPass) < 4) {
		$fail .= 'Passwords must be at least 4 characters in length.<br>';
	}

	// Verify that the passwords match
	if ($desiredPass != $desiredPass2) {
		$fail .= 'Passwords must match.<br>';
	}

	// verify that the email is legal
	if (!filter_var($desiredEmail, FILTER_VALIDATE_EMAIL)) {
		$fail .= 'Please enter a valid email.<br>';
	}

	// verify that the username is legal
	if (!preg_match('/^\w+$/', $desiredUsername)) {
		$fail .= 'Usernames must consist only of alphanumeric characters.';
	}

	// check for failure
	if ($fail != '') {
		show_forms('', $fail);
	}

	// Insert user
	$query = <<<MYSQL
	INSERT INTO qw_users 
		(username, email, user_type)
	VALUES 
		(?, ?, ?)
MYSQL;
	$stmt = $dbc->prepare($query);
	$stmt->bindParam(1, $desiredUsername);
	$stmt->bindParam(2, $desiredEmail);
	$stmt->bindParam(3, $type);

	$stmt->execute() or show_forms('', 'Error: issue when querying database.');

	// Generate random salt
	$salt = md5(uniqid() . mt_rand() . microtime());	

	// Generate password 
	$pass = hash('sha256', $salt . $desiredPass);

	// Insert password
	$query = <<<MYSQL
	INSERT INTO qw_passwords 
		(user_id, password, salt)
	VALUES 
		( 
			(SELECT user_id FROM qw_users WHERE username = ? LIMIT 1),
			?, 
			?
		)
MYSQL;
	$stmt = $dbc->prepare($query);
	$stmt->bindParam(1, $desiredUsername);
	$stmt->bindParam(2, $pass);
	$stmt->bindParam(3, $salt);

	$stmt->execute() or show_forms('', 'Error: issue when querying database.');

	// set session variables to 'log user in'
	$_SESSION['username'] = $desiredUsername;
	$_SESSION['email'] = $desiredEmail;
	$_SESSION['userType'] = $type;

	// all is well, take them to the backpack page
	header('Location: backpack.php');
}

function show_forms($err1 = "", $err2 = "")
{
	$cssFiles = array();
	$cssFiles[] = 'css/signin.css';
	start_template($cssFiles);
	?>
	
	<div class="container-fluid bg-1">
		<div class="form_err" id="error1"><?php echo $err1; ?></div>
		<h2>Sign In Here</h2>
		<div id="signin_form">
			<form method="post" action="" accept-charset="UTF-8">
				<div class="form-group">
					<label for="user_or_email">Username or Email</label>
					<input type="text" class="form-control" id="user_or_email" 
						name="user_or_email" maxlength="255" required>
				</div>
				<div class="form-group">
					<label for="pwd">Password</label>
					<input type="password" class="form-control" id="pwd"
						name="password" maxlength="255" required>
				</div>
				<input type="hidden" name="signin" value="true">
				<input type="submit" value="Submit" class="btn btn-default">
			</form>
		</div>
	</div>

	<div class="container-fluid bg-2">
		<div class="form_err" id="error2"><?php echo $err2; ?></div>
		<h2>Don't have an account?</h2>
		<h3>
			No problem! Get access to hundreds of flashcards and quizzes
			generated by students and professors alike by creating an
			account below.
		</h3>
		<div id="signin_form">
			<form method="post" action="" accept-charset="UTF-8">
				<div class="form-group">
					<label for="des_username">Desired Username</label>
					<input type="text" class="form-control" id="des_username"
						name="des_username" maxlength="255">
				</div>
				<div class="form-group">
					<label for="des_email">Desired Email</label>
					<input type="text" class="form-control" id="des_email"
						name="des_email" maxlength="255">
				</div>
				<div class="form-group">
					<label for="">User Type</label>
					<div class="radio">
						<label>
							<input type="radio" name="type" value="0">
							Student
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="type" value="1">
							Teacher
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="des_pwd">Set Password</label>
					<input type="password" class="form-control" id="des_pwd"
						maxlength="255" name="des_pwd">
				</div>
				<div class="form-group">
					<label for="des_pwd2">Re-enter Password</label>
					<input type="password" class="form-control" id="des_pwd2"
						maxlength="255" name="des_pwd2">
				</div>
				<input type="hidden" name="create" value="true">
				<input type="submit" value="Submit" class="btn btn-default">
			</form>
		</div>
	</div>

	<?php
	end_template();
	exit;
}

//*****************************************************************************

/** Main Routine **/
//*****************************************************************************

// If they navigated to this page, but have already signed in, redirect them to
// home
if (isset($_SESSION['userId'])) {
	header('Location: index.php');
	exit;
}

// Call process_sign_in() if they filled out the sign in form. If they are
// attempting to create a user, call process_create_user(). Otherwise,
// simply display both forms.
if (isset($_POST['signin']) && $_POST['signin'] == 'true') {
	process_signin();
}
elseif (isset($_POST['create']) && $_POST['create'] == 'true') {
	process_create_user();
}
else {
	show_forms();
}

//*****************************************************************************
?>
