<td style="border-bottom:2px solid transparent;height:30px;">
	<?php include_stylesheets_for_form($form[$i]) ?>
	<?php include_javascripts_for_form($form[$i]) ?>
	<form id="formEp<?php echo $episode->getId(); ?>" onSubmit="envoiFormEditAjax(this,'<?php echo $episode->getId(); ?>');return false;" action="<?php echo url_for('video/update?id='.$form[$i]->getObject()->getId()) ?>" method="post" <?php $form[$i]->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	<input type="hidden" name="sf_method" value="put" />
		<table width="100%" CELLSPACING="0" >
			<tr>
				<td style="width:31px;">
					<span>
<?php
						$ind=0;
						$allProprio = $sf_request->getAttribute('proprio');
						$nbP=0;
						foreach($allProprio as $admin){
							$moins='invisible';
							$plus='invisible';
							if($admin->possede($episode)){
								$nbP++;
								$mar=27-($ind*15);
								$martop=-38;
								$ind++;
								$class = '';
								if($sf_user->getAttribute("login")){
									if($sf_user->getAttribute("login")->getId()==$admin->getId()){
										$moins='';
										$plus='invisible';
										$class = 'invisible';
									}
								}
							}else{
								$class = 'invisible';
								if($sf_user->getAttribute("login")){
									if($sf_user->getAttribute("login")->getId()==$admin->getId()){
										$moins='invisible';
										$plus='';
									}
								}
							}
							if($sf_user->getAttribute("login")->getId()==$admin->getId()){
?>
							<input id="nbP<?php echo $episode->getId(); ?>" type="hidden" value="<?php echo $nbP; ?>" />
							<img style="float:right;" id="loader<?php echo $episode->getId(); ?>" src="/images/loader.gif" class="invisible" height="16" />
							<a id="plus<?php echo $episode->getId(); ?>" class="<?php echo $plus; ?>" onClick="AjouterVideo(this,'<?php echo $episode->getId(); ?>','<?php echo $sf_user->getAttribute("login")->getId(); ?>',event);finAjoutEp(<?php echo $episode->getId(); ?>);return false;" href="<?php echo url_for('video/ajoutProprio?id='.$episode->getId()) ?>" onmouseover="$('#imgplus_<?php echo $episode->getId(); ?>').hide();$('#imgplusbis_<?php echo $episode->getId(); ?>').show();return false;" onmouseout="$('#imgplusbis_<?php echo $episode->getId(); ?>').hide();$('#imgplus_<?php echo $episode->getId(); ?>').show();return false;" >
								<img style="float:right;" id="imgplus_<?php echo $episode->getId(); ?>" src="/images/plusProprio.gif" />
								<img style="float:right;" class="invisible" id="imgplusbis_<?php echo $episode->getId(); ?>" src="/images/plusPropriobis.gif" />
							</a>
							<a id="moins<?php echo $episode->getId(); ?>" class="<?php echo $moins; ?>" onClick="EnleverVideo(this,'<?php echo $episode->getId(); ?>','<?php echo $sf_user->getAttribute("login")->getId(); ?>',event,'<?php echo $sf_user->getAttribute("login"); ?> ! \n Etes-vous sur de vouloir enlever cette episode de votre collection ?');finEnleveEp(<?php echo $episode->getId(); ?>);return false;" href="<?php echo url_for('video/supprProprio?id='.$episode->getId()) ?>" onmouseover="$('#imgmoins_<?php echo $episode->getId(); ?>').hide();$('#imgmoinsbis_<?php echo $episode->getId(); ?>').show();return false;" onmouseout="$('#imgmoinsbis_<?php echo $episode->getId(); ?>').hide();$('#imgmoins_<?php echo $episode->getId(); ?>').show();return false;" >
								<img style="float:right;" id="imgmoins_<?php echo $episode->getId(); ?>" src="/images/moinsProprio.gif" />
								<img style="float:right;" class="invisible" id="imgmoinsbis_<?php echo $episode->getId(); ?>" src="/images/moinsPropriobis.gif" />
							</a>
<?php 
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
				<td style="<?php if($sf_user->getAttribute("admin")){ echo 'width:290px;'; }else{ echo 'width:320px;'; } ?>">
<?php
					echo $form[$i]['titre']->render(array('value' => $episode->getTitre(),'class' => 'titreEp'));
?>
				</td>
				<td style="width:65px;">
<?php
					echo $form[$i]['qualite_id']->render(array('value' => $episode->getQualite(),'class' => 'qualiteEp'));
?>
				</td>
				<td align="right" style="width:80px;">
<?php
					echo $form[$i]['version_id']->render(array('value' => $episode->getVersion(),'class' => 'versionEp'));
?>
				</td>
				<td align="right" style="width:30px;">
					<span class="invisible">
<?php
						echo $form[$i]['id']->render();
						echo $form[$i]['type']->render();
						echo $form[$i]['_csrf_token']->render();
						echo $form[$i]['realisateur_id']->render();
						echo $form[$i]['saison_id']->render();
						echo $form[$i]['numero']->render();
						echo $form[$i]['videoproprietaire_list']->render();
?>
					</span>
					<a>
						<input class="imgEdit" type="image" src="/images/edit.png" alt="modifer" width="25" />
						<img style="margin-right:5px;margin-top:5px;margin-bottom:5px;" class="imgLoader invisible" src="/images/loaderSmall.gif" width="15" />
					</a>
					<!--
					onClick="$('#editEp<?php //echo $episode->getId(); ?>').hide();$('#visEp<?php //echo $episode->getId(); ?>').show();return false;"
					-->
				</td>
			</tr>
		</table>
	</form>
</td>