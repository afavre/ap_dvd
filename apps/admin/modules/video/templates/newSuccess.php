<?php use_helper('I18N', 'Date') ?>
<?php include_partial('video/assets') ?>



<div id="sf_admin_container">
  <h1><?php 
	if($type=='film' || $type==''){
		echo __('Nouveau Film', array(), 'messages');
	}else if($type=='spectacle'){
		echo __('Nouveau Spectacle', array(), 'messages');
	}else if($type=='episode'){
		echo __('Nouvel Episode', array(), 'messages');
	}else{
		echo __('Nouvelle Video', array(), 'messages');
	}
?>
	<a class="sf_admin_action_search" href="<?php echo url_for('video/newAuto?type=film'); ?>">
<?php
	if($_REQUEST['c']){
		echo 'Effectuer une nouvelle recherche';
	}else{
		echo 'Effectuer une recherche';
	}
?>
	</a>
  </h1>
  <div id="galerie_img" class="invisible">
  <?php 
		if(isset($liste_images) && sizeof($liste_images)>1){ 
			$style_width='';
			if(sizeof($liste_images)>3){
				$coupe = sizeof($liste_images)/2;
			}else{
				$coupe = sizeof($liste_images);
			}
			$width = 20+($coupe*108);	
			$style_width = 'max-width:'.$width.'px;';
  ?>
		<div style="<?php echo $style_width; ?>" class="list_photo list_img100_by">
			<div id="info_galerie">
				<ul>
			<?php 
					foreach($liste_images as $i => $img){
						$pos_code_1 = strpos($img, "medias/nmedia/");
						$pos_code_2 = strlen($img);
						if ($pos_code_1 && $pos_code_2) {
							$pos_code_1+=strlen("medias/nmedia/");
							$fin_img = substr($img,$pos_code_1,$pos_code_2 - $pos_code_1);
							/*
							preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $img, $url_ary);
							$titre_img = substr($url_ary[4],strrpos($url_ary[4],"/")+1);
							echo $titre_img.' yy';
							$titre_img = $tab_titre_img[sizeof($tab_titre_img)-1];
							$tab_titre_img_code = explode(".",$titre_img);
							$name = $tab_titre_img_code[0];
							$extension = $tab_titre_img_code[1];
							$titre_img_code = sha1($name.rand(11111, 99999)).'.'.$extension;
							*/
							$sel='';
							if($i==0){
								$sel="img_sel";
							}
					?>
					<li>
						<a class="lien_photo" href="<?php echo url_for('video/changerImageAjax'); ?>" onClick="changerImage(this, '<?php echo $img; ?>', '<?php echo $video->getImage(); ?>'); return false;">
						<img class="thumb <?php echo $sel; ?>" src="http://fr.web.img1.acsta.net/c_100_133/b_1_d6d6d6/medias/nmedia/<?php echo $fin_img ?>" />
						</a>
					</li>
					<?php
						}
					?>
			<?php } ?>
				</ul>
			<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	<?php } ?>
	</div>
	<div id="liste_ba" class="invisible">
		<?php if(isset($liste_bandes_annonce) && sizeof($liste_bandes_annonce)>0){ ?>
			<div class="list_img100_by">
				<div id="info_bandes_annonce">
					<ul>
				<?php 
						foreach($liste_bandes_annonce as $i => $ba){
						?>
						<li class="centre thumb">
							<div class="centre lien_video" href="<?php echo $ba['lien']; ?>" onClick="changerBA(this,'<?php echo $ba['lien']; ?>');return false;" onMouseOver="$(this).css('cursor','pointer');">
								<?php echo html_entity_decode($ba['titre']); ?>
							</div>
							<object width="300" height="220">
								<param name="movie" value="<?php echo $ba['lien']; ?>"></param>
								<param name="allowFullScreen" value="true"></param>
								<param name="allowScriptAccess" value="always"></param>
								<embed src="<?php echo $ba['lien']; ?>" type="application/x-shockwave-flash" width="280" height="200" allowFullScreen="true" allowScriptAccess="always"/>
							</object>
						</li>
				<?php } ?>
					</ul>
				<div class="clear"></div>
				</div>
			<div class="clear"></div>
			</div>
	  <?php } ?>
	</div>
  <?php include_partial('video/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('video/form_header', array('video' => $video, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
 
  <div id="sf_admin_content">
    <?php include_partial('video/form', array('der_insert_saison' => $der_insert_saison, 'real_saison' => $real_saison, 'acteur_ordre' => $acteur_ordre, 'video' => $video, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>
  <script>
	$("#video_titre").keyup();
  </script>

  <div id="sf_admin_footer">
    <?php include_partial('video/form_footer', array('video' => $video, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
