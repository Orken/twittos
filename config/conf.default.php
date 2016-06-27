<?php

class Conf{

	static $debug = 1;



	// @param $databases Un tableau de une ou plusieurs BDD, default etant la bdd par defaut. Chaque BDD du tableau est un tableau associatif contenant les informations pour se co à la BDD
	static $databases = array
	(
		'default' => array
		(
			'host'			=> '',
			'database'	=> '',
			'login'			=> '',
			'password'	=> ''
		)
	);


}


