<?php use_stylesheet('film.css') ?>
<?php use_helper('Text') ?>

<div id="search">

	<?php if(sizeof($films) || sizeof($personnes) || sizeof($series) || sizeof($motscles) || sizeof($categories)){ ?>
		<?php if(sizeof($films)){ ?>
			<div class="divshearch" id="films">
				<h2>Resultat pour les Films<span><i>Recherche sur "<?php echo $quer; ?>"</i></span></h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('film/listFilmSearch', array('films' => $films)) ?>
				</div>
			</div>
		<?php } ?>

		<?php if(sizeof($personnes)){ ?>
			<div class="divshearch" id="acteurs">
				<h2>Resultat pour les Acteurs/R&eacute;alisateur<span><i>Recherche sur "<?php echo $quer; ?>"</i></span></h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('personne/listPersonne', array('personnes' => $personnes)) ?>
				</div>
			</div>
		<?php } ?>

		<?php if(sizeof($series)){ ?>
			<div class="divshearch" id="series">
				<h2>Resultat pour les Séries<span><i>Recherche sur "<?php echo $quer; ?>"</i></span></h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('serie/listSerie', array('series' => $series)) ?>
				</div>
			</div>
		<?php } ?>

		
		<?php if(sizeof($motscles)){ ?>
			<div class="divshearch" id="motscle">
				<h2>Resultat pour les Mots-Cles<span><i>Recherche sur "<?php echo $quer; ?>"</i></span></h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('motscle/listMotscle', array('motscles' => $motscles)) ?>
				</div>
			</div>
		<?php } ?>
		
		<?php if(sizeof($categories)){ ?>
			<div class="divshearch" id="categorie">
				<h2>Resultat pour les Catégories<span><i>Recherche sur "<?php echo $quer; ?>"</i></span></h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('categorie/listCategorie', array('categories' => $categories)) ?>
				</div>
			</div>
		<?php } ?>
	<?php }else{ ?>
			<h2>Recherche sur "<?php echo $quer; ?>"</i></span></h2>
            <div class="rouge centre"><i>Aucun résultat n'a été trouvé</i></div>
	<?php } ?>
	
</div>