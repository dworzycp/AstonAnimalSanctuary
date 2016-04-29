<?php session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Aston Animal Sanctuary - Home Page</title>
		
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
				  <li><a id="active" href="index.php">Home</a></li>
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
					  echo '<li><a href="login.php"><span class="fa fa-sign-in"></span> Login</a></li>';
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
			
			<!--BANNER-->
			<div class="hidden-xs" id="home_page_banner">
				<img class="img-responsive" src="images/h_p_banner.jpg" alt="Aston Animal Shelter - HELP US">
				<div id="home_page_banner_text">
					<h1>HELP US</h1>
					<p class="white_text">
						Here at Aston Animal Shelter we believe that every animal, no matter how small or disadvantaged deserves a loving home. Help us by providing that home for them.
					</p>
				</div>
			</div>
			
			<!--MAIN BODY-->
			<h2>About us</h2>
			<p>
				Aston Animal Shelter was founded in 2016 by animal lovers. We truly believe that every animal no matter its background or upbringing deserves to live in a loving environment.  
				We founded this shelter to allow fellow animal lovers to adopt and take care of their new family members with our help.
			</p><br/>
			
			<div class="row">
				<div class="col-md-8">
					<h2>Adopt</h2><hr>
					<div class="row">
						<div class="col-md-4">
							<h2>Dogs</h2>
							<img class="img-responsive" src="images/dogs.jpg" alt="Dogs">
						</div>
						<div class="col-md-4">
							<h2>Cats</h2>
							<img class="img-responsive" src="images/cats.jpg" alt="Cats">
						</div>
						<div class="col-md-4">
							<h2>Small Animals</h2>
							<img class="img-responsive" src="images/small_animals.jpg" alt="Small Animals">
						</div>
					</div><br/>
					<div class="row">
						<div class="col-md-4">
							<h2>Choosing</h2>
							<img class="img-responsive" src="images/choosing_a_pet.jpg" alt="Choosing a pet">
						</div>
						<div class="col-md-4">
							<h2>Adoption</h2>
							<img class="img-responsive" src="images/adoption.jpg" alt="Adoption">
						</div>
						<div class="col-md-4">
							<h2>Support</h2>
							<img class="img-responsive" src="images/support.jpg" alt="Support">
						</div>
					</div><br/>
				</div>
				<div class="col-md-4">
					<div class="col-md-12">
						<h2>eNewsletter</h2><hr>
						<p>Keep up-to-date with our latest news and animals still looking for a home.</p><br/>
						<!-- NOTE: THIS FORM DOESN'T DO ANYTHING, eNEWSLETTERS ARE NOT IMPLEMENTED -->
						 <form class="form-inline" role="form">
						  <div class="form-group">
							<input type="email" class="form-control" id="email" placeholder="Enter email">
						  </div>
						  <button type="button" class="btn btn-success">Sign up</button>
						</form><br/>
					</div>
					<div class="col-md-12">
						<h2>Pet Advice</h2><hr>
						<p>We provide practical advice for both new and existing pet owners.</p><br/>
					</div>
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