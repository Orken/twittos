<?php

function debug($var, $nom = 'N/A',$dead = NULL)
{
	//Possibilité de l'ameliorer dans vidéo n°4 à ~30minutes
	
	echo '<pre>';
		echo '<u>Print_r de '.$nom.' :</u> <br>';
		print_r($var);
	echo '</pre>';

	if($dead == true){
		die();
	}
}
