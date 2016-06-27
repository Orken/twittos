<?php
class TextesController extends Controller{

	public function __construct($request = null) {
		parent::__construct($request);
		$this->loadModel('Texte');
	}
	
	/**
	 * Permet de selectionner les articles affichés par page
	 */
	public function index(){
		$perPage = 20; 	// Défini le nombre de Textes affichés par page
		// $this->loadModel('Texte');
		$condition = 'id >= 1';
		$orderby = 'dateTexte';
		$d['textes'] = $this->Texte->find(array(
			'conditions' => $condition,
			'orderby'	   => $orderby,
			'limit'	   => ($perPage*($this->request->page-1)).','.$perPage
		)); //permet de changer les pages, on met -1 pour obtenir l'article avec l'ID = 0 en premier
		$d['total'] = $this->Texte->findCount($condition);
		$d['page'] = ceil($d['total'] / $perPage);
		$this->set($d);
	}


	public function view($id) {
		
		$d['textes'] = $this->Texte->getById($id);
		if(empty($d['textes'])){
			$this->e404('Page introuvable');
		}

		$comments = $this->Texte->listeCommentaire($id);

		// On a besoin d'envoyer à la vue les commentaires.
		$this->set('comments', $comments);
		
		$this->set($d);
	}


	/**
	 * Permet d'éditer ou de créer un article
	 */
	public function text_edit($id = null)
	{
		// $this->loadModel('Texte');
		$d['id'] = '';

		if($this->request->data)
		{
			if(!empty($this->request->data->id))
			{
				
				// On verifie que l'utilisateur voulant editer le message soit celui qui l'a écrit.
				if($this->Texte->verifieProprio($this->request->data->id))
				{
					// Cette ligne va permettre de placer les balises iframe/embed lorsqu'on colle simplement une video
					$this->request->data->leTexte = preg_replace('#https://www.youtube.com/watch\?v=([a-z0-9A-Z_-]+)+#i', '<center><iframe width="560" height="314" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe></center>', $this->request->data->leTexte);
					
					$this->Texte->save($this->request->data);
					$id = $this->Texte->id;	
				}
			
			// On crée un nouveau message
			}else
			{
				// Cette ligne va permettre de placer les balises iframe/embed lorsqu'on colle simplement une video
				$this->request->data->leTexte = preg_replace('#https://www.youtube.com/watch\?v=([a-z0-9A-Z_-]+)+#i', '<center><iframe width="560" height="314" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe></center>', $this->request->data->leTexte);

				$this->Texte->saveNew($this->request->data);
				$id = $this->Texte->id;
			}

			// $this->Session->setFlash('Le contenu a bien été modifié.'); −> utile slmt si on reste sur la page d'edition.

			// Apres l'enregistrement de la modification ou de l'insertion, on redirige vers la vue correspondante au texte.
			$this->redirect('/textes/view/'.$id);
		}
		if($id)
		{
			$this->request->data = $this->Texte->findFirst(array(
				'conditions' => array('id' => $id)
			));
			$d['id'] = $id;
		}
		$this->set($d);		
	}


	/**
	 * Permet d'écrire un commentaire
	 */
	public function comment($id)
	{
		if($this->request->data)
		{
			$this->Texte->saveComment($this->request->data, $this->request->params[0]);
			$this->redirect('/textes/view/'.$this->request->params[0]);
		}
	}



	/**
	 * Permet de supprimer un article
	 */
	public function proprio_delete($id)
	{
		$this->render = false;
		// $this->loadModel('Texte');
		$this->Texte->delete($id);
		$this->Session->setFlash('Le contenu a bien été supprimé','success');
		$this->redirect('/textes');
	}


	/**
	 * Permet de supprimer un commentaire
	 */
	public function proprio_delete_com($id_com)
	{
		$this->Texte->delete_com($id_com);
		$this->Session->setFlash('Votre commentaire a bien été supprimé','success');
		$this->redirect('/textes/view/'.$_SESSION['idDuTexte']);	
	}


	public function search()
	{
		
	}

	public function actionSearch() {
		$this->render = false;
		$i = 0;
		//$this->loadModel('')
		$result = $this->Texte->trouveRecherche();
		echo '<hr>';
	    	// parcours et affichage des résultats
	    	while($i < count($result))
	    	{
	    		echo '<div class="jumbotron"><h2>'.$result[$i]->utiTexte.'</h2><br>';
	    		echo '<p>'.$result[$i]->leTexte.'</p></div><hr><br>';

	    		$i++;
	     }
	}

	


}// END class TextesController
