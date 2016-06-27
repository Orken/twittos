<?php
class PagesController extends Controller{


	function view($id) {
		$this->loadModel('Texte');
		$texte = $this->Texte->findFirst(array(
			'conditions' => 'id='.$id			// /!\ Voir Partie 3 à 35m 20s pour amelioration requetes (qui ne marchaient pas à cause de mysqli_real_escape_string)
		));
		if(empty($texte)){
			$this->e404('Page introuvable');
		}
		$this->set('texte',$texte);
	}

	public function snake()
	{
		
	}

	public function pong()
	{
		
	}

}