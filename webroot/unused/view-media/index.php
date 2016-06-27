<?php 
	$_SESSION['maPhoto'] = $this->denichePhoto($_SESSION['Utilisateur']->pseudo);
?>

<br><br>	
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="well"><center>
				<h2>Changer sa photo de profil</h2>
				<hr><br>

				<form class="form-group" action="<?= BASE_URL.'/medias/index'; ?>" method="post" enctype="multipart/form-data">
					
					<b>Selectionnez votre photo :</b><br><br>
					<input class="btn btn-block btn-default" type="file" name="file" id="inputFile">
				 	
				 	<br><br>
				 	<div class="col-md-4"></div>
				 	<div class="col-md-4">
				 		<button class="btn btn-block btn-primary" type="submit"><span class='glyphicon glyphicon-ok'></span></button>
						<!--<input type="submit" class="btn btn-block btn-primary" value="Enregistrer les modifications">-->
					</div>
				</form>
				<br>
			</center></div>
		 	<div class="col-md-4"></div>
		</div>
	<div class="col-md-2"></div>
	</div>
</div>