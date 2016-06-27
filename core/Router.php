<?php
class Router{

	/**
	* Permet de parser une url
	* @param $url Url a parser
	* @return tableau contenant les parametres
	**/
	static function parse ($url,$request){
		$url = trim($url,'/');
		$params = explode('/',$url);
		$request->controller = $params[0] ?: 'textes';
		$request->action = isset($params[1]) ? $params[1] : 'index';
		$request->params = array_slice($params,2);

		return true;
	}


	/**
	 * Permet de ne pas avoir a taper tout le chemin d'accès pour les fichiers dans webroot
	 */
	static function webroot($url){

		// Supprime les '/' e n debut et fin de chaîne
		trim($url,'/');
		
		return BASE_URL.'/'.$url;
	}





}