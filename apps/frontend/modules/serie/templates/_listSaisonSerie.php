<?php foreach ($series as $i => $serie){ ?>

<?php
    if($serie->getImage()!=""){
        $image='series/'.$serie->getImage();
    }else{
        $image='image_vide.jpeg';
    }
	
	$proprietaires=$serie->getProprietaires();
?>
<a href="<?php echo url_for('serie/show?id='.$serie->getId()) ?>">
    <table class="bloc_info center_bloc"  cellpadding="1" cellspacing="1" border="0" class="sitetable" width="95%">
        <tr>
            <td colspan="5" class="lien" valign="bottom" style="padding-left:5px;" >
				<h4><?php echo $serie->getTitre(); ?></h4>
				<span class="haut">
					<span class="proprio">
						<?php
						foreach($proprietaires as $ind => $admin){
							$mar=-65-($ind*15);
							$martop=-43;
						?>
							<div id="div<?php echo $admin->getUsername().'_'.$id; ?>" class="blockProprio" style="margin-left:<?php echo $mar; ?>px;margin-top:<?php echo $martop; ?>px;">
								<b><?php echo $admin; ?></b> <?php echo 'possede au moins un épisode de cette serie'; ?>
							</div>
							<img onmouseover="$('#div<?php echo $admin->getUsername().'_'.$id; ?>').show();return false;" onmouseout="$('#div<?php echo $admin->getUsername().'_'.$id; ?>').hide();return false;" style="float:right;" width="15" src="/images/<?php echo $admin->getUsername(); ?>.png"/>
						<?php
						}
						?>
					</span>
					<span class="qualite">
						<?php $pro=$sf_user->getAttribute("proprio"); ?>
						<b><span class="qualite">
							<?php 
							if(sizeof($serie->getSaisons())>1){
								echo 'Saisons: ';
							}else if(sizeof($serie->getSaisons())==1){
								echo 'Saison: ';
							}else{
								echo 'Aucune saison';
							}
							foreach($serie->getSaisons() as $i => $saison){
								if($i!=0){
									echo ', ';
								}
								echo $saison->getNumero();
							}
							?>
						</span></b>
					</span>
				</span>
			</td>
        </tr>
        <tr>
            <td valign="top" height="100%" ROWSPAN="2" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
                <img src="/uploads/<?php echo $image; ?>" alt="<?php echo $serie->getTitre(); ?>" height="100">
            </td>
            <td valign="top">
                <p>
                    <font face="Arial"><?php echo $serie->getExtraitResume(); if(strlen($serie->getResume())>160){ echo"..."; } ?></font>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="bottom" style="padding-bottom:5px;">
                <?php foreach($serie->getActeurs(5) as $i => $acteur){ ?><?php if($serie->getImage()!=""){ $imageA='personnes/'.$acteur->getImage(); }else{ $imageA='image_vide.jpeg'; } ?><img style="padding-right:3px;" src="/uploads/<?php echo $imageA; ?>" width="30"/><?php } ?>
            </td>

        </tr>
    </table>
</a>
<?php } ?>

