<?php

/**
 * Dispatcher
 * Permet de charger le controller en fonction de la requete utilisateur
 */
class Dispatcher{

	var $request;

	/**
	 * Fonction principale du dispatcher
	 * Charge le controller en fonction du routing
	 */
	function __construct(){
		$this->request = new Request();
		Router::parse($this->request->url,$this->request);
		$controller = $this->loadController();
		if(!in_array($this->request->action , array_diff(get_class_methods($controller), get_class_methods('Controller')))){
			$this->error('<hr/>Le controller '.$this->request->controller.' n\'a pas de méthode '.$this->request->action);
		}
		call_user_func_array(array($controller,$this->request->action),$this->request->params);
		$controller->render($this->request->action);
	}


	/**
	 * Permet de générer une page d'erreur en cas de problème au niveau du routing (page inexistante)
	 */
	function error($message){
		$controller = new Controller($this->request);
		$controller->e404($message);
	}


	/**
	 * Permet de charger le controleur en fonction de la requete utilisateur
	 */
	function loadController(){
		$name = ucfirst($this->request->controller).'Controller';
		$file = ROOT.DS.'controller'.DS.$name.'.php';
		if(!file_exists($file)){
			$this->error('Le controller '.$this->request->controller.' n\'existe pas.');
		}
		require $file;
		$controller = new $name($this->request);

		return $controller;
	}


}