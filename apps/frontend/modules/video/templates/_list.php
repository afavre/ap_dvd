
<?php foreach ($videos as $i => $video){ ?>


<?php
	$isSaga=false;
	if($video->getSaga()!=NULL){
		$isSaga=true;
		$saga=$video->getSaga();
	}
	
	$pro=$sf_user->getAttribute("proprio");
	$type=$video->getType();
	if($isSaga){
		if($saga->getImage($pro)!=""){
			$image='videos/'.$saga->getImage($pro);
		}else{
			$image='image_vide.jpeg';
		}
		$note=$saga->getNoteMoyenne($pro);
		$resume=$saga->getExtraitResume($pro,200);
		$titre=$saga->getTitre();
		$acteurs=$saga->getActeurs($pro,7);
		$lien=url_for('saga/show?id='.$saga->getId());
		$id='s'.$saga->getId();
		$proprietaires=$saga->getProprietaires($pro);
	}else{
		if($video->getImage()!=""){
			$image='videos/'.$video->getImage();
		}else{
			$image='image_vide.jpeg';
		}
		$note=$video->getNoteMoyenne($pro);
		$resume=$video->getExtraitResume(200);
		$titre=$video->getTitre();
		$acteurs=$video->getActeurs(5);
		$lien=url_for('video/show?id='.$video->getId());
		$id='f'.$video->getId();
		$proprietaires=$video->getProprietaires();
	}
?>

    <table class="bloc_info center_bloc" cellpadding="1" cellspacing="1" border="0" class="sitetable" width="95%" onmouseover="style.cursor='pointer';" onclick="location.href='<?php echo $lien; ?>';">

        <tr>
            <td colspan="5" class="lien" valign="bottom" style="padding-left:5px;" >
				<h4><?php if($isSaga){echo $saga->getTitre();}else{echo $video->getTitre();} ?></h4><?php if($video->getSousTitre()!='' && !$isSaga){ echo ' - <i><b>'.$video->getSousTitre().'</b></i>'; } ?>
				<span class="haut">
					<span class="proprio">
						<?php
						foreach($proprietaires as $ind => $admin){
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
						<?php $pro=$sf_user->getAttribute("proprio"); ?>
						<b><span class="qualite"><?php if($isSaga && sizeof($saga->getFilms($pro))==3){ echo 'Trilogie'; }else if($isSaga){ echo 'Saga ( '.sizeof($saga->getFilms($pro)).' films )'; }else{ echo $video->getQualite(); } ?></span></b>
						
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
			
            <td COLSPAN=3>
				<a href="<?php echo $lien; ?>">
					<p class="justify">
						<?php echo $resume; if(strlen($resume)>200){ echo"..."; } ?>
					</p>
				</a>
            </td>
        </tr>
        <tr>
            <td valign="bottom" width="300" >
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
			<?php
			
			
				echo '<td valign="bottom" align="right" width="90" >';
				
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
					if($sf_user->getAttribute("login")){ 
						if($sf_user->getAttribute("admin")){ 
							if(!$isSaga){
								if(!$sf_user->getAttribute("login")->possede($video)){
					?>
									<a onmouseover="$('#imgplus_<?php echo $video->getId(); ?>').hide();$('#imgplusbis_<?php echo $video->getId(); ?>').show();return false;" onmouseout="$('#imgplusbis_<?php echo $video->getId(); ?>').hide();$('#imgplus_<?php echo $video->getId(); ?>').show();return false;" href="<?php echo url_for('video/ajoutProprio?id='.$video->getId()) ?>">
										<img id="imgplus_<?php echo $video->getId(); ?>" src="/images/plusProprio.gif" />
										<img class="invisible" id="imgplusbis_<?php echo $video->getId(); ?>" src="/images/plusPropriobis.gif" />
									</a>
					<?php 
								}else{
					?>
									<a onmouseover="$('#imgmoins_<?php echo $video->getId(); ?>').hide();$('#imgmoinsbis_<?php echo $video->getId(); ?>').show();return false;" onmouseout="$('#imgmoinsbis_<?php echo $video->getId(); ?>').hide();$('#imgmoins_<?php echo $video->getId(); ?>').show();return false;"  href="" onClick='validAction("<?php echo url_for('video/supprProprio?id='.$video->getId()) ?>","<?php echo $sf_user->getAttribute("login"); ?> ! \n Etes-vous sur de vouloir enlever le <?php echo $type; ?> \" <?php echo $video->getTitre(); ?> \" de votre collection ?");return false;'>
										<img id="imgmoins_<?php echo $video->getId(); ?>" src="/images/moinsProprio.gif" />
										<img class="invisible" id="imgmoinsbis_<?php echo $video->getId(); ?>" src="/images/moinsPropriobis.gif" />
									</a>
					<?php 
								}
							}else{
								if(!$sf_user->getAttribute("login")->possedeAllFilmSaga($saga)){
					?>
									<a onmouseover="$('#imgplus_s<?php echo $saga->getId(); ?>').hide();$('#imgplusbis_s<?php echo $saga->getId(); ?>').show();return false;" onmouseout="$('#imgplusbis_s<?php echo $saga->getId(); ?>').hide();$('#imgplus_s<?php echo $saga->getId(); ?>').show();return false;" href="" onClick='validAction("<?php echo url_for('video/ajoutProprio?ids='.$saga->getId()) ?>","<?php echo $sf_user->getAttribute("login"); ?>, &ecirc;tes-vous sur de vouloir ajouter tous les films de la saga \" <?php echo $saga->getTitre(); ?> \" &agrave; votre collection ?");return false;'>
										<img id="imgplus_s<?php echo $saga->getId(); ?>" src="/images/plusProprio.gif" />
										<img class="invisible" id="imgplusbis_s<?php echo $saga->getId(); ?>" src="/images/plusPropriobis.gif" />
									</a>
					<?php 
								}else{
					?>
									<a onmouseover="$('#imgmoins_<?php echo $saga->getId(); ?>').hide();$('#imgmoinsbis_<?php echo $saga->getId(); ?>').show();return false;" onmouseout="$('#imgmoinsbis_<?php echo $saga->getId(); ?>').hide();$('#imgmoins_<?php echo $saga->getId(); ?>').show();return false;"  href="" onClick='validAction("<?php echo url_for('video/supprProprio?ids='.$saga->getId()) ?>","<?php echo $sf_user->getAttribute("login"); ?> ! \n Etes-vous sur de vouloir enlever tous les films de la saga \" <?php echo $saga->getTitre(); ?> \" de votre collection ?");return false;'>
										<img id="imgmoins_<?php echo $saga->getId(); ?>" src="/images/moinsProprio.gif" />
										<img class="invisible" id="imgmoinsbis_<?php echo $saga->getId(); ?>" src="/images/moinsPropriobis.gif" />
									</a>
					<?php 
								}
							}
						} 
					}
				?>
				<?php echo $video->getVersion(); ?>
            </td>
        </tr>
    </table>
<?php } ?>

