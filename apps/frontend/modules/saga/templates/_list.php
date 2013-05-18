
<?php foreach ($films as $i => $film){ ?>


<?php
    if($film->getImage()!=""){
        $image='videos/'.$film->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
    <table cellpadding="1" cellspacing="1" border="0" class="sitetable" width="100%">

        <tr>
            <td colspan="3" class="lien" valign="top" style="padding-left:5px;">
				<a href="<?php echo url_for('video/show?id='.$film->getId()) ?>">
					<h4><?php echo $film->getTitre() ?></h4><?php if($film->getTitreOfficiel()!=''){ echo ' - <i><b>'.$film->getTitreOfficiel().'</b></i>'; } ?>
					<span class="proprio">
						<?php
						foreach($film->getProprietaires() as $ind => $admin){
								$mar=-55-($ind*15);
								$martop=-30;
						?>
								<div id="div<?php echo $admin->getUsername().'_'.$film->getId(); ?>" class="blockProprio" style="margin-left:<?php echo $mar; ?>px;margin-top:<?php echo $martop; ?>px;">
									<b><?php echo $admin; ?></b> possede ce film
								</div>
								<img onmouseover="$('#div<?php echo $admin->getUsername().'_'.$film->getId(); ?>').show();return false;" onmouseout="$('#div<?php echo $admin->getUsername().'_'.$film->getId(); ?>').hide();return false;" style="float:right;" width="15" src="/images/<?php echo $admin->getUsername(); ?>.png"/>
						<?php
						}
						?>
					</span>
					<span style="float:right">
						<b><span class="qualite"><?php echo $film->getQualite(); ?></span></b>
					</span>
				</a>
            </td>
        </tr>
        <tr>
            <td valign="top" height="100%" ROWSPAN="2" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
				<a href="<?php echo url_for('video/show?id='.$film->getId()) ?>">
					<img src="/uploads/<?php echo $image; ?>" alt="<?php echo $film->getTitre(); ?>" height="100">
				</a>
            </td>
            <td COLSPAN=2>
				<a href="<?php echo url_for('video/show?id='.$film->getId()) ?>">
					<p class="justify">
						<font face="Arial"><?php echo $film->getExtraitResume(200); if(strlen($film->getResume())>200){ echo"..."; } ?></font>
					</p>
				</a>
            </td>
        </tr>
        <tr>
            <td valign="bottom" style="padding-bottom:5px;">
                <?php foreach($film->getActeurs(7) as $i => $acteur){ ?><?php if($acteur->getImage()!=""){ $imageA='acteurs/'.$acteur->getImage(); }else{ $imageA='image_vide.jpeg'; } ?><img style="padding-right:3px;" src="/uploads/<?php echo $imageA; ?>" width="30"/><?php } ?>
            </td>

            <td colspan="2" valign="bottom" align="right">
				<?php 
				if($sf_user->getAttribute("login")){ 
					if($sf_user->getAttribute("admin")){ 
						if(!$sf_user->getAttribute("login")->possede($film)){
					?>
									<a onmouseover="$('#imgplus_<?php echo $film->getId(); ?>').hide();$('#imgplusbis_<?php echo $film->getId(); ?>').show();return false;" onmouseout="$('#imgplusbis_<?php echo $film->getId(); ?>').hide();$('#imgplus_<?php echo $film->getId(); ?>').show();return false;" href="<?php echo url_for('video/ajoutProprio?id='.$film->getId().'&s='.$film->getSaga()->getId()); ?>">
										<img id="imgplus_<?php echo $film->getId(); ?>" src="/images/plusProprio.gif" />
										<img class="invisible" id="imgplusbis_<?php echo $film->getId(); ?>" src="/images/plusPropriobis.gif" />
									</a>
					<?php 
								}else{
					?>
									<a onmouseover="$('#imgmoins_<?php echo $film->getId(); ?>').hide();$('#imgmoinsbis_<?php echo $film->getId(); ?>').show();return false;" onmouseout="$('#imgmoinsbis_<?php echo $film->getId(); ?>').hide();$('#imgmoins_<?php echo $film->getId(); ?>').show();return false;"  href="" onClick='validAction("<?php echo url_for('video/supprProprio?id='.$film->getId().'&s='.$film->getSaga()->getId()); ?>","<?php echo $sf_user->getAttribute("login"); ?> ! \n Etes-vous sur de vouloir enlever le film \" <?php echo $film->getTitre(); ?> \" de votre collection ?");return false;'>
										<img id="imgmoins_<?php echo $film->getId(); ?>" src="/images/moinsProprio.gif" />
										<img class="invisible" id="imgmoinsbis_<?php echo $film->getId(); ?>" src="/images/moinsPropriobis.gif" />
									</a>
					<?php 
								}
					} 
				}
				?>
                <?php echo $film->getVersion(); ?>
            </td>
        </tr>
    </table>
<?php } ?>

