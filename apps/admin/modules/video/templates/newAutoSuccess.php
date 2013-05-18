<?php use_helper('I18N', 'Date') ?>
<?php include_partial('video/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Trouver les information d\'un film<span id="div_titre_rech" class="invisible"> - Recherche sur "<span id="titre_rech"></span>" </span>', array(), 'messages') ?></h1>

  <?php include_partial('video/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('video/form_header', array('form' => $form, 'configuration' => $configuration)) ?>
  </div>
 
  <div id="sf_admin_content">
    <?php include_partial('video/formAuto', array('form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
	<div class="clear">&nbsp;</div>	
		<div id="loader_film" class="invisible">
			<img src="/images/loader-admin.gif" />
		</div>
		<div id="divChoixFilm">
		
		</div>

	<div class="clear">&nbsp;</div>	
	<div>
		<ul class="sf_admin_actions">
			<li class="sf_admin_action_list"><a href="<?php echo url_for('video/index?type=film') ?>">Retour &agrave; la liste</a></li>
			<?php echo $helper->linkToNew(array(  'params' =>   array(  ),  'class_suffix' => 'new',  'label' => 'Formulaire vide',  'type' => $sf_request->getParameter('type'))); ?>
		</ul>
	</div> 
  </div>
  
  <script>
	$("#formRechercheAuto").submit();
  </script>

  <div id="sf_admin_footer">
    <?php include_partial('video/form_footer', array('form' => $form, 'configuration' => $configuration)) ?>
  </div>
  
</div>
