<?php

class Model{

	static $connections = array();

	public $conf = 'default';
	public $table = false;
	public $db;
	public $primaryKey = 'id';
	public $id;

	public function __construct()
	{
		//J'initialise des variables
		if($this->table === false)
		{
			$this->table = strtolower(get_class($this)).'s';
		}
		//Je me connecte à la base
		$conf = Conf::$databases[$this->conf];
		if(isset(Model::$connections[$this->conf])){
			$this->db = Model::$connections[$this->conf];
			return true;
		}
		try{
			$pdo = new PDO(
				'mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
				$conf['login'],
				$conf['password'],
				//Pour éviter les erreurs d'encodage on rajoute une commande pour lire en utf8 sur mysql
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
			);
			$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

			Model::$connections[$this->conf] = $pdo;
			$this->db = $pdo;
		}catch(PDOException $e){
			if(Conf::$debug >= 1){
				die($e->getMessage());
			}else{
				die('Impossible de se connecter à la base de donnée');
			}
			
		}
		
	}


	public function find($req)
	{
		
		$sql = 'SELECT ';
		if(isset($req['fields'])){
			if(is_array($req['fields'])){
				$sql .= implode(', ',$req['fields']);
			}else{
				$sql .= $req['fields'];
			}
		}else{
			$sql .= '*';
		}

		$sql .= ' FROM '.$this->table.' as '.get_class($this).' ';

		// Construction de la condition
		if(isset($req['conditions'])){
			$sql .= ' WHERE ';
			if(!is_array($req['conditions'])){
				$sql .= $req['conditions'];
			}else{
				$cond = array();
				foreach($req['conditions'] as $k => $v){
					if(!is_numeric($v)){
						$v = '"'.addslashes($v).'"';
					}
					$cond[] = "$k=$v";	// Par ex, la premiere case de cond[] sera id=1 (je crois)
				}
				$sql .= implode(' AND ', $cond);	//Si il y a plusieurs conditions, la requete sql additionnera les conditions avec des AND				
			}
		}

		if(isset($req['orderby']) && !is_array($req['orderby'])){
			$sql .= ' ORDER BY '.$req['orderby'].' DESC ';

		}

		if(isset($req['limit'])){
			$sql .= ' LIMIT '.$req['limit'];
		}

		$pre = $this->db->prepare($sql);
		$pre->execute();

		return $pre->fetchAll(PDO::FETCH_OBJ);
	}



	public function findFirst($req){
		return current($this->find($req));
	}



	public function findCount($conditions){
		$resultat = $this->findFirst(array(
			'fields' => 'COUNT('.$this->primaryKey.') as count',
			'conditions' => $conditions
		));
		return $resultat->count;
	}


	/**
	 * Permet d'inscrire un nouvel utilisateur (INSERT INTO)
	 */
	public function addUtilisateur($req)
	{
		
		if(!empty($req['profilPic']) && !empty($req['pseudo']) && !empty($req['mdp']) && !empty($req['nom']) && !empty($req['prenom'])){

			$sql = 'INSERT INTO '.$this->table.' (pseudo, mdp, nom, prenom, profilPic) VALUES (';
			$contenu = array();

			foreach($req as $k => $v){
				if(!is_numeric($v)){
					$v = '"'.addslashes($v).'"';					
				}
				$contenu[] = "$v";
			}

			$sql .= implode(',', $contenu);
			$sql .= ');';

			// Et on envoie la requete
			$pre = $this->db->prepare($sql);
			$pre->execute();

			return true;

		}else{

			if(!empty($req['pseudo']) && !empty($req['mdp']) && !empty($req['nom']) && !empty($req['prenom'])){		
			
				$sql = 'INSERT INTO '.$this->table.' (pseudo, mdp, nom, prenom) VALUES (';
				$contenu = array();

				foreach($req as $k => $v){
					if(!is_numeric($v)){
						$v = '"'.addslashes($v).'"';					
					}
					$contenu[] = "$v";
				}

				$sql .= implode(',', $contenu);
				$sql .= ');';

				// Et on envoie la requete
				$pre = $this->db->prepare($sql);
				$pre->execute();

				return true;
			}
		}
		
		return false;		
	}


	public function save($data)
	{
		// $data contient l'ID et le Texte.
		//debug($data,'$data function save');
		//debug($this,'$this');
		$d = array(); 
		$fields = array();
		$key = $this->primaryKey;

		foreach($data as $k=>$v){
			$fields[] = "$k=:$k";
			$d[":$k"] = $v;
		}
		
		// SI on a l'ID, on va faire un UPDATE, sinon INSERT INTO
		if(isset($data->$key) && !empty($data->$key)){
			$sql = 'UPDATE '.$this->table.' SET '.implode(',',$fields).' WHERE '.$key.'=:'.$key;
			$this->id = $data->$key;
			$action = 'update';
		}else{
			if(isset($data->$key)){
				unset($data->$key);
			}

			if ( isset($d[':id']) ) {
				$d[':id'] = null;
			}

			$sql = 'INSERT INTO '.$this->table.' SET '.implode(',',$fields);
			$action = 'insert';
		}
		
		// La requete prendra les valeurs réelles qui sont dans $d
		$pre = $this->db->prepare($sql);
		$pre->execute($d);
		if($action == 'insert'){
			$this->id = $this->db->lastInsertId();
		}
		//return true;
	}


	public function saveNew($data)
	{

		$d = array();
		$fields = array();
		$key = $this->primaryKey;

		foreach($data as $k=>$v){
			$fields[] = "$k=:$k";
			$d[":$k"] = $v;
		}
		// On indique l'auteur du Texte
		$uti = $_SESSION['Utilisateur']->pseudo;
		$fields[] = "utiTexte=:utiTexte";
		$d[":utiTexte"] = $uti;		

		if(isset($data->$key)){
				unset($data->$key);
			}

			if ( isset($d[':id']) ) {
				$d[':id'] = null;
			}

			$sql = 'INSERT INTO '.$this->table.' SET '.implode(',',$fields);
			$action = 'insert';
		
		// La requete prendra les valeurs réelles qui sont dans $d
		$prep = $this->db->prepare($sql);
		$prep->execute($d);
		if($action == 'insert'){
			$this->id = $this->db->lastInsertId();
		}
	}


	/**
	 * Sauvegarde un nouveau commentaire
	 */
	public function saveComment($data, $idTexte)
	{
		$d = array();
		$fields = array();

		$fields[] = "leCommentaire=:leCommentaire";
		$d[":leCommentaire"] = $data->leCommentaire;

		$fields[] = "utiPseudo=:utiPseudo";
		$d[":utiPseudo"] = $_SESSION['Utilisateur']->pseudo;

		$fields[] = "texteId=:texteId";
		$d[":texteId"] = $idTexte;

		$sql = 'INSERT INTO comments SET '.implode(',',$fields);

		$prep = $this->db->prepare($sql);
		$prep->execute($d);
		$this->id = $this->db->lastInsertId();
	}


	/**
	 * Permet de supprimer un post (a travers proprio_delete)
	 */
	public function delete($id)
	{
		$sql = "DELETE FROM ".$this->table." WHERE ".$this->primaryKey." = ".$id;
		$this->db->query($sql);	
	}


	/**
	 * Permet de supprimer un commentaire (a travers proprio_delete_com)
	 */
	public function delete_com($id)
	{
		$sql = "DELETE FROM comments WHERE id = ".$id;
		$this->db->query($sql);
	}

	/**
	 * Change la photo de profil dans la BDD (v1)
	 */
	public function changePhoto($photo)
	{
		$sql = "UPDATE utilisateurs SET profilPic = '".$photo."' WHERE pseudo = '".$_SESSION['Utilisateur']->pseudo."'";

		$this->db->query($sql);

		return true;
	}


	/**
	 * Change la photo de profil dans la BDD (v2)
	 */
	public function changeMyPhoto($photo)
	{
		$sql = "UPDATE utilisateurs SET profilPic = '".$photo."' WHERE pseudo = '".$_SESSION['Utilisateur']->pseudo."'";

		$this->db->query($sql);

		return true;
	}

	
	/**
	 * Trouve la photo de profil correspondante
	 */
	/*
	public function trouvePhoto($uti)
	{
		// On va trouver la derniere photo de profil que l'utilisateur connnecté a uploadé (l'ID le plus haut)
		$laPhoto = $this->find(array(
			'conditions' => array(
				'utiTexte' => $_SESSION['Utilisateur']->pseudo
			),
			'orderby' => 'id',
			'limit' => 1
		));

		return $laPhoto;
	}
	*/


	public function trouveRecherche()
	{
		$result = $this->db->prepare( 'SELECT utiTexte, leTexte
                          		FROM textes
                          		WHERE leTexte LIKE \'%' . addslashes($_GET['q']) . '%\'
                          		OR utiTexte LIKE \'%' . addslashes($_GET['q']) . '%\'
                          		LIMIT 0,20' );
		$result->execute();

		return $result->fetchAll(PDO::FETCH_OBJ);
	}


}// END class Model