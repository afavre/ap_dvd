<?php slot('title') ?>
  <?php echo $acteur->getPrenom().' '.$acteur->getNom(); ?>
<?php end_slot(); ?>

<?php use_stylesheet('job.css') ?>
<?php use_helper('Text') ?>
<?php
    if($acteur->getImage()!=""){
        $image='acteurs/'.$acteur->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
<h2 class="titreA"><img id="1gris" src="/images/acteur.png" /><?php echo $acteur->getPrenom().' '.$acteur->getNom() ?></h2>
<div class="post">

  <?php if ($acteur->getImage()): ?>
    <div class="logo">

        <a class="lookimg" href="/uploads/<?php echo $image; ?>">
			<img height="213" src="/uploads/<?php echo $image; ?>" alt="<?php echo $acteur->getNom() ?>" />
		</a>

    </div>
  <?php endif; ?>
		<div class="infos">
          <div class="date_naissance">
           <?php
				$mort=false;
				if($acteur->getDateDeces()!="0000-00-00" && $acteur->getDateDeces()!=NULL){
					$mort=true;
				}
				$chiffre = explode('-',$acteur->getDateNaissance()); 
				if($acteur->getDateNaissance()!="0000-00-00" && $acteur->getDateNaissance()!=NULL){
					$Mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
					if($chiffre[1]=='01' && $chiffre[2]=='01'){
						echo utf8_encode('Né en: <b>'.$acteur->getDateNaissance('Y').'</b>');
					}else{
						echo utf8_encode('Né le: <b>'.$acteur->getDateNaissance('d').' '.$Mois[$acteur->getDateNaissance('n')].' '.$acteur->getDateNaissance('Y').'</b>');
						
						if(!$mort){
							echo utf8_encode(' ('.$acteur->getAge().' ans)');
						}
					}
				}else{
					echo utf8_encode('Né le: <i>Inconnu</i>');
				}
				?>
			</div>
			<?php
				if($mort){
			echo '<div class="date_naissance">';
					$Mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
					if($chiffre[1]=='01' && $chiffre[2]=='01'){
						echo utf8_encode('Mort en: <b>'.$acteur->getDateDeces('Y').'</b> (Mort &agrave; '.$acteur->getAgeMort().' ans)');
					}else{
						echo utf8_encode('Mort le: <b>'.$acteur->getDateDeces('d').' '.$Mois[$acteur->getDateDeces('n')].' '.$acteur->getDateDeces('Y').'</b> (Mort &agrave; '.$acteur->getAgeMort().' ans)');
					}
			echo '</div>';
				}
			?>
          <div class="nationnalite">
              <?php
				if($acteur->getNationalite()!=""){
					echo utf8_encode('Nationnalité: <b>'.$acteur->getNationalite().'</b>');
				}else{
					echo utf8_encode('Nationnalité: <i>Inconnu</i>');
				}
			  ?>
          </div>
        </div>
</div>
<div id="onglet">
				<div id="filmographie">
				<?php $pro=$sf_user->getAttribute("proprio"); ?>
					<?php if(sizeof($acteur->getFilms($pro))!=0){ ?>
						<a href="<?php echo url_for('film/filmsActeur?id='.$acteur->getId()) ?>" width="100%"><h2>Filmographie (<?php echo sizeof($acteur->getFilms($pro)); ?>)</h2></a>
							<table>
								<tr>
								 <?php foreach($acteur->getFilms($pro) as $i => $film){ ?>
									<?php
										if($film->getImage()!=""){
											$imageF='films/'.$film->getImage();
										}else{
											$imageF='image_vide.jpeg';
										}
									?>
									<td valign="top" width="70">
										<a href="<?php echo url_for('film/show?id='.$film->getId()) ?>" width="100%">
											 <img src="/uploads/<?php echo $imageF; ?>" width="50"/><br/>
											 <b><?php echo $film->getTitre(); ?></b>
										</a>
									</td>
								 <?php } ?>
								</tr>
							</table>
					<?php }else{ ?>
						   <h2>Filmographie</h2>
							<div style="margin-left:10px;">Aucun Film</div>
					<?php } ?>
				</div>


</div>

