<?php
class MediasController extends Controller
{
	function index()
	{
		$this->loadModel('Media');
		
		$pseudoUti = $_SESSION['Utilisateur']->pseudo;

		if($this->request->data && !empty($_FILES['file']['name']))
		{
			if(strpos($_FILES['file']['type'], 'image') !== false)
			{
				$dir = WEBROOT.'/'.$pseudoUti.$_FILES['file']['name'];
				
				move_uploaded_file($_FILES['file']['tmp_name'], "$dir");
				$this->Media->save(array(
					'name' 		=> $this->request->data->name,
					'file' 		=> $_FILES['file']['name'],
					'uti_pseudo' 	=> $pseudoUti,
					'type'		=> 'img'
				));
				$this->Session->setFlash("Votre photo de profil a bien été changée.");
			}else{
				$this->Session->setFlash('Le fichier n\'est pas une image.', 'danger');
			}			
		}
	}


	/**
	 * Utilisé pour les photos de profils en version uploadable sur le pc
	 */
	public function denichePhoto($uti)
	{
		$this->loadModel("Media");

		return $this->Media->trouvePhoto($uti);
	}


}