<?php
#Start sessions
session_start();

#Check to see if the user is logged in
if(isset($_SESSION['username'])){
	#Do nothing
} else{
	#If the user isn't logged in, go to the login page
	header ("Location: login.php");
}

#Connect to the database
include 'php/db_connect.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Aston Animal Sanctuary - Animals</title>
		
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
						echo '<li><a id="active" href="animals.php">Animals</a></li>';
						#If the user is staff then show them a link to add an animal
						echo '<li><a href="add_animal.php">Add animal</a></li>';
					} else if(isset($_SESSION['username']) && $_SESSION['staff'] == 'false') {
						echo '<li><a href="user_area_normal.php">User area</a></li>';
						echo '<li><a id="active" href="animals.php">Animals</a></li>';
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

			<!--MAIN BODY-->
			<h1>Animals</h1>
			<div class="row">
				<div class="col-md-2"><p>Photo</p></div>
				<div class="col-md-2"><p>Name</p></div>
				<div class="col-md-2"><p>Date of Birth</p></div>
				<div class="col-md-2"><p>Description</p></div>
				<div class="col-md-2"><p>Type</p></div>
				<div class="col-md-2"><p>Options</p></div>
			</div>
			<?php
				if($_SESSION['staff'] == 'true'){
					#Display ALL animals to staff
					$sql = "SELECT * FROM cs2410.animal";
				} else{
					#Only display animals which can be adopted to non-staff users
					#1 means that an animal is available for adoption
					$sql = "SELECT * FROM cs2410.animal WHERE available = 1";
				}
				
				$result = $db->query($sql);
				
				#Loop through all of the animals and add them to the table
				foreach($result as $row){
					$animalID = $row['animalID'];
					echo "<div class='row'>";
					echo "<div class='col-md-2'>" . "<img src=".$row['photo']." alt='Photo' height='50' width='50'>" . "</div>";
					echo "<div class='col-md-2'>" . $row['name'] . "</div>";
					echo "<div class='col-md-2'>" . $row['dateofbirth'] . "</div>";
					echo "<div class='col-md-2'>" . $row['description'] . "</div>";
					echo "<div class='col-md-2'>" . $row['type'] . "</div>";
					#Only non-staff can adopt animals, so check to make sure that the user is non-staff
					if($_SESSION['staff'] == 'false'){
						echo "<div class='col-md-2'>
							 <form method='POST' action='php/adopt.php'>
							 <input type='hidden' name='animalID' value='$animalID'/>
							 <input type='hidden' name='submitted' value='true'/>
							 <button type='submit' class='btn btn-success'>Adopt</button></form></div></div>";
					} else if ($_SESSION['staff'] == 'true'){
						echo '</div>';
					}
					echo "<br/>";
				}
			?><br/>
			
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