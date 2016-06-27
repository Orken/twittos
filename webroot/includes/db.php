<?php
	$hote="localhost";
	$login="root";
	$mdp="root";
	$nombd="twittos";
	
	// Connection au serveur
	try {
			$connexion = new PDO("mysql:host=$hote;dbname=$nombd", $login, $mdp);
			$req="SET NAMES utf8";
			$connexion->query($req) ;
		} catch ( Exception $e ) {
		  die ("\n Connection à '$hote' impossible :  ".$e->getMessage());
		}

?>