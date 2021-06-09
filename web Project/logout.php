

<?php
	
session_start();

session_unset(); // unset the data

session_destroy(); //Destroy the session;

header("Location: index.php ");

exit();