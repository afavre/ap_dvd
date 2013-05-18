<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>


      <span id="fich" style="display:none;"><?php echo 'http://'.$_SERVER['HTTP_HOST'].url_for('spectacle/ajaxVerifExiste') ?></span>
      <span id="lienspectacle" style="display:none;"><?php echo url_for('spectacle'); ?></span>
      <span id="liennewproprietaire" style="display:none;"><?php echo url_for('sf_guard_user/new'); ?></span>
      <span id="liennewcategorie" style="display:none;"><?php echo url_for('categorie/new'); ?></span>
	  <span id="liennewauteur" style="display:none;"><?php echo url_for('personne/new'); ?></span>
	  <span id="liennewqualite" style="display:none;"><?php echo url_for('qualite/new'); ?></span>
	  <span id="liennewmotscle" style="display:none;"><?php echo url_for('motscle/new'); ?></span>
 
<form action="<?php if ($form->getObject()->isNew()){echo url_for('spectacle');}else{echo url_for('spectacle').'/'.$form->getObject()->getId();} ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> width="100%">
	<?php if (!$form->getObject()->isNew()){ ?>
		<input type="hidden" name="sf_method" value="put" />
	<?php }else if($form->getObject()->isNew()){ ?>
		<input type="hidden" id="new" value="1" />
	<?php } ?>
	<table>
		<tbody>
			<?php echo $form->renderGlobalErrors() ?>
			<?php echo $form ?>
		</tbody>
	</table>
	<div>
		<?php echo $form->renderHiddenFields(false) ?>
		<ul class="sf_admin_actions">
			<li class="sf_admin_action_list"><a href="<?php echo url_for('spectacle/index') ?>">Retour &agrave; la liste</a></li>
			<?php if (!$form->getObject()->isNew()): ?>
				<li class="sf_admin_action_delete">&nbsp;<?php echo link_to('Delete', 'spectacle/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Es-tu s&ucirc;re?')) ?></li>
			<?php endif; ?>
			<li><input type="submit" value="Enregistrer" /></li>
		</ul>
	</div>
	<script type="text/javascript">
		
			//verifExisteFilm('#spectacle_titre','1');
		    
	</script>
</form>