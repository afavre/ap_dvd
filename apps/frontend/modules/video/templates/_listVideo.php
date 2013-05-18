<?php $testSaison=array(); ?>
<?php foreach ($videos as $i => $video){ ?>


<?php
	$isSaga=false;
	if($video->getSaga()!=NULL){
		$isSaga=true;
		$saga=$video->getSaga();
	}
	
	$pro=$sf_user->getAttribute("proprio");
	if($video->getImage()!=""){
		$image='videos/'.$video->getImage();
	}else{
		$image='image_vide.jpeg';
	}
	$resume=$video->getExtraitResume(200);
	$titre=$video->getTitre();
	$acteurs=$video->getActeurs(5);
	$lien=url_for('video/show?id='.$video->getId());
	$id='f'.$video->getId();
	$proprietaires=$video->getProprietaires();
	$allProprio = $sf_request->getAttribute('proprio');
	$type=$video->getType();
	$first=false;
	if($type=="episode"){
		if(!$testSaison[$video->getSaison()->getId()]){
			$testSaison[$video->getSaison()->getId()]=true;
			$first=true;
			if($video->getSaison()->getImage()!=""){
				$image='saisons/'.$video->getSaison()->getImage();
			}else{
				$image='image_vide.jpeg';
			}
			$lien=url_for('saison/show?id='.$video->getSaison()->getId());
		}
	}
	if($type!="episode" || ($type=="episode" && $first)){
?>

    <table class="bloc_info center_bloc" id="video<?php echo $video->getId(); ?>" cellpadding="1" cellspacing="1" border="0" class="sitetable" width="95%" onmouseover="style.cursor='pointer';" onclick="location.href='<?php echo $lien; ?>';">

        <tr>
            <td colspan="6" class="lien" valign="bottom" style="padding-left:5px;" >
				<?php if($type=="episode"){ ?>
					<h4><?php echo $video->getSaison()->getSerie(); ?></h4><?php echo ' - <i><b>'.'Saison '.$video->getSaison()->getNumero().'</b></i>'; ?>
					<?php
					if($video->getSaison()->getNbEpisodeTot()!=0){
						echo '<i>[ '.$video->getAfficheEpisodes($pro).' / <b>'.$video->getSaison()->getNbEpisodeTot().'</b> ]</i>';
					}else{
						echo '<i>[ '.$video->getAfficheEpisodes($pro).' / <b>?</b> ]</i>';
					}
					?>
				<?php }else{ ?>
					<h4><?php echo $video->getTitre(); ?></h4><?php if($video->getSousTitre()!=''){ echo ' - <i><b>'.$video->getSousTitre().'</b></i>'; } if($video->getTitreOriginal()!=''){ echo ' <span class="titreOlist">( <i>'.$video->getTitreOriginal().')</i></span>'; } ?>
				<?php } ?>
				<span class="haut">
					<span class="proprio">
						<?php
						$ind=0;
						foreach($allProprio as $admin){
							if($admin->possede($video)){
								$mar=-65-($ind*15);
								$martop=-30;
								$ind++;
								$class = '';
							}else{
								$class = 'invisible';
							}
						?>
							<span id="boule<?php echo $video->getId().'_'.$admin->getId(); ?>" class="<?php echo $class; ?>">
								<div id="div<?php echo $admin->getUsername().'_'.$id; ?>" class="blockProprio" style="margin-left:<?php echo $mar; ?>px;margin-top:<?php echo $martop; ?>px;">
									<b><?php echo $admin; ?></b> possede cette video
								</div>
								<img onmouseover="$('#div<?php echo $admin->getUsername().'_'.$id; ?>').show();return false;" onmouseout="$('#div<?php echo $admin->getUsername().'_'.$id; ?>').hide();return false;" style="float:right;" width="15" src="/images/<?php echo $admin->getUsername(); ?>.png"/>
							</span>
						<?php
						}
						?>
					</span>
					<span class="qualite">
						<b><span class="qualite"><?php echo $video->getQualite(); ?></span></b>
						
					</span>
				</span>
			</td>
        </tr>
        <tr>
            <td valign="top" height="100%" <?php if(strlen($resume)==0){ echo 'width="80"'; } ?> ROWSPAN="2" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
				<a href="<?php echo $lien; ?>">
					<div class="imageFilm" style="min-height:100px;min-width:75px;">
						<img class="thumb" src="/uploads/<?php echo $image; ?>" alt="<?php echo $titre; ?>" height="100">
					</div>
				</a>
            </td>
			
            <td COLSPAN=4>
				<a href="<?php echo $lien; ?>">
					<p class="justify">
						<?php echo $resume; if(strlen($resume)>200){ echo"..."; } ?>
					</p>
				</a>
            </td>
        </tr>
        <tr>
            <td valign="bottom" width="200">
				<table>
					<tr>
                <?php 
					foreach($acteurs as $i => $acteur){
						if($acteur->getImage()!=""){
							$imageA='personnes/'.$acteur->getImage();
						}else{
							$imageA='image_vide.jpeg';
						}
						list($width, $height, $type, $attr) = getimagesize('uploads/'.$imageA);
						$h=round($height/($width/30));
				?>
						<td class="imageActeurSmall" valign="bottom"> 
							<div style="min-height:<?php echo $h; ?>px;min-width:30px;" > 
								<img style="padding-right:3px;" src="/uploads/<?php echo $imageA; ?>" width="30"/>
							</div>
						</td>
				<?php } ?>
					</tr>
				</table>
            </td>
			
            <td valign="bottom" class="sagaType" style="padding-bottom:5px;" width="100" >
			<?php 
			if($isSaga){
				if(sizeof($saga->getFilms($pro))==3){
					echo 'Trilogie'; 
				}else if($isSaga){
					echo 'Saga ( '.sizeof($saga->getFilms($pro)).' videos )';
				}
			}
			?>
			</td>
			<?php
			
			
				echo '<td valign="bottom" align="right" width="90" >';
				$note=$video->getNoteMoyenne($pro);
				$vote=floor($note);
				if (!$vote){ // Si $vote = false, alors aucune note n'ai prise en compte à l'affichage
					/*
					 for ($i=1;$i<=10;$i+=2){
						echo '<div style="" id="starnot_'.$i.'" class="starnot"></div>';
						$ii=$i+1;
						echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
					 }
					 */
				}else{
					for ($i=1;$i<=$vote;$i+=2){ // de 1 à $vote étoiles (+1 si impaire)
						echo '<div style="" id="starnot_'.$i.'" class="star_hovernot"></div>';
						$ii=$i+1;
						 if ($i<$vote){
							echo '<div style="" id="starnot_'.($i+1).'" class="star_hovernot"></div>';
						 }else{
							echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
						 }
					}
					for ($i;$i<=10;$i+=2){ // de ($vote (+1 si impaire)) $i à 10
						echo '<div style="" id="starnot_'.$i.'" class="starnot"></div>';
						$ii=$i+1;
						echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
					}
				}
				/*
				$voteC=floor($vote);
				echo '<div class="note'.$voteC.'" style="float:left;">(<b>'.$vote.'</b>/10)</div>';
				*/
				echo '</td>';
			
			
			?>
            <td colspan="2" valign="bottom" align="right" width="30">
				<?php 
					if($type!="episode"){
						if($sf_user->getAttribute("login")){ 
							if($sf_user->getAttribute("admin")){ 
									if($sf_user->getAttribute("login")->possede($video)){
										$moins='';
										$plus='invisible';
									}else{
										$moins='invisible';
										$plus='';
									}
					?>
								<img id="loader<?php echo $video->getId(); ?>" src="/images/loader.gif" class="invisible" height="16" />
									<a id="plus<?php echo $video->getId(); ?>" class="<?php echo $plus; ?>" onClick="AjouterVideo(this,'<?php echo $video->getId(); ?>','<?php echo $sf_user->getAttribute("login")->getId(); ?>',event);return false;" href="<?php echo url_for('video/ajoutProprio?id='.$video->getId()) ?>" onmouseover="$('#imgplus_<?php echo $video->getId(); ?>').hide();$('#imgplusbis_<?php echo $video->getId(); ?>').show();return false;" onmouseout="$('#imgplusbis_<?php echo $video->getId(); ?>').hide();$('#imgplus_<?php echo $video->getId(); ?>').show();return false;" >
										<img id="imgplus_<?php echo $video->getId(); ?>" src="/images/plusProprio.gif" />
										<img class="invisible" id="imgplusbis_<?php echo $video->getId(); ?>" src="/images/plusPropriobis.gif" />
									</a>
									<a id="moins<?php echo $video->getId(); ?>" class="<?php echo $moins; ?>" onClick="EnleverVideo(this,'<?php echo $video->getId(); ?>','<?php echo $sf_user->getAttribute("login")->getId(); ?>',event,'<?php echo $sf_user->getAttribute("login"); ?> ! \n Etes-vous sur de vouloir enlever la video \' <?php echo $video->getTitre(); ?> \' de votre collection ?');return false;" href="<?php echo url_for('video/supprProprio?id='.$video->getId()) ?>" onmouseover="$('#imgmoins_<?php echo $video->getId(); ?>').hide();$('#imgmoinsbis_<?php echo $video->getId(); ?>').show();return false;" onmouseout="$('#imgmoinsbis_<?php echo $video->getId(); ?>').hide();$('#imgmoins_<?php echo $video->getId(); ?>').show();return false;" >
										<img id="imgmoins_<?php echo $video->getId(); ?>" src="/images/moinsProprio.gif" />
										<img class="invisible" id="imgmoinsbis_<?php echo $video->getId(); ?>" src="/images/moinsPropriobis.gif" />
									</a>
					<?php 
								
							} 
						}
					}
				?>
				<?php echo $video->getVersion(); ?>
            </td>
        </tr>
    </table>
	<?php } ?>
<?php } ?>

