<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

      <span id="fich" style="display:none;"><?php echo url_for('video/ajaxVerifExiste') ?></span>
      <span id="fichep" style="display:none;"><?php echo url_for('video/ajaxRealSaison') ?></span>
      <span id="lienvideo" style="display:none;"><?php echo url_for('video/index'); ?></span>
      <span id="liennewproprietaire" style="display:none;"><?php echo url_for('sf_guard_user/new'); ?></span>
      <span id="liennewcategorie" style="display:none;"><?php echo url_for('categorie/new'); ?></span>
      <span id="liennewpersonne" style="display:none;"><?php echo url_for('personne/new'); ?></span>
	  <span id="liennewversion" style="display:none;"><?php echo url_for('version/new'); ?></span>
	  <span id="liennewqualite" style="display:none;"><?php echo url_for('qualite/new'); ?></span>
	  <span id="liennewmotscle" style="display:none;"><?php echo url_for('motscle/new'); ?></span>
	  <span id="liennewsaga" style="display:none;"><?php echo url_for('saga/new'); ?></span>
	  

	  
<form action="<?php if ($form->getObject()->isNew()){echo url_for('video/index?type='.$sf_request->getParameter('type'));}else{echo url_for('video').'/'.$form->getObject()->getId();} ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> width="100%">
	<?php if (!$form->getObject()->isNew()){ ?>
		<input type="hidden" name="sf_method" value="put" />
	<?php }else if($form->getObject()->isNew()){ ?>
		<input type="hidden" id="new" value="1" />
	<?php } ?>
	<input type="hidden" id="type" name="type" value="<?php echo $sf_request->getParameter('type'); ?>" />
	<table>
		<tbody>
			<?php echo $form->renderGlobalErrors() ?>
			<?php echo $form ?>
		</tbody>
	</table>
	<div>
		<?php echo $form->renderHiddenFields(false) ?>
		<ul class="sf_admin_actions">
			<li class="sf_admin_action_list"><a href="<?php echo url_for('video/index?type='.$sf_request->getParameter('type')) ?>">Retour &agrave; la liste</a></li>
			<?php if (!$form->getObject()->isNew()): ?>
				<li class="sf_admin_action_delete">&nbsp;<?php echo link_to('Delete', 'video/delete?id='.$form->getObject()->getId().'&type='.$sf_request->getParameter('type'), array('method' => 'delete', 'confirm' => 'Es-tu s&ucirc;re?')) ?></li>
			<?php endif; ?>
				<li>
					<?php echo $helper->linkToSave($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save',  'label' => 'Enregistrer',)) ?>
				</li>
				<li>
					<?php echo $helper->linkToSaveAndAdd($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save_and_add',  'label' => 'Enregistrer et Ajouter',)) ?>
				</li>
		</ul>
	</div>
	<input type="hidden" id="acteur_ordre" name="acteur_ordre" value="<?php echo $acteur_ordre; ?>" />
	<?php if($sf_request->getParameter('type')=='episode'){ ?>
		<input type="hidden" id="der_insert_saison" name="der_insert_saison" value="<?php echo $der_insert_saison; ?>" />
		<input type="hidden" id="real_saison" name="real_saison" value="<?php echo $real_saison; ?>" />
		<script type="text/javascript">
				initRealSaison('#video_saison_id');
		</script>
	<?php } ?>
</form>