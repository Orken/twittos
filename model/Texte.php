<?php
class Texte extends Model{
	
	/**
	 * Retourn vrai si la personne connectée est l'auteur du Texte qui est passé en parametre
	 */
	public function verifieProprio($idTexte)
	{
		$uti 	= $_SESSION['Utilisateur']->pseudo;
		//$idTexte 	= $this->request->data->id;
		$sql 	= "SELECT utiTexte FROM textes WHERE id=".$idTexte;
		$reponse 	= $this->db->query($sql);
		$ligne 	= $reponse->fetch();

		if($uti == $ligne['utiTexte']){
			return true;
		}else{
			return false;
		}
	}


	/**
	 * Permet de recuperer un maximum d'infos lors d'une vue de texte
	 */
	public function getById($id) {

		$sql = 'SELECT t.*, u.nom as utilisateur_nom, u.prenom as utilisateur_prenom
			   FROM textes t
			   LEFT JOIN utilisateurs u ON t.utiTexte = u.pseudo
			   WHERE t.id = :id';

		$pre = $this->db->prepare($sql);
		$pre->execute([':id' => $id]);

		return current($pre->fetchAll(PDO::FETCH_OBJ));
	}


	/**
	 * Liste dans un tableau les commentaires associés à un texte
	 */
	public function listeCommentaire($idTexte)
	{
		$sql = "SELECT * FROM comments WHERE texteId = :id";
		$pre = $this->db->prepare($sql);
		$pre->execute([':id' => $idTexte]);

		return $pre->fetchAll(PDO::FETCH_OBJ);
	}


	/**
	 * Permet de trouver la photo associée à un ID 	!### fonction non fonctionnelle ###! 
	 */
	
	public function trouvePhoto($pseudo)
	{
		$sql = 	"SELECT * FROM utilisateurs WHERE pseudo =:pseudo";

		$prep = $this->db->prepare($sql);
		$prep->execute([':pseudo' => $pseudo]);
		
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}
	

}