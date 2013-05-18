
<?php 

$pro=$sf_user->getAttribute("proprio");
foreach ($categories as $i => $categorie){ 
	$nbFilms=sizeof($categorie->getFilms($pro));
	$nbSpectacles=sizeof($categorie->getSpectacles($pro));
	$nbVideos=sizeof($categorie->getVideos($pro));
	$nb_max_affich = 26;
?>

<div id="cat_<?php echo $categorie->getId(); ?>" class="center_bloc" style="width: 95%;" >
	<a class="bloc_info list_cat" onClick="affichCach(<?php echo "'".$categorie->getId()."'"; ?>);return false;" href="<?php echo url_for('categorie/show?id='.$categorie->getId()) ?>">
		<table cellpadding="1" cellspacing="1" border="0" width="100%" height="100%" >
			<tr>
				<td class="lien" valign="middle" style="padding-left:5px;" >
					<h4><?php echo $categorie->getNom(); ?></h4>
				</td>
				<td class="lien" valign="middle" style="padding-right:5px;" align="right" >
					<?php if($nbFilms>0){ ?>
						<div>Films : <div class="numFilms"><?php echo $nbFilms; ?> </div></div>
					<?php } ?>
					<?php if($nbSpectacles>0){ ?>
						<div>Spectacles : <div class="numFilms"><?php echo $nbSpectacles; ?> </div></div>
					<?php } ?>
				</td>
			</tr>
		</table>
	</a>
	<div id="film_<?php echo $categorie->getId(); ?>" class="invisible" >
<?php if($nbVideos){ ?>
		<div class="list_effet_photo list_img100_by filmscategorie">
			<ul>
		<?php 
		foreach($categorie->getVideos($pro, $nb_max_affich) as $i => $film){                      
			if($film->getImage()!=""){
				$imageF='videos/'.$film->getImage();
			}else{
				$imageF='image_vide.jpeg';
			}
		?>
			<li style="<?php if($film->getType()=='film'){ echo 'height:120px;'; }else if($film->getType()=='spectacle'){ echo 'height:150px;'; } ?>" >
				<a href="<?php echo url_for('video/show?id='.$film->getId()) ?>" width="100%">
					<span><img class="thumb" src="/uploads/<?php echo $imageF; ?>" width="70"/></span>
					<b><?php echo $film->getTitre(); ?></b>
				</a>
			</li>
		<?php
		}
		?>		
		<?php
		if($nbVideos>$nb_max_affich){
		?>	
			<li class="voir_plus">
				<div>
					<a href="<?php echo url_for('categorie/show?id='.$categorie->getId()) ?>" width="100%">
						<b> ... Voir tous de films de la categorie "<?php echo $categorie->getNom(); ?>"</b>
					</a>
				</div>
			</li>
		<?php
		}
		?>		
			</ul>
			<div class="clear"></div>
		</div>
<?php }else{ ?>
		<div class="centre rouge">Aucun Film</div>
<?php } ?>
	</div>
</div>
<?php } ?>