<?php

#Start sessions
session_start();

#Check if the form has been submitted
if(isset($_POST['submitted'])){
	
	#Create variables
	$userID = "";
	$animalID = "";
	
	#Neither userID nor animalID can be empty at this stage
	#Also since they're both taken from the database, there should be no need to protect from injections
	$userID = $_SESSION['username'];
	$animalID = $_POST['animalID'];
	
	#Connect to the database
	include 'db_connect.php';
	
	#Insert reuqest for adoption into the database
	#2 in the `approved` field represents pending approval; 0 - denied, 1 - approved
	$db->exec("INSERT INTO cs2410.adoptionrequest (`userID`, `animalID`, `approved`) VALUES ('$userID', '$animalID', 2)");
	
	#While pending approval no other user can request to adopt the same animal
	#2 means that the animals has been requested to be adopted, the animal will no longer appear to normal users on the animals page
	$db->exec("UPDATE cs2410.animal SET available = 2 WHERE animalID = $animalID");
	
	header ("Location: ../animals.php");
	
} else{
	#If the form hasn't been submitted, redirect back to the previous page
	header ("Location: ../animals.php");
}

?>