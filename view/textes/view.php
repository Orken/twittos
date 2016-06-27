	<?php $title_for_layout = 'Twittos - Texte' ?>

	<?php
		// Format de date pour l'affichage slmt
		$monFormat = 'l jS F Y'; // ex : Sunday 3th January 2014 
		$formatH = 'H';
		$formatM = 'i';

		$maDate = date_create($textes->dateTexte);	

		// $img sera utilisé pour afficher la photo de profil
		$img = $this->Texte->trouvePhoto($textes->utiTexte);
		//$img = denichePhoto();
		//debug($img);
	
	?>	


	<div class="jumbotron">
	<center><h1>
		<?php echo '<span class="label label-primary">'.$textes->utiTexte. '</span>'; ?>
		</h1>
		<h2>
		<?php echo $textes->utilisateur_prenom . ' ' . $textes->utilisateur_nom.''; ?>
		</h2>
		<?php 
			echo "<img class='img-rounded' src='".$img[0]->profilPic."' alt='My face' height='110' width='110'>";
		?>

		

	</center>
	<hr><br>
	
	<p>
		<?php echo $textes->leTexte; ?>
	</p>
	
	<!-- <br><hr><br><br> -->
	</div>
	<section class="row">
		<?php 
			if($this->Texte->verifieProprio($textes->id))
			{

				echo "<div class='col-md-4'><p><a href=".BASE_URL."/textes/text_edit/".$textes->id."><button class='btn btn-s btn-warning'>Editer le post n°".$textes->id."</button></a></p></div>";
				
				
				echo "<div class='col-md-4'><center><br>".date_format($maDate,$monFormat).' − '.date_format($maDate,$formatH).'h'.date_format($maDate,$formatM).'</center></div>';	

				echo "<div class='col-md-4'><p><a onClick=\"return confirm('Voulez vous vraiment supprimer ce contenu ?')\" href=".BASE_URL."/textes/proprio_delete/".$textes->id."><button class='btn btn-s btn-danger pull-right'><span class='glyphicon glyphicon-trash'></span> &nbsp; Supprimer le post</button></a></p></div>";

			}else{ 
				echo "<center>".date_format($maDate,$monFormat).' − '.date_format($maDate,$formatH).'h'.date_format($maDate,$formatM).'</center>';

			} 
		?>	
	</section>

	<br><br>
	<center>
		<h1>
			<?php
				if(count($comments) == 0)
				{
					echo '<span class="label label-default">Pas de commentaires sur ce post</span>';
				}
				elseif(count($comments) == 1)
				{
					echo '<span class="label label-default">'.count($comments).' commentaire</span>'; 
				}else
				{
					echo '<span class="label label-default">'.count($comments).' commentaires</span>'; 

				}
			?>
		</h1>
		<br>
		<?php
		echo '<a href="'.BASE_URL."/textes/comment/".$textes->id.'"><button class="btn btn-info">
			<span class="glyphicon glyphicon-pencil"></span><b>&nbsp; &Eacute;crire un nouveau commentaire</b>
		</button></a>';
		?>
	</center>
	<br><br><hr>
	<div class="maClasse">
		<?php 	
			// Utilise pour l'accès a des propriétés d'un commentaire, comme le peudo par ex
			$i = 0;

			// Sert à retenir l'id du dernier texte regardé, afin de revenir dessus apres une suppression de commentaire
			$_SESSION['idDuTexte'] = $this->request->params[0];

			foreach ($comments as $comment) 
			{
				if($this->vars['comments'][$i]->utiPseudo == $_SESSION['Utilisateur']->pseudo)
				{
					echo "<a href='".BASE_URL.'/textes/proprio_delete_com/'.$comment->id."' ><button class='btn btn-xs btn-danger pull-right'><span class='glyphicon glyphicon-trash'></span> &nbsp; Supprimer</button></a>";
				}

				echo "<p><b><u>".$comment->utiPseudo." a écrit : </u></b><br>";
				echo $comment->leCommentaire;				

				$i++;

				echo "</p><hr>";
			}
		?>
	</div>