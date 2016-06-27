<h1 class="texteOmbre">Les idées du moment</h1>
<br/>
<div class="monOmbre">
	<a href="<?= BASE_URL.'/textes/text_edit/' ?>" class="btn btn-lg btn-block btn-info"><strong>&Eacute;crire une nouvelle idée &nbsp;&nbsp;<span class="glyphicon glyphicon-pencil"></span></strong></a>
</div>
<br/><hr/>
	
		<?php 
				// Utilisé pour le bouton précédent.
				$_SESSION['pageActuelle'] = 1;
				if(!empty($this->request->page))
				{
					$_SESSION['pageActuelle'] = $this->request->page;
				}

				// Permet de trier les éléments du tableau en fonction de la date
				//usort($textes, 'comparer');
				//$textes = array_reverse($textes);

				// Format de date pour l'affichage slmt
				$monFormat = 'l jS F Y'; // ex : Sunday 3th January 2014 
				$formatH = 'H';
				$formatM = 'i';				
		?>	

		<!-- Index paginé -->
		<?php foreach ($textes as $k => $v): ?>
			<br>
			<div class="jumbotron" onmouseover="this.style.backgroundColor='#EDF7FF';" onmouseout="this.style.backgroundColor='#EEE';">
				<h2><center><span class="label label-primary">
					<?php 
						echo $v->utiTexte;
						//echo "<img id='maphoto' src='".$_SESSION['Utilisateur']->profilPic."' alt='My face' height='50' width='56'>";
					?>						
				</span></center></h2>
				<br><br>
				
				<?php echo $v->leTexte; ?>
				
				<br><br>
				<a href="<?php echo BASE_URL.'/textes/view/'.$v->id; ?>">Voir le texte complet <span class="glyphicon glyphicon-menu-right"></span></a>
				<?php 
					$maDate = date_create($v->dateTexte);
					
					echo '<span class="pull-right"><div class="panel panel-default"><div class="panel-body">'.date_format($maDate,$monFormat).' − '.date_format($maDate,$formatH).'h'.date_format($maDate,$formatM).'.</div></div></span>'; 
				?>
				
			</div>
			<hr>
		<?php endforeach; ?>


<div class="container">
	<ul class="pager">
		<!-- Pagination pour les nouveaux posts -->
		<li class="previous <?= ($this->request->page <= 1)?'disabled':''; ?> ">
			<a href="?page=<?php echo $this->request->page-1; ?>">&larr; Newer</a>
		</li>	
		<!-- Pagination pour les posts plus anciens -->
		<li class="next <?= ($this->request->page == $page)?'disabled':''; ?>">
			<a href="?page=<?php echo $this->request->page+1; ?>"> Older &rarr;</a> 
		</li>
	</ul>
</div>

<center><ul class="pagination remonte">
	<!-- Pagination numérotée pour la simplicité -->
	<?php for($i=1; $i <= $page; $i++): ?>
		<li <?php if($i == $this->request->page) echo 'class="active"'; ?>><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
	<?php endfor; ?>	
</ul></center>




