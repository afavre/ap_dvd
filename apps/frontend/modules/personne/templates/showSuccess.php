<?php slot('title') ?>
  <?php echo $personne->getPrenom().' '.$personne->getNom(); ?>
<?php end_slot(); ?>

<?php use_stylesheet('job.css') ?>
<?php use_helper('Text') ?>
<?php
    if($personne->getImage()!=""){
        $image='personnes/'.$personne->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
<h1 class="titreA"><img id="1gris" src="/images/personne.png" /><?php echo $personne->getPrenom().' '.$personne->getNom() ?></h1>
<div class="post">
<?php
	$height=220;
	$widthMax=300;
	
	
    $img_size = getimagesize('uploads/'.$image);
    $W_Src = $img_size[0]; // largeur
    $H_Src = $img_size[1]; // hauteur
	
	if($H_Src<$height){
		$height=$H_Src;
	}
	$taille='height="'.$height.'"';
	
	if($W_Src>$H_Src){
		$heightTest = ($W_Src / $H_Src) * $height;
		if($heightTest>$widthMax){
			if($W_Src<$widthMax){
				$widthMax=$W_Src;
			}
			$taille='width="'.$widthMax.'"';
		}
	}
	
?>
    <div class="logo">

        <a class="lookimg" href="/uploads/<?php echo $image; ?>">
			<img class="thumb img_princ" <?php echo $taille; ?> src="/uploads/<?php echo $image; ?>" alt="<?php echo $personne->getNom() ?>" />
		</a>

    </div>
		<div class="infos">
          <div class="date_naissance">
           <?php
				$mort=false;
				if($personne->getDateDeces()!="0000-00-00" && $personne->getDateDeces()!=NULL){
					$mort=true;
				}
				$chiffre = explode('-',$personne->getDateNaissance()); 
				if($personne->getDateNaissance()!="0000-00-00" && $personne->getDateNaissance()!=NULL){
					$Mois = array("","Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
					if($chiffre[1]=='01' && $chiffre[2]=='01'){
						echo 'Né en: <b>'.$personne->getDateNaissance('Y').'</b>';
					}else{
						echo 'Né le: <b>'.$personne->getDateNaissance('d').' '.$Mois[$personne->getDateNaissance('n')].' '.$personne->getDateNaissance('Y').'</b>';
						
						if(!$mort){
							echo ' ('.$personne->getAge().' ans)';
						}
					}
				}else{
					echo 'Né le: <i>Inconnu</i>';
				}
				?>
			</div>
			<?php
				if($mort){
			echo '<div class="date_naissance">';
					$Mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
					if($chiffre[1]=='01' && $chiffre[2]=='01'){
						echo 'Mort en: <b>'.$personne->getDateDeces('Y').'</b> (Mort &agrave; '.$personne->getAgeMort().' ans)';
					}else{
						echo 'Mort le: <b>'.$personne->getDateDeces('d').' '.$Mois[$personne->getDateDeces('n')].' '.$personne->getDateDeces('Y').'</b> (Mort &agrave; '.$personne->getAgeMort().' ans)';
					}
			echo '</div>';
				}
			?>
          <div class="nationnalite">
              <?php
				if($personne->getNationalite()!=""){
					echo 'Nationnalité: <b>'.$personne->getNationalite().'</b>';
				}else{
					echo 'Nationnalité: <i>Inconnu</i>';
				}
			  ?>
          </div>
        </div>
</div>
<div id="onglet">
	<div id="filmographie">
		<?php $pro=$sf_user->getAttribute("proprio"); ?>
		<?php if(sizeof($personne->getSpectaclesAuteur($pro))!=0){ ?>
			<a href="<?php echo url_for('personne/videos?id='.$personne->getId().'&v=auteur') ?>" width="100%"><h2>Spectacle (<?php echo sizeof($personne->getSpectaclesAuteur($pro)); ?>)</h2></a>
				<div class="list_effet_photo list_img100_by">
					<ul>
					 <?php foreach($personne->getSpectaclesAuteur($pro) as $i => $video){ ?>
						<?php
							if($video->getImage()!=""){
								$imageF='videos/'.$video->getImage();
							}else{
								$imageF='image_vide.jpeg';
							}
						?>
						<li>
							<a href="<?php echo url_for('video/show?id='.$video->getId()) ?>" width="100%">
								<span><img class="thumb" src="/uploads/<?php echo $imageF; ?>" width="50"/></span>
								 <b><?php echo $video->getTitre(); ?></b>
							</a>
						</li>
					 <?php } ?>
					</ul>
					<div class="clear"></div>
				</div>
		<?php } 
		if(sizeof($personne->getFilmsRealisateur($pro))!=0 || sizeof($personne->getSaisonsRealisateur($pro))!=0){ ?>
			<h2>Filmographie en tant que r&eacute;alisateur</h2>
		<?php 
		}
		if(sizeof($personne->getFilmsRealisateur($pro))!=0){ ?>
			<a href="<?php echo url_for('personne/videos?id='.$personne->getId().'&v=realisateur') ?>" width="100%"><h3>Films(<?php echo sizeof($personne->getFilmsRealisateur($pro)); ?>)</h3></a>
				<div class="list_effet_photo list_img100_by">
					<ul>
					 <?php foreach($personne->getFilmsRealisateur($pro) as $i => $video){ ?>
						<?php
							if($video->getImage()!=""){
								$imageF='videos/'.$video->getImage();
							}else{
								$imageF='image_vide.jpeg';
							}
						?>
						<li>
							<a href="<?php echo url_for('video/show?id='.$video->getId()) ?>" width="100%">
								<span><img class="thumb" src="/uploads/<?php echo $imageF; ?>" width="50"/></span>
								 <b><?php echo $video->getTitre(); ?></b>
							</a>
						</li>
					 <?php } ?>
					</ul>
					<div class="clear"></div>
				</div>
		<?php } 
		if(sizeof($personne->getSaisonsRealisateur($pro))!=0){ ?>
			<a href="<?php echo url_for('personne/videos?id='.$personne->getId().'&v=realisateur_serie') ?>" width="100%"><h3>Series(<?php echo sizeof($personne->getSaisonsRealisateur($pro)); ?>)</h3></a>
				<div class="list_effet_photo list_img100_by">
					<ul>
					 <?php foreach($personne->getSaisonsRealisateur($pro) as $i => $saison){ ?>
						<?php
							if($saison->getImage()!=""){
								$imageF='saisons/'.$saison->getImage();
							}else{
								$imageF='image_vide.jpeg';
							}
						?>
						<li>
							<a href="<?php echo url_for('saison/show?id='.$saison->getId()) ?>" width="100%">
								<span><img class="thumb" class="thumb" src="/uploads/<?php echo $imageF; ?>" width="50"/></span>
								 <b><?php echo 'Saison '.$saison->getNumero(); ?></b>
								 <i><?php echo $saison->getTitre(); ?></i>
							</a>
						</li>
					 <?php } ?>
					</ul>
					<div class="clear"></div>
				</div>
		<?php } 
		if(sizeof($personne->getFilmsActeur($pro))!=0 || sizeof($personne->getSaisonsActeur($pro))!=0){ ?>
			<h2>Filmographie en tant qu'acteur</h2>
		<?php 
		}
		if(sizeof($personne->getFilmsActeur($pro))!=0){
		?>
			<a href="<?php echo url_for('personne/videos?id='.$personne->getId().'&v=acteur') ?>" width="100%"><h3>Films(<?php echo sizeof($personne->getFilmsActeur($pro)); ?>)</h3></a>
				<div class="list_effet_photo list_img100_by">
					<ul>
					 <?php foreach($personne->getFilmsActeur($pro) as $i => $video){ ?>
						<?php
							if($video->getImage()!=""){
								$imageF='videos/'.$video->getImage();
							}else{
								$imageF='image_vide.jpeg';
							}
						?>
						<li>
							<a href="<?php echo url_for('video/show?id='.$video->getId()) ?>" width="100%">
								<span><img class="thumb" src="/uploads/<?php echo $imageF; ?>" width="50"/></span>
								 <b><?php echo $video->getTitre(); ?></b>
							</a>
						</li>
					 <?php } ?>
					</ul>
					<div class="clear"></div>
				</div>
		<?php 
		}
		if(sizeof($personne->getSaisonsActeur($pro))!=0){
		?>
			<a href="<?php echo url_for('personne/videos?id='.$personne->getId().'&v=acteur_serie') ?>" width="100%"><h3>Series(<?php echo sizeof($personne->getSaisonsActeur($pro)); ?>)</h3></a>
				<div class="list_effet_photo list_img100_by">
					<ul>
					 <?php foreach($personne->getSaisonsActeur($pro) as $i => $saison){ ?>
						<?php
							if($saison->getImage()!=""){
								$imageF='saisons/'.$saison->getImage();
							}else{
								$imageF='image_vide.jpeg';
							}
						?>
						<li>
							<a href="<?php echo url_for('saison/show?id='.$saison->getId()) ?>" width="100%">
								<span><img class="thumb" src="/uploads/<?php echo $imageF; ?>" width="50"/></span>
								 <b><?php echo 'Saison '.$saison->getNumero(); ?></b>
								 <i><?php echo $saison->getTitre(); ?></i>
							</a>
						</li>
					 <?php } ?>
					</ul>
					<div class="clear"></div>
				</div>
		<?php }
		if(sizeof($personne->getSaisonsRealisateur($pro))==0 && sizeof($personne->getSaisonsActeur($pro))==0 && sizeof($personne->getFilmsActeur($pro))==0 && sizeof($personne->getFilmsRealisateur($pro))==0 && sizeof($personne->getSpectaclesAuteur($pro))==0){ ?>
			   <h2>Filmographie</h2>
				<div class="aucun">Aucun Film</div>
		<?php } ?>
	</div>
</div>

 