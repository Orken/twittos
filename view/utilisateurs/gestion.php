<br><br>	
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="well"><center>
				<h2>Changer sa photo de profil</h2>
				<hr class="style-one" ><br>

				<form action="<?= BASE_URL.'/utilisateurs/gestion'; ?>" method="post">
					<!--label for="inputPhoto">Changer votre photo de profil</label>-->
				 	<a class="pull-left btn btn-default" href="http://www.convertir-une-image.com/deformation/recadrer-une-image.asp" target="_blank"> <span class="glyphicon glyphicon-scissors"></span> Rogner une image</a>
				 	<span class="glyphicon glyphicon-arrow-right descendu"></span>
				 	<a class="pull-right btn btn-default" href="http://www.noelshack.com/" target="_blank"><span class="glyphicon glyphicon-upload"></span> Héberger une image</a>
				 	<br><br><br>
				 	<input id="inputPhoto" name="photo" placeholder="Lien (URL) vers votre photo (forme carrée pour éviter les déformations)" class="form-control">
				 	 
				 	<br><br>
				 	<div class="col-md-4"></div>
				 	<div class="col-md-4">
				 		<button class="btn btn-block btn-primary" type="submit"><span class='glyphicon glyphicon-ok'></span></button>
						<!--<input type="submit" class="btn btn-block btn-primary" value="Enregistrer les modifications">-->
					</div>
				</form>
				<br><br>
			</center></div>
		 	<div class="col-md-4"></div>
		</div>
	<div class="col-md-2"></div>
	</div>
</div>