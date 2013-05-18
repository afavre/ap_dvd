<td style="border-bottom:2px solid transparent;height:30px;">
	<table width="100%" CELLSPACING="0">
		<tr>
			<td style="width:31px;">
				<span>
					<?php
					$ind=0;
					$allProprio = $sf_request->getAttribute('proprio');
					foreach($allProprio as $admin){
						if($admin->possede($episode)){
							$mar=27-($ind*15);
							$martop=-38;
							$ind++;
							$class = '';
						}else{
							$class = 'invisible';
						}
					?>
					<span id="boule<?php echo $episode->getId().'_'.$admin->getId(); ?>" class="<?php echo $class; ?>">
						<div id="div<?php echo $admin->getUsername().'_'.$episode->getId(); ?>" class="blockProprio" style="margin-left:<?php echo $mar; ?>px;margin-top:<?php echo $martop; ?>px;">
							<b><?php echo $admin; ?></b> possede cette episode
						</div>
						<img onmouseover="$('#div<?php echo $admin->getUsername().'_'.$episode->getId(); ?>').show();return false;" onmouseout="$('#div<?php echo $admin->getUsername().'_'.$episode->getId(); ?>').hide();return false;" style="float:right;" width="15" src="/images/<?php echo $admin->getUsername(); ?>.png"/>
					</span>
					<?php
					}
					?>
				</span>
			</td>
			<td style="width:40px;">
				<?php echo '<b>'.$episode->getSaison()->getNumero().'</b> x <b>'.$episode->getNumeroTop().'</b>' ?>
			</td>
			<td style="<?php if($sf_user->getAttribute("admin")){ echo 'width:290px;'; }else{ echo 'width:320pxpx;'; } ?>">
				- <i><span class="titreEp"><?php echo $episode->getTitre() ?></span></i>
			</td>
			<td style="width:65px;">
				<?php
				if($sf_user->getAttribute("admin")){
					foreach($qualites as $q){
						if($episode->getQualite()==$q){
							$classQua='';
						}else{
							$classQua='invisible';
						}
				?>
						<span class="qualiteEp qualiteEp<?php echo $q->getId(); ?> <?php echo $classQua; ?>">
							<i>
								<?php
								$mar2=53;
								$martop2=-73;
								$js=' onmouseover="$(\'#divDesc'.$episode->getId().'_'.$q->getId().'\').show();return false;" onmouseout="$(\'#divDesc'.$episode->getId().'_'.$q->getId().'\').hide();return false;"';
								?>
								<?php echo $q; ?><img style="padding-left:2px;padding-bottom:4px;" <?php echo $js; ?> width="10" src="/images/infos.png" />
								<div id="divDesc<?php echo $episode->getId().'_'.$q->getId(); ?>" class="blockComment" style="margin-left:<?php echo $mar2; ?>px;margin-top:<?php echo $martop2; ?>px;width:170px;">
									<?php if($q->getDescription()!=''){ echo $q->getDescription(); }else{ echo '...'; } ?>
								</div>
							</i>
						</span>
			<?php
					}
				}else{
			?>
				<span class="qualiteEp">
					<i>
						<?php
						$mar2=53;
						$martop2=-73;
						$js=' onmouseover="$(\'#divDesc'.$episode->getId().'_'.$episode->getQualite()->getId().'\').show();return false;" onmouseout="$(\'#divDesc'.$episode->getId().'_'.$episode->getQualite()->getId().'\').hide();return false;"';

						?>
						<?php echo $episode->getQualite(); ?><img style="padding-left:2px;padding-bottom:4px;" <?php echo $js; ?> width="10" src="/images/infos.png" />

						<div id="divDesc<?php echo $episode->getId().'_'.$episode->getQualite()->getId(); ?>" class="blockComment" style="margin-left:<?php echo $mar2; ?>px;margin-top:<?php echo $martop2; ?>px;width:170px;">

							<?php if($episode->getQualite()->getDescription()!=''){ echo $episode->getQualite()->getDescription(); }else{ echo '...'; } ?>

						</div>
					</i>
				</span>
			<?php
			}
			?>


			</td>
			<td align="right" style="width:80px;">
				<?php
				if($sf_user->getAttribute("admin")){
					foreach($versions as $v){
						if($episode->getVersion()==$v){
							$classVer="";
						}else{
							$classVer="invisible";
						}
						echo '<span class="versionEp versionEp'.$v->getId().' '.$classVer.'"><b>'.$v.'</b></span>';
					}
				}else{
					echo '<span class="versionEp"><b>'.$episode->getVersion().'</b></span>';
				}
				?>
			</td>
			<?php if($sf_user->getAttribute("admin") && $sf_user->getAttribute("login")){ ?>
				<td align="right" style="width:30px;">
					<a href="" onClick="$('.edit').hide();$('.new').hide();$('.vis').show();$('.visnot').show();$('#visEp<?php echo $episode->getId(); ?>').hide();$('#editEp<?php echo $episode->getId(); ?>').show();return false;">
						<img src="/images/edit.png" width="25"/>
					</a>
				</td>
			<?php } ?>
		</tr>
	</table>
</td>