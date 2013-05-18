<?php use_helper('I18N', 'Date') ?>
<?php include_partial('video/assets') ?>

<div id="sf_admin_container">
	<?php
	if($type=="episode"){
		$text = __('Modification Episode <span class="titredyn">"%%serie%% %%numsaison%% x %%numepisode%% - %%titre%%"</span>', array('%%serie%%' => $video->getSaison()->getSerie(), '%%numsaison%%' => $video->getSaison()->getNumero(), '%%numepisode%%' => $video->getNumeroTop(), '%%titre%%' => $video->getTitre()), 'messages');
	}else{
		$text = __('Modification '.$type.' <span class="titredyn">"%%titre%%"</span>', array('%%titre%%' => $video->getTitre()), 'messages');
	}
	?>
  <h1><?php echo $text; ?></h1>

  <?php include_partial('video/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('video/form_header', array('video' => $video, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('video/form', array('real_saison' => $real_saison, 'acteur_ordre' => $acteur_ordre, 'video' => $video, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('video/form_footer', array('video' => $video, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
