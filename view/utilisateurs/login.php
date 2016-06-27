<br><br>	
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<form class="form-signin" action="<?= BASE_URL.'/utilisateurs/login'; ?>" method="post">
				<legend class="h1"><center>Connexion</center></legend>
				<br><br>
				<label for="inputPseudo">Pseudo</label>
				<input id="inputPseudo" name="pseudo" class="form-control" autofocus="">
				<br>
				<label for="inputMdp">Mot de passe</label>
		 		<input id="inputMdp" name="mdp" type="password" class="form-control">
		 		<br>
		 		<div class="actions">
		 			<!-- <input type="submit" class="btn primary" value="Se connecter"> -->
		 			<button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
		 		</div>
			</form>
		</div>
	<div class="col-md-3"></div>
	</div>
</div>
