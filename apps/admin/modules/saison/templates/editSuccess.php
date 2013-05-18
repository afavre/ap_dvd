<?php use_helper('I18N', 'Date') ?>
<?php include_partial('saison/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Modification Saison <span class="titredyn">"%%saison%%"</span>', array('%%saison%%' => $saison), 'messages') ?></h1>

  <?php include_partial('saison/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('saison/form_header', array('saison' => $saison, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('saison/form', array('real_serie' => $real_serie, 'acteur_ordre' => $acteur_ordre, 'saison' => $saison, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('saison/form_footer', array('saison' => $saison, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
