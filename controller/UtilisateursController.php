<?php
class UtilisateursController extends Controller{

	protected $auth = ['login','logout','creer'];

	/**
	 * Login
	 */
	function login(){

		// Si des données on été postées
		if($this->request->data){
			// Pour utiliser plus simplement data
			$data = $this->request->data;

			if(empty($data->pseudo) || empty($data->mdp))
			{
				$message = "Vous devez indiquer votre pseudo et votre mot de passe.";
			}
			else{
				// Pour comparer les mots de passes avec la BDD (crypté en SHA1 aussi)
				$data->mdp = sha1($data->mdp);

				// On charge le model Utilisateur
				$this->loadModel('Utilisateur');
				$user = $this->Utilisateur->findFirst(array(
					'conditions' => array('pseudo' => $data->pseudo, 'mdp' => $data->mdp)
				));

				if(!empty($user)){
					$this->Session->write('Utilisateur', $user);
				}else{
					$message = "Le mot de passe et le pseudo ne correspondent pas.";
				}
				// On supprime le mdp pour pas qu'il se renvoie
				$this->request->data->mdp = '';
				$_SESSION['Utilisateur']->mdp = '';
			}
		}

		if(isset($message))
		{
				echo '<div class="alert alert-danger"><center><strong> '.$message.' </strong></center></div>';
		}

		// Redirige vers la page d'accueil si on essaye d'accéder à la page de connexion alors qu'on est connecté.
		if($this->Session->isLogged()){
			header('Location: '.BASE_URL.DS."textes");
		}

	}

	/**
	 * Logout
	 */
	function logout(){
		unset($_SESSION['Utilisateur']);
		$this->Session->setFlash('Vous êtes maintenant déconnecté.');
		header('Location: '.BASE_URL.DS."utilisateurs/login");

	}

	/**
	 * Inscription
	 */
	function creer(){
		$ok = false;

		if ($this->request->data)
		{
			$data = $this->request->data;
			$this->loadModel('Utilisateur');

			// On va rentrer les valeurs dans un tableau
			$d = array();

			// On vérifie que personne n'ai deja ce pseudo
			$user = $this->Utilisateur->findFirst(array(
				'conditions' => array('pseudo' => $data->pseudo)
			));

			if(empty($user))
			{
				if(!empty($data->pseudo) && !empty($data->mdp) && !empty($data->nom) && !empty($data->prenom))
				{
					$d['pseudo'] 	= $data->pseudo;
					$d['mdp'] 	= sha1($data->mdp);
					$d['nom']		= ucfirst($data->nom);
					$d['prenom']	= ucfirst($data->prenom);

					if(!empty($data->photo)){
						$d['profilPic'] = $data->photo;
					}
					
					$ok 	= $this->Utilisateur->addUtilisateur($d);
				}else{
					$message[] = 'Vous devez remplir tous les champs.';
				}
			}else{
				$message[] = 'Ce pseudo est déjà utilisé par '.$user->prenom.' '.$user->nom.'.';
				if(empty($data->pseudo) || empty($data->mdp) || empty($data->nom) || empty($data->prenom)){
					$message[] = 'Vous devez remplir tous les champs.';
				}

			}
			
		}
		if ($ok == true)
		{
			$this->request->data->mdp = '';
			header('Location: '.BASE_URL.'/utilisateurs/login');
		}else{
			if(isset($message))
			{
				foreach($message as $v){
					echo '<div class="alert alert-danger"><center><strong> '.$v.' </strong></center></div>';
				}
			}
			
		}
		// Redirige vers la page d'accueil si on essaye d'accéder à la page de création de compte alors qu'on est connecté.
		if($this->Session->isLogged()){
			header('Location: '.BASE_URL.DS."textes");
		}		
	}


	/**
	 * Permet de changer sa photo de profil
	 */
	function gestion()	
	{
		$reussi = false;
		//recoit $data->photo qui est l'url vers la nouvelle photo
		if ($this->request->data)
		{
			$data = $this->request->data;
			$this->loadModel('Utilisateur');

			if(!empty($data->photo))
			{
				$reussi = $this->Utilisateur->changePhoto($data->photo);
			}
			if($reussi)
			{
				$this->Session->setFlash('Votre photo de profil a bien été changée.','success');
				$_SESSION['Utilisateur']->profilPic = $data->photo;
			}else{
				$this->Session->setFlash('Votre photo de profil n\'a pas pu être changée.','danger');
			}

		}
	}
	


	
}//END class UtilisateursController