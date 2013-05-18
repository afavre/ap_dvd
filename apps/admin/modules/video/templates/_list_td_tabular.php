
<td class="sf_admin_text sf_admin_list_td_image">
  <?php echo get_partial('video/image', array('type' => 'list', 'video' => $video)) ?>
</td>

<td class="sf_admin_text sf_admin_list_td_type">
  <?php echo link_to($video->getType(), 'video_edit', $video) ?>
</td>
<?php if($type=="episode"){ ?>
	<td class="sf_admin_text sf_admin_list_td_serie">
	  <?php echo $video->getSaison()->getSerie() ?>
	</td>
	<td class="sf_admin_text sf_admin_list_td_saisonEp">
	  <?php echo $video->getSaison()->getNumero().' x '.$video->getNumeroTop() ?>
	</td>
<?php } ?>
<td class="sf_admin_text sf_admin_list_td_titre">
  <?php echo $video->getTitre() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_qualite">
  <?php echo $video->getQualite() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_version">
  <?php echo $video->getVersion() ?>
</td>
<?php if($type!="episode"){ ?>
	<td class="sf_admin_text sf_admin_list_td_duree">
	  <?php echo $video->getDuree() ?>
	</td>
	<td class="sf_admin_text sf_admin_list_td_annee_sortie">
	  <?php echo $video->getAnneeSortie() ?>
	</td>
<?php } ?>
<td class="sf_admin_text sf_admin_list_td_proprietaires">
  <?php echo get_partial('video/proprietaires', array('type' => 'list', 'video' => $video)) ?>
</td>
