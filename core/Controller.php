<?php
/**
* Controller
**/
class Controller{

	public $request;
	private $vars = array();
	public $layout = 'default';
	private $rendered = false;
	protected $auth = [];
	protected $render = true;

	function isAuthorized() {
		return (in_array($this->request->action,$this->auth));
	}

	/**
	* Constructeur
	* @param $request Objet request de notre application
	**/
	function __construct($request = null){

		$this->Session = new Session();
		$this->Form = new Form($this);


		if($request){
			$this->request = $request;
			if (!$this->Session->isLogged() && !$this->isAuthorized()) {
				require ROOT.DS.'config'.DS.'hook.php';
			}
		}
	}

	/**
	 * Permet de rendre une vue
	 * @param $view Fichier à rendre (chemin depuis view ou nom de la vue)
	 */
	public function render($view){
		if($this->rendered){
			return false;
		}

		extract($this->vars);

		// Si il y a un / au début
		if(strpos($view,'/')===0){
			$view = ROOT.DS.'view'.$view.'.php';
		}
		else{
			$view = ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';
		}

		if ( $this->render ) {
			ob_start();
			require($view);
			$content_for_layout = ob_get_clean();
			require ROOT.DS.'view'.DS.'layout'.DS.$this->layout.'.php';
		}
		$this->rendered = true;
	}


	/**
	 * Permet de passer une ou plusieurs variables à la vue
	 * @param $key Nom de la variable OU du tableau de variables
	 * @param $value Valeur de la variable (facultatif)
	 */
	public function set ($key,$value=null){
		if(is_array($key)){
			$this->vars += $key;
		}
		else{
			$this->vars[$key] = $value;
		}
	}


	/**
	 * Permet de charger un model au niveau du controller
	 * @param $name Le nom du model à charger
	 */
	function loadModel($name){

		$file = ROOT.DS.'model'.DS.$name.'.php';
		/*echo 'contenu de $file : '.$file;
		die();*/
		require_once($file);
		if(!isset($this->$name)){
			$this->$name = new $name();
		}
	}

	/**
	 * Permet de gerer les erreurs 404
	 */
	function e404($message){
		header("HTTP/1.0 404 Not Found");
		$this->set('message', $message);
		$this->render('/errors/404');
		die();
	}


	/**
	 * Header Location version simplifié
	 */
	public function redirect($url)
	{
		header('Location: '.BASE_URL.$url);
	}


}