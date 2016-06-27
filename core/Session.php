<?php

class Session{

	public function __construct(){
		if(!isset($_SESSION)){
			session_start();		
		}
	}

	/**
	 * Enregistre des messages dans le tableau 'flash' de la session en cours
	 */
	public function setFlash($message,$type = 'success'){
		$_SESSION['flash'] = array(
			'message' => $message,
			'type' => $type
		);
	}

	/**
	 * Affiche les messages stockés
	 */
	public function flash (){
		if (isset($_SESSION['flash']['message'])){
			$html = '<div class="alert alert-'.$_SESSION['flash']['type'].'"><p><center><strong>'.$_SESSION['flash']['message'].'</strong></center></p></div>';
			$_SESSION['flash'] = array();	// Pour que le message soit supprimé après avoir été effacé
			return $html;
		}

	}


	public function write($key, $value)
	{
 		$_SESSION[$key] = $value;
 	}


 	/**
 	 * Retourne la valeur stockée dans $_SESSION[$key] si une clé est demandée, sinon elle retourne $_SESSION entier.
 	 */
 	public function read($key=NULL)
 	{
 		if($key){
 			if(isset($_SESSION[$key])){
 				return $_SESSION[$key];
			}else{
				return false;
			}

 		}else{
 			return $_SESSION;
 		}

 	}


 	/**
 	 * Permet de savoir si l'utilisateur est connecté.
 	 */
 	public function isLogged()
 	{
 		return isset($_SESSION['Utilisateur']->pseudo); 
 	}

}