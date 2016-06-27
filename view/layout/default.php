<!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8"/>
	<title><?php echo isset($title_for_layout)?$title_for_layout:'Twittos'; ?></title>	<!-- Si $title_for_layout est defini je l'affiche, sinon j'affiche Twittos -->
	<!-- <link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css"> passer à bootstrap.min.css à la fin du projet et changer l'architercture -->

	<link rel="icon" type="image/png" href="<?= BASE_URL ?>/webroot/img/favicon.ico" />

	<link rel="stylesheet" href="<?= CSS ?>bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="<?= CSS ?>monStyle.css">


</head>
<body>

		<!-- Dans cette page mettre le menu, etc
		(dans le tuto c'est créé à la vidéo 3) -->

	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">
					<div class="navbar-header">
						<a class="navbar-brand bigger" href="<?= BASE_URL.'/textes' ?>"> <img src="<?= BASE_URL.DS.'/webroot/img/logov2.png' ?>" id="logo"></a>
					</div>
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav bigger">

							<li><a href="<?= BASE_URL.'/textes' ?>">Accueil</a></li>
							<li><a href="http://www.noelshack.com/" target="_blank">Héberger une image</a></li>
							<li><a href="<?= BASE_URL.'/textes/search' ?>">Recherche</a></li>
							<?php
								echo '<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Jeux</a>
									<ul class="dropdown-menu">
										<li><a href="'.BASE_URL."/pages/snake".'" >&nbsp;&nbsp; Snake &nbsp;&nbsp;</a></li>
										<li><a href="'.BASE_URL."/pages/pong".'" >&nbsp;&nbsp; Pong &nbsp;&nbsp;</a></li>
									</ul>
								</li>';
							?>
						</ul>
						<ul class="nav navbar-nav navbar-right bigger">
							<?php

							if(isset($_SESSION['Utilisateur']->pseudo)) {
								// Affichage de la photo de profil
								echo '<li class="with-img dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img id="maphoto" src="'.$_SESSION['Utilisateur']->profilPic.'" alt="My face" height="50" width="50"></a>

									<ul class="dropdown-menu">
										<li><a href="'.BASE_URL."/utilisateurs/gestion".'" >&nbsp;&nbsp; Changer sa photo de profil &nbsp;&nbsp;</a></li>
									</ul>
								</li>';

								// Affichage du nom et prénom de l'utilisateur
								echo "<li><a>&nbsp;&nbsp;".$_SESSION['Utilisateur']->prenom.' '.$_SESSION['Utilisateur']->nom."</a></li>";

								echo "<li><a onClick=\"return confirm('Voulez vous vraiment vous déconnecter ?')\" href=".BASE_URL.'/utilisateurs/logout'."><span class=\"glyphicon glyphicon-log-out\" aria-hidden=\"true\"></span> &nbsp;Se déconnecter</a></li> ";

							}else{
								echo "<li><a href=".BASE_URL.'/utilisateurs/login'.">Se connecter</a></li> ";
								echo "<li><a href=".BASE_URL.'/utilisateurs/creer'.">S'inscrire</a></li> ";
							}
							?>
						</ul>
					</div>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>
	</nav>

	<?php echo $this->Session->flash(); ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php
					echo $content_for_layout;
				?>
				<!-- Début fusée -->
				<div id="rocket_dummy">
					<div id="rocket_dock"></div>
					<div id="rocket_mobile">
						<div class="fire top"></div>
						<div class="fire bottom"></div>
						<div class="rocket_body">
						<a href="<?= BASE_URL.'/textes/text_edit/' ?>" class="btn  btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
						</div>
					</div>
				</div>
				<!-- Fin fusée -->
			</div>
		</div>
	</div>

	<br><br><br>

	<footer class="panel-footer">
		<div class="container">
			<span class="text-muted">
				<button class="btn btn-default pull-right" onclick="location.href='#top'">
					Remonter en haut de la page &nbsp; <span class="glyphicon glyphicon-menu-up"></span>
				</button>

  				<?php
  					echo '<a href="'.BASE_URL."/textes?page=".$_SESSION['pageActuelle'].'" ><button class="btn btn-default pull-left">';
  				?>
  					<span class="glyphicon glyphicon-menu-left"></span> &nbsp; Précédent
  				</button></a>
			</span>
		</div>
	</footer>




	<!-- #region javascript -->


	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="<? JS;?>app.js"></script>
	<script type="text/javascript" src="<?= Router::webroot('js/tinymce/tinymce.min.js') ?>"></script>
	<script type="text/javascript" src="<?= Router::webroot('js/bootstrap.js') ?>"></script>
	<script type="text/javascript" src="<?= JS ?>functions.js"></script>
	<script type="text/javascript" src="<?= JS ?>snake.js"></script>
	<script type="text/javascript" src="<?= JS ?>pong.js"></script>

	<!-- Fin de #region Javascript -->

</body>
</html>