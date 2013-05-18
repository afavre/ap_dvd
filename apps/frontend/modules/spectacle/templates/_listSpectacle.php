
<?php foreach ($spectacles as $i => $spectacle){ ?>


<?php
	
	$pro=$sf_user->getAttribute("proprio");
	if($spectacle->getImage()!=""){
		$image='spectacles/'.$spectacle->getImage();
	}else{
		$image='image_vide.jpeg';
	}
	$resume=$spectacle->getExtraitResume(200);
	$titre=$spectacle->getTitre();
	$lien=url_for('spectacle/show?id='.$spectacle->getId());
	$id='f'.$spectacle->getId();
	$proprietaires=$spectacle->getProprietaires();
?>

    <table cellpadding="1" cellspacing="1" border="0" class="sitetable" width="100%" onmouseover="this.style.backgroundColor='#dbceb0';$(this).css('border','1px solid white');style.cursor='pointer';" onMouseOut="this.style.backgroundColor='';$(this).css('border','1px dotted #c2c2c2');" onclick="location.href='<?php echo $lien; ?>';">

        <tr>
            <td colspan="5" class="lien" valign="bottom" style="padding-left:5px;" >
				<h4><?php echo $spectacle->getTitre(); ?></h4><?php if($spectacle->getTitreOfficiel()!=''){ echo ' - <i><b>'.$spectacle->getTitreOfficiel().'</b></i>'; } ?>
				<span class="haut">
					<span class="proprio">
						<?php
						foreach($proprietaires as $ind => $admin){
								$mar=-65-($ind*15);
								if($isSaga){
									$martop=-43;
								}else{
									$martop=-30;
								}
						?>
								<div id="div<?php echo $admin->getUsername().'_'.$id; ?>" class="blockProprio" style="margin-left:<?php echo $mar; ?>px;margin-top:<?php echo $martop; ?>px;">
									<b><?php echo $admin; ?></b> possede ce spectacle								</div>
								<img onmouseover="$('#div<?php echo $admin->getUsername().'_'.$id; ?>').show();return false;" onmouseout="$('#div<?php echo $admin->getUsername().'_'.$id; ?>').hide();return false;" style="float:right;" width="15" src="/images/<?php echo $admin->getUsername(); ?>.png"/>
						<?php
						}
						?>
					</span>
					<span class="qualite">
						<b><span class="qualite"><?php echo $spectacle->getQualite(); ?></span></b>
					</span>
				</span>
			</td>
        </tr>
        <tr>
            <td valign="top" height="100%" <?php if(strlen($resume)==0){ echo 'width="80"'; } ?> ROWSPAN="2" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
				<a href="<?php echo $lien; ?>">
					<img src="/uploads/<?php echo $image; ?>" alt="<?php echo $titre; ?>" height="100">
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
            <td valign="bottom" style="padding-bottom:5px;" width="400" >
            </td>
			<?php
			
			
				echo '<td valign="bottom" align="right" width="90" >';
				$note=$spectacle->getNoteMoyenne($pro);
				$vote=floor($note);
				if (!$vote){ // Si $vote = false, alors aucune note n'ai prise en compte � l'affichage
					/*
					 for ($i=1;$i<=10;$i+=2){
						echo '<div style="" id="starnot_'.$i.'" class="starnot"></div>';
						$ii=$i+1;
						echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
					 }
					 */
				}else{
					for ($i=1;$i<=$vote;$i+=2){ // de 1 � $vote �toiles (+1 si impaire)
						echo '<div style="" id="starnot_'.$i.'" class="star_hovernot"></div>';
						$ii=$i+1;
						 if ($i<$vote){
							echo '<div style="" id="starnot_'.($i+1).'" class="star_hovernot"></div>';
						 }else{
							echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
						 }
					}
					for ($i;$i<=10;$i+=2){ // de ($vote (+1 si impaire)) $i � 10
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
								if(!$sf_user->getAttribute("login")->possedeSpectacle($spectacle)){
					?>
									<a onmouseover="$('#imgplus_<?php echo $spectacle->getId(); ?>').hide();$('#imgplusbis_<?php echo $spectacle->getId(); ?>').show();return false;" onmouseout="$('#imgplusbis_<?php echo $spectacle->getId(); ?>').hide();$('#imgplus_<?php echo $spectacle->getId(); ?>').show();return false;" href="<?php echo url_for('spectacle/ajoutProprio?id='.$spectacle->getId()) ?>">
										<img id="imgplus_<?php echo $spectacle->getId(); ?>" src="/images/plusProprio.gif" />
										<img class="invisible" id="imgplusbis_<?php echo $spectacle->getId(); ?>" src="/images/plusPropriobis.gif" />
									</a>
					<?php 
								}else{
					?>
									<a onmouseover="$('#imgmoins_<?php echo $spectacle->getId(); ?>').hide();$('#imgmoinsbis_<?php echo $spectacle->getId(); ?>').show();return false;" onmouseout="$('#imgmoinsbis_<?php echo $spectacle->getId(); ?>').hide();$('#imgmoins_<?php echo $spectacle->getId(); ?>').show();return false;"  href="" onClick='validAction("<?php echo url_for('spectacle/supprProprio?id='.$spectacle->getId()) ?>","<?php echo $sf_user->getAttribute("login"); ?> ! \n Etes-vous sur de vouloir enlever le spectacle \" <?php echo $spectacle->getTitre(); ?> \" de votre collection ?");return false;'>
										<img id="imgmoins_<?php echo $spectacle->getId(); ?>" src="/images/moinsProprio.gif" />
										<img class="invisible" id="imgmoinsbis_<?php echo $spectacle->getId(); ?>" src="/images/moinsPropriobis.gif" />
									</a>
					<?php 
								}
							
						} 
					}
				?>
            </td>
        </tr>
    </table>
<?php } ?>

