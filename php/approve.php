<?php

#Start sessions
session_start();

#Check if the form has been submitted
if(isset($_POST['submitted'])){
	
	#Connect to the database
	include 'db_connect.php';
	
	#Set up variables
	$adoptionID = $_POST['adoptionID'];
	$approve = $_POST['approve'];
	$animalID = $_POST['animalID'];
	$animal_owner = $_POST['userID'];

	#Check if the staff's decision
	if($approve == 'true'){
		#The staff approved the adoption
		#Update the database's record to 1 meaning approved
		$db->exec("UPDATE cs2410.adoptionrequest SET approved = 1 WHERE adoptionID = '$adoptionID'");
		
		#Add a record to the 'owns' table in the database
		$db->exec("INSERT INTO cs2410.owns (`userID`, `animalID`) VALUES ('$animal_owner', '$animalID')");
	} else {
		#The staff denied the adoption
		#Update the database's record to 0 meaning denied
		$db->exec("UPDATE cs2410.adoptionrequest SET approved = 0 WHERE adoptionID = '$adoptionID'");
		
		#When denied the animal can be adopted again
		#Set the animal's availability back to 1
		$db->exec("UPDATE cs2410.animal SET available = 1 WHERE animalID = '$animalID'");
	}
}

#Redirect back to the staff page
header ("Location: ../user_area_staff.php");

?>