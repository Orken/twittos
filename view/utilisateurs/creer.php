<br><br>	

<div class="container-fluid">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<form class="form-signin" action="<?= BASE_URL.'/utilisateurs/creer'; ?>" method="post">

				<legend class="h1"><center>Inscription</center></legend>
				<br><br>
				
				<label for="inputPrenom">Prénom</label>
				<input id="inputPrenom" name="prenom" placeholder="Votre prénom" class="form-control" autofocus="">
				<br>

				<label for="inputNom">Votre nom</label>
		 		<input id="inputNom" name="nom" placeholder="Votre nom de famille" class="form-control">
		 		<br>

		 		<label for="inputPhoto">Votre photo de profil </label><i> (facultatif)</i><br>
		 		

		 		<input id="inputPhoto" name="photo" placeholder="Lien (URL) vers votre photo (forme carrée pour éviter les déformations)" class="form-control">
		 		<br>
		 		<a class="pull-left btn btn-default" href="http://www.convertir-une-image.com/deformation/recadrer-une-image.asp" target="_blank"> 
		 			<span class="glyphicon glyphicon-scissors"></span> Rogner une image
		 		</a>
				<a class="pull-right btn btn-default" href="http://www.noelshack.com/" target="_blank">
				 	<span class="glyphicon glyphicon-upload"></span> Héberger une image
				</a><br><br>
		 		<hr><br>

				<label for="inputPseudo">Votre pseudo</label>
				<input id="inputPseudo" name="pseudo" placeholder="Il vous servira pour vous connecter à l'application" class="form-control" autofocus="">
				<br>

				<label for="inputMdp">Mot de passe</label>
		 		<input id="inputMdp" name="mdp" placeholder="Il vous servira pour vous connecter à l'application" type="password" class="form-control">
		 		<br>
		 		<hr><br>

				<div class="actions">
					<input type="submit" class="btn btn-block btn-primary" value="S'inscrire !">
				</div>

			</form>
		</div>
	<div class="col-md-2"></div>
	</div>
</div>
