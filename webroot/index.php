<?php
	error_reporting(E_ALL);

	define('WEBROOT', dirname(__FILE__));
	define('ROOT',dirname(WEBROOT));
	define('DS',DIRECTORY_SEPARATOR);
	define('CORE',ROOT.DS.'core');
	define('BASE_URL', $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER['HTTP_HOST'] . str_replace('webroot/index.php', '', $_SERVER['SCRIPT_NAME']));
	define('CSS', BASE_URL . '/css/');
	define('JS', BASE_URL . '/js/');
	/*
	define('WEBROOT','/Twittos1/webroot');
	define('ROOT','/Twittos1');
	define('DS',DIRECTORY_SEPARATOR);
	define('CORE','/Twittos1/core');
	define('BASE_URL','/Twittos1');
	*/
	/*
	echo WEBROOT;
	echo "<br><br>";
	echo ROOT;
	echo "<br><br>";
	echo DS;
	echo "<br><br>";
	echo CORE;
	echo "<br><br>";
	echo BASE_URL;
	*/
	//print_r($_SERVER);die;
	require_once(CORE.'/includes.php');

	$disp = new Dispatcher();
?>
