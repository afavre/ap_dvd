<?php use_helper('Text') ?>

<div id="search">

	<h1>Recherche sur <span><i>"<?php echo $quer; ?>"</i></span></h1>
	<?php if(sizeof($films) || sizeof($spectacles) || sizeof($personnes) || sizeof($series) || sizeof($motscles) || sizeof($categories)){ ?>
		<?php if(sizeof($films)){ ?>
			<div class="divshearch" id="films">
				<h2>Resultat pour les Films</i></span></h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('video/listVideo', array('videos' => $films)) ?>
				</div>
			</div>
		<?php } ?>
		
		<?php if(sizeof($spectacles)){ ?>
			<div class="divshearch" id="films">
				<h2>Resultat pour les Spectacles</h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('video/listVideo', array('videos' => $spectacles)) ?>
				</div>
			</div>
		<?php } ?>

		<?php if(sizeof($personnes)){ ?>
			<div class="divshearch" id="acteurs">
				<h2>Resultat pour les Acteurs/R&eacute;alisateur</h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('personne/listPersonne', array('personnes' => $personnes)) ?>
				</div>
			</div>
		<?php } ?>

		<?php if(sizeof($series)){ ?>
			<div class="divshearch" id="series">
				<h2>Resultat pour les Séries</h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('serie/listSerie', array('series' => $series)) ?>
				</div>
			</div>
		<?php } ?>

		
		<?php if(sizeof($motscles)){ ?>
			<div class="divshearch" id="motscle">
				<h2>Resultat pour les Mots-Cles</h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('motscle/listMotscle', array('motscles' => $motscles)) ?>
				</div>
			</div>
		<?php } ?>
		
		<?php if(sizeof($categories)){ ?>
			<div class="divshearch" id="categorie">
				<h2>Resultat pour les Catégories</h2>
				<div class="centre"><img class="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
				<div class="resultat">
					<?php include_partial('categorie/listCategorie', array('categories' => $categories)) ?>
				</div>
			</div>
		<?php } ?>
	<?php }else{ ?>
            <div class="aucun"><i><?php echo utf8_encode('Aucun résultat n\'a été trouvé'); ?></i></div>
	<?php } ?>
	
</div>