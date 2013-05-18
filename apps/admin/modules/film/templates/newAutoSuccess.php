<?php use_helper('I18N', 'Date') ?>
<?php include_partial('film/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Nouveau film', array(), 'messages') ?></h1>

  <?php include_partial('film/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('film/form_header', array('film' => $film, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
 
  <div id="sf_admin_content">
    <?php include_partial('film/form', array('der_insert_saison' => $der_insert_saison, 'real_saison' => $real_saison, 'acteur_ordre' => $acteur_ordre, 'film' => $film, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('film/form_footer', array('film' => $film, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
