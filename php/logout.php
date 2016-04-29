<?php
#Start sessions
session_start();

#Kill all sessions
session_destroy();

#Redirect back to the home page
header("Location: ../index.php");

?>