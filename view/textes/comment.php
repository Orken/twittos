<div class="page-header">
	<h1> &Eacute;crire un commentaire sur ce texte </h1>
</div>

<form action="" method="post" name="formEditeur" onsubmit="return verif_contenu_wysiwyg();" >
	<?php 
	// leTexte correspond au nom dans la BDD
	echo $this->Form->input('leCommentaire','Contenu',array('type' => 'textarea','class'=>'wysiwyg')); 
	echo $this->Form->input('id', 'hidden'); // Pour avoir l'ID disponible
	?>

	<br>
	<div class="action">
			<input type="submit" class="btn btn-lg btn-primary" value="Enregistrer">
			<input type='button' class='btn btn-lg btn-danger pull-right' value='Annuler' onclick='location.href="<?= BASE_URL.'/textes/' ?>"'>
	</div>
</form>