<td style="border-bottom:2px solid transparent;height:30px;">
<?php
		include_stylesheets_for_form($form[$i]);
		include_javascripts_for_form($form[$i]);
?>
	<form id="formEp<?php echo $i; ?>" onSubmit="envoiFormNewAjax(this,'<?php echo $i; ?>');return false;" action="<?php echo url_for('video/create') ?>" method="post" <?php $form[$i]->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
		<input type="hidden" id="type" name="type" value="episode" />
		<table width="100%" CELLSPACING="0" >
			<tr>
				<td style="width:31px;"> 
				</td>
				<td style="width:40px;">
<?php 
						echo '<b>'.$saison->getNumero().'</b> x <b>'.$saison->getChiffreTop($i).'</b>' ?>
				</td>
				<td style="<?php if($sf_user->getAttribute("admin")){ echo 'width:290px;'; }else{ echo 'width:320px;'; } ?>">
<?php
					echo $form[$i]['titre']->render(array('class' => 'titreEp'));
?>
				</td>
				<td style="width:65px;">
<?php
					echo $form[$i]['qualite_id']->render(array('class' => 'qualiteEp'));
?>
				</td>
				<td align="right" style="width:80px;">
<?php
					echo $form[$i]['version_id']->render(array('class' => 'versionEp'));
?>
				</td>
				<?php if($sf_user->getAttribute("admin")){ ?>
				<td align="right" style="width:30px;">
					<span class="invisible">
<?php
						echo $form[$i]['type']->render();
						echo $form[$i]['_csrf_token']->render();
						echo $form[$i]['realisateur_id']->render();
						echo $form[$i]['saison_id']->render();
						echo $form[$i]['numero']->render();
						//echo $form[$i]['videoproprietaire_list']->render();
?>
					</span>
					<a>
						<input class="imgNew" type="image" src="/images/new.png" alt="modifer" width="25" />
						<img style="margin-right:5px;margin-top:5px;margin-bottom:5px;" class="imgLoader invisible" src="/images/loaderSmall.gif" width="15" />
					</a>
				</td>
				<?php } ?>
			</tr>
		</table>
	</form>
</td>	