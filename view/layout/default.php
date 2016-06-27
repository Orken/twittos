<!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8"/>
	<title><?php echo isset($title_for_layout)?$title_for_layout:'Twittos'; ?></title>	<!-- Si $title_for_layout est defini je l'affiche, sinon j'affiche Twittos -->
	<!-- <link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css"> passer à bootstrap.min.css à la fin du projet et changer l'architercture -->	
	
	<link rel="icon" type="image/png" href="<?= BASE_URL ?>/webroot/img/favicon.ico" />

	<link rel="stylesheet" href="<?= CSS ?>bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="<?= CSS ?>monStyle.css">

	<style type="text/css">

		#rocket_dummy{
		position:absolute; left:-300px; top:20px;
		width:55px; height:55px;
		}
		#rocket_mobile{
		position:absolute; top:0; margin:85px 0 0 -4px;
		width:60px; height:185px;
		}
		#rocket_mobile.fixed{position:fixed; top:0;}

		#rocket_dock{
		position:absolute; width:28px; height:28px; top:164px; left:12px;
		background:url('<?= Router::webroot('js/rocket/rocket-spriteNew.png') ?>') 0 0 no-repeat;
		}

		#rocket_mobile .rocket_body{
		position:absolute; width:60px; height:60px; top:63px; left:0;
		background:url('<?= Router::webroot('js/rocket/rocket-spriteNew.png') ?>') 0 -28px no-repeat;
		}

		#rocket_mobile .fire{
		position:absolute; width:35px; height:78px;
		}
		#rocket_mobile .fire.top{
		left:13px; top:3px;
		background:url('<?= Router::webroot('js/rocket/rocket-spriteNew.png') ?>') -60px 0 no-repeat;
		}
		#rocket_mobile .fire.top.on{background-position:-95px 0;}
		#rocket_mobile .fire.bottom{
		left:13px; top:104px;
		background:url('<?= Router::webroot('js/rocket/rocket-spriteNew.png') ?>') -60px -78px no-repeat;
		}
		#rocket_mobile .fire.bottom.on{background-position:-95px -78px;}
		.rocket_body a { margin-top: 13px; margin-left: 10px;}

	</style>

	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript">
	/**
	 * Animation de la fusée avec Javascript
	**/
	jQuery(document).ready(function($){
		// Stockage des références des différents éléments dans des variables
		rocket     = $('#rocket_mobile');
		firetop    = $('#rocket_mobile .fire.top');
		firebottom = $('#rocket_mobile .fire.bottom');
		LAST_SCROLL_OFFSET = $(window).scrollTop();
		LAST_SCROLL_TIME   = new Date().getTime();

		// Calcul de la marge entre le haut du document et #rocket_mobile
		fixedLimit = rocket.offset().top - parseFloat(rocket.css('marginTop').replace(/auto/,0));
		
		// On déclenche un événement scroll pour mettre à jour le positionnement au chargement de la page
		$(window).trigger('scroll');
		
		$(window).scroll(function(event){
			// Valeur de défilement lors du chargement de la page
			windowScroll = $(window).scrollTop();
			
			// Mise à jour du positionnement en fonction du scroll
			if( windowScroll >= fixedLimit ){
				rocket.addClass('fixed');
			} else {
				rocket.removeClass('fixed');
			}
			
			// Animation flammes
			// Allumage
			if( rocket.hasClass('fixed') ){
				if( windowScroll > LAST_SCROLL_OFFSET ){
					// DOWN
					firetop.addClass('on');
					firebottom.removeClass('on');
					LAST_SCROLL_DIRECTION = 'down';
				} else {
					// UP
					firetop.removeClass('on');
					firebottom.addClass('on');
					LAST_SCROLL_DIRECTION = 'up';
				}
			}
			
			// Arrêt
			setTimeout(function(){
				if( new Date().getTime() - LAST_SCROLL_TIME > 50 ){
					firetop.removeClass('on');
					firebottom.removeClass('on');
					
					// Animation inertie fusée
					if( rocket.hasClass('fixed') ){
						if( LAST_SCROLL_DIRECTION == 'down' ){
							rocket.animate({
								top: '+=5px'
							}, 50, function(){
								rocket.animate({
									top: '-=5px'
								}, 120);
							});
						} else {
							rocket.animate({
								top: '-=5px'
							}, 50, function(){
								rocket.animate({
									top: '+=5px'
								}, 120);
							});
						}
					}
				}
			},70);
			
			// Mise à jour variables
			LAST_SCROLL_OFFSET = windowScroll;
			LAST_SCROLL_TIME   = new Date().getTime();
		});
	});


	// Système spoiler
	$(function(){
    		$('.spoiler-text').hide();
    		$('.spoiler-toggle').click(function(){
        		$(this).next().toggle();
    		}); // end spoiler-toggle
	}); // end document ready

	</script>

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

	

	<script type="text/javascript" src="<?= Router::webroot('js/tinymce/tinymce.min.js') ?>"></script>

	<script type="text/javascript" src="<?= Router::webroot('js/bootstrap.js') ?>"></script>

	<script type="text/javascript" src="<?= JS ?>functions.js"></script>

	<script type="text/javascript" src="<?= JS ?>snake.js"></script>

	<script type="text/javascript" src="<?= JS ?>pong.js"></script>


	<!-- Fin de #region Javascript -->

</body>
</html>