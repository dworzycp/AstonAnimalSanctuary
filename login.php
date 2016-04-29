<?php

session_start();

#Connect to the database
include 'php/db_connect.php';

if(isset($_POST['submitted'])){
	#Set varaibles
	$username = $_POST['username'];
	$password = $_POST['password'];

	#Select the user
	$query = $db->prepare("SELECT * FROM cs2410.user WHERE userID = '$username'");
	$query->execute();
	$row = $query->fetch(PDO::FETCH_ASSOC);

	#Hash the password to be able to comapre it with the one in the database
	$hash = md5($password);

	if($hash == $row['password']){
		#Sessions
		$_SESSION['username'] = $username;
		
		if($row['staff'] == 1){
			#Session
			$_SESSION['staff'] = 'true';
			#Redirect
			header("Location: user_area_staff.php");
		} else{
			#Session
			$_SESSION['staff'] = 'false';
			#Redirect
			header("Location: user_area_normal.php");
		}
	} else{
		$_SESSION['error'] = "Incorrect password and/or username";
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Aston Animal Sanctuary - Login</title>
		
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Link external documents -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

		<!-- Scripts -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container" id="page">
			<!--HEADER-->
			<div id="header">
				<img src="images/logo.png" src="index.php" alt="Aston Animal Sanctuary Logo">
			</div>
			
			<!--NAV BAR-->		
			 <nav class="navbar navbar-inverse" id="nav_bar">
			  <div class="container-fluid">
				<ul class="nav navbar-nav">
				  <li><a href="index.php">Home</a></li>
				  <?php
				    #If the user is logged in show them a link to appropriate pages
					#No need to check if the 'staff' session exists as it's created at the same time as the 'username' session
					if(isset($_SESSION['username']) && $_SESSION['staff'] == 'true'){
						echo '<li><a href="user_area_staff.php">User area</a></li>';
						echo '<li><a href="animals.php">Animals</a></li>';
						#If the user is staff then show them a link to add an animal
						echo '<li><a href="add_animal.php">Add animal</a></li>';
					} else if(isset($_SESSION['username']) && $_SESSION['staff'] == 'false') {
						echo '<li><a href="user_area_normal.php">User area</a></li>';
						echo '<li><a href="animals.php">Animals</a></li>';
					}
				  ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				  <?php
					#Check if the user is logged in
					#If the user is logged in, don't show a link to register nor log in
					#Instead welcome the user and allow them to sign out
					if(!isset($_SESSION['username'])) {
					  echo '<li><a href="register.php"><span class="fa fa-user"></span> Sign Up</a></li>';
					  echo '<li><a id="active" href="login.php"><span class="fa fa-sign-in"></span> Login</a></li>';
					} else {
						echo '<li><a href="#">Hello ';
						echo $_SESSION['username'];
						echo '</a></li>';
						echo '<li><a href="php/logout.php"><span class="fa fa-sign-out"></span> Log out</a></li>';
					}
				  ?>
				</ul>
			  </div>
			</nav>

			<!--MAIN BODY-->
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
				<h2>Login</h2><br/>
					<!-- Error message -->
					<?php
						if(isset($_SESSION['error'])){ 
							echo '<div class="alert alert-danger">';
							echo '<p>';
							echo $_SESSION['error'];
							echo '</p>';
							echo '</div>';
							#Reset the error after displaying
							$_SESSION['error'] = null;
						}
					?>
					<form method="POST" action="login.php">
					  <div class="form-group row">
						<label for="username" class="col-sm-2 form-control-label">Username</label>
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
						</div>
					  </div>
					  <div class="form-group row">
						<label for="password" class="col-sm-2 form-control-label">Password</label>
						<div class="col-sm-10">
						  <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
						</div>
					  </div>
					  <input type="hidden" name="submitted" value="true"/>
					  <div class="form-group row">
						<div class="col-sm-offset-2 col-sm-10">
						  <button type="submit" class="btn btn-secondary">Log in</button>
						</div>
					  </div>
					</form>
					<p>If you don't have an account please <a href="users_register.php">Register here</a></p><br/>
				</div>
			</div>
			
			<!--FOOTER-->
			<div class="row" id="footer">
				<div class="col-md-2"></div>
				<div class="col-md-3">
					<h3>ABOUT US</h3>
					<p>
						Aston Animal Shelter is a Birmingham based charity providing shelter and adoption services in the local area.
					</p>
				</div>
				<div class="col-md-3">
					<h3>SOCIAL MEDIA</h3>
					<p>
						<i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook<br/>
						<i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter<br/>
						<i class="fa fa-instagram" aria-hidden="true"></i> Instagarm<br/>
					</p>
				</div>
				<div class="col-md-3">
				<h3>CONTACT</h3>
					<p>
						Aston Express Way<br/>
						Birmingham<br/>
						B4 7ET<br/><br/>
						<i class="fa fa-phone" aria-hidden="true"></i> 0121 204 3000
					</p>
				</div>
				<div class="col-md-2"></div>
			</div>
			<div class="row" id="footer"><br/><p>© 2016. Aston Animal Shelter. Website created by: Pawel Dworzycki</p></div>
		</div>		
	</body>
</html>