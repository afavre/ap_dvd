<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

      <span id="liensaison" style="display:none;"><?php echo url_for('saison/index'); ?></span>
      <span id="liennewproprietaire" style="display:none;"><?php echo url_for('sf_guard_user/new'); ?></span>
      <span id="liennewcategorie" style="display:none;"><?php echo url_for('categorie/new'); ?></span>
      <span id="liennewpersonne" style="display:none;"><?php echo url_for('personne/new'); ?></span>
	  <span id="liennewversion" style="display:none;"><?php echo url_for('version/new'); ?></span>
	  <span id="liennewqualite" style="display:none;"><?php echo url_for('qualite/new'); ?></span>
	  <span id="liennewmotscle" style="display:none;"><?php echo url_for('motscle/new'); ?></span>
	  <span id="liennewsaga" style="display:none;"><?php echo url_for('saga/new'); ?></span>

<form action="<?php if ($form->getObject()->isNew()){echo url_for('saison/index');}else{echo url_for('saison').'/'.$form->getObject()->getId();} ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> width="100%">
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
			<li class="sf_admin_action_list"><a href="<?php echo url_for('saison/index') ?>">Retour &agrave; la liste</a></li>
			<?php if (!$form->getObject()->isNew()): ?>
				<li class="sf_admin_action_delete">&nbsp;<?php echo link_to('Delete', 'saison/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Es-tu s&ucirc;re?')) ?></li>
			<?php endif; ?>
			<li><input type="submit" value="Enregistrer" /></li>
		</ul>
	</div> 
	<input type="hidden" id="real_serie" name="real_serie" value="<?php echo $real_serie; ?>" />
	<input type="hidden" id="acteur_ordre" name="acteur_ordre" value="<?php echo $acteur_ordre; ?>" />
	<script type="text/javascript">
		initRealSerie('#saison_serie_id');
	</script>
</form>