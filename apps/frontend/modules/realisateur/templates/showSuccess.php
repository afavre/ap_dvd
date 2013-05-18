<?php slot('title') ?>
  <?php echo $realisateur->getPrenom().' '.$realisateur->getNom(); ?>
<?php end_slot(); ?>

<?php use_stylesheet('job.css') ?>
<?php use_helper('Text') ?>
<?php
    if($realisateur->getImage()!=""){
        $image='realisateurs/'.$realisateur->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
<div class="post">
    <h2><?php echo $realisateur->getPrenom().' '.$realisateur->getNom() ?></h2>

  <?php if ($realisateur->getImage()): ?>
    <div class="logo">

        <a class="lookimg" href="/uploads/<?php echo $image; ?>">
			<img height="200" src="/uploads/<?php echo $image; ?>" alt="<?php echo $realisateur->getNom() ?>" />
		</a>

    </div>
  <?php endif; ?>
		<div class="infos">
          <div class="date_naissance">
           <?php
				$chiffre = explode('-',$realisateur->getDateNaissance()); 
				if($realisateur->getDateNaissance()!="0000-00-00" && $realisateur->getDateNaissance()!=NULL){
					$Mois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
					if($chiffre[1]=='01' && $chiffre[2]=='01'){
						echo utf8_encode('<b>Né en: </b>'.$realisateur->getDateNaissance('Y').' ('.$realisateur->getAge().' ans)');
					}else{
						echo utf8_encode('<b>Né le: </b>'.$realisateur->getDateNaissance('d').' '.$Mois[$realisateur->getDateNaissance('n')].' '.$realisateur->getDateNaissance('Y').' ('.$realisateur->getAge().' ans)');
					}
				}else{
					echo utf8_encode('<b>Né le: </b><i>Inconnu</i>');
				}
			?>
          </div>
          <div class="nationnalite">
              <?php
				if($realisateur->getNationalite()!=""){
					echo utf8_encode('<b>Nationnalité: </b>').$realisateur->getNationalite();
				}else{
					echo utf8_encode('<b>Nationnalité: </b><i>Inconnu</i>');
				}
			  ?>
          </div>
        </div>
</div>
<div id="onglet">
				<div id="filmographie">
					<?php $pro=$sf_user->getAttribute("proprio"); ?>
					<?php if(sizeof($realisateur->getFilms($pro))!=0){ ?>
						<a href="<?php echo url_for('film/filmsRealisateur?id='.$realisateur->getId()) ?>" width="100%"><h2>Filmographie (<?php echo sizeof($realisateur->getFilms($pro)); ?>)</h2></a>
							<table>
								<tr>
								 <?php foreach($realisateur->getFilms($pro) as $i => $film){ ?>
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

