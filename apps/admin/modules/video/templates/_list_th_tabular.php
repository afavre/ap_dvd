	<?php slot('sf_admin.current_header') ?>
	<th class="sf_admin_text sf_admin_list_th_image">
	  <?php if ('image' == $sort[0]): ?>
		<?php echo link_to(__('Image', array(), 'messages'), '@video', array('query_string' => 'sort=image&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
		<?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
	  <?php else: ?>
		<?php echo link_to(__('Image', array(), 'messages'), '@video', array('query_string' => 'sort=image&sort_type=asc')) ?>
	  <?php endif; ?>
	</th>
	<?php end_slot(); ?>
	<?php include_slot('sf_admin.current_header') ?>

<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_type">
  <?php if ('type' == $sort[0]): ?>
    <?php echo link_to(__('Type', array(), 'messages'), '@video', array('query_string' => 'sort=type&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Type', array(), 'messages'), '@video', array('query_string' => 'sort=type&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>

<?php if($type=="episode"){ ?>
	<?php slot('sf_admin.current_header') ?>
	<th class="sf_admin_text sf_admin_list_th_serie">
	  <?php echo __('Serie', array(), 'messages') ?>
	</th>
	<?php end_slot(); ?>
	<?php include_slot('sf_admin.current_header') ?>
	
	<?php slot('sf_admin.current_header') ?>
	<th class="sf_admin_text sf_admin_list_th_saisonEp">
	  <?php echo __('Saison x Numero', array(), 'messages') ?>
	</th>
	<?php end_slot(); ?>
	<?php include_slot('sf_admin.current_header') ?>
<?php } ?>

<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_titre">
  <?php if ('titre' == $sort[0]): ?>
    <?php echo link_to(__('Titre', array(), 'messages'), '@video', array('query_string' => 'sort=titre&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Titre', array(), 'messages'), '@video', array('query_string' => 'sort=titre&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>

<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_qualite">
  <?php echo __('Qualite', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>

<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_version">
  <?php echo __('Version', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>

<?php if($type!="episode"){ ?>
	<?php slot('sf_admin.current_header') ?>
	<th class="sf_admin_text sf_admin_list_th_duree">
	  <?php if ('duree' == $sort[0]): ?>
		<?php echo link_to(__('Duree', array(), 'messages'), '@video', array('query_string' => 'sort=duree&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
		<?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
	  <?php else: ?>
		<?php echo link_to(__('Duree', array(), 'messages'), '@video', array('query_string' => 'sort=duree&sort_type=asc')) ?>
	  <?php endif; ?>
	</th>
	<?php end_slot(); ?>
	<?php include_slot('sf_admin.current_header') ?>

	<?php slot('sf_admin.current_header') ?>
	<th class="sf_admin_text sf_admin_list_th_annee_sortie">
	  <?php if ('annee_sortie' == $sort[0]): ?>
		<?php echo link_to(__('Annee sortie', array(), 'messages'), '@video', array('query_string' => 'sort=annee_sortie&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
		<?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
	  <?php else: ?>
		<?php echo link_to(__('Annee sortie', array(), 'messages'), '@video', array('query_string' => 'sort=annee_sortie&sort_type=asc')) ?>
	  <?php endif; ?>
	</th>
	<?php end_slot(); ?>
	<?php include_slot('sf_admin.current_header') ?>
<?php } ?>

<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_proprietaires">
  <?php echo __('Proprietaires', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>