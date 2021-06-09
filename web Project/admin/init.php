<?php

	// Routes
	
	include 'connect.php'; // connect to database

	$tpl= 'includes/templats/'; //templates dir

	$css = 'layout/css/'; // css dir

	$js = 'layout/js/'; // js dir

	$func = 'includes/functions/';
	
	// include  files


	include $func .'function.php';

	include $tpl .'header.php';

	// include Navbar on All pages expect the one with nonav 
	if(!isset($nonav)) {include $tpl .'navbar.php';}


	
	
	

	