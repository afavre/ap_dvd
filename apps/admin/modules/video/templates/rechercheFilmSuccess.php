<?php if(isset($tab_film) && sizeof($tab_film)>0){ ?>
	<?php
		$maxh = 100;
		$maxw = 75;
	?>
	<?php
	foreach($tab_film as $film){
		$img = '';
		if(substr($film['url_img'], -3, 3)!='gif'){
			$img = '&i='.$film['url_img'];
		}
	?>
		<a href="<?php echo url_for('video/CeationFilmAuto?c='.$film['code'].'&type=film'.$img); ?>" onClick="$('#loader').show();">
		<div class="divFilm">
				<?php
					list($width, $height, $type, $attr) = getimagesize($film['url_img']);
					$h = $height;
					if($height>$maxh){
						$h = $maxh;
					}
					$w = $width;
					if($width>$maxw){
						$w = $maxw;
					}
					$margt = ($maxh - $h) / 2;
					$margl = ($maxw - $w) / 2;
				?>
				<div class="image" >
					<img style="margin-top:<?php echo $margt; ?>px; margin-left:<?php echo $margl; ?>px;" width="<?php echo $w; ?>" height="<?php echo $h; ?>" src="<?php echo $film['url_img']; ?>" />
				</div>
				<div class="text">
					<div class="titre_rech">
						<?php 
							$titre_film = $film['titre'];
							$pos_init = 0;
							do{
								$pos1 = stripos($titre_film, $titre, $pos_init);
								if($pos1 || $pos1===0){
									$pos2 = $pos1+strlen($titre);
									$titre_film = substr_replace($titre_film, '</b>', $pos2, 0);
									$titre_film = substr_replace($titre_film, '<b>', $pos1, 0);
									$pos_init = $pos2;
									$pos = stripos($titre_film, $titre.' ', $pos_init);
								}
							}while(($pos || $pos===0) && $pos>$pos1);
							echo substr($titre_film, 0, 120); if(strlen($titre_film)>120){ echo '...'; } 
						?>
					</div>
					<br/>
					<div class="cast_rech">
						<?php 
							if($film['realisateur']!=''){
								echo '<i>de</i> '.substr($film['realisateur'], 0, 120); if(strlen($film['realisateur'])>120){ echo '...'; } 
								echo '<br/>';
							}
						?>
						<?php 
							if($film['acteurs']!=''){
								echo '<i>avec</i> '.substr($film['acteurs'], 0, 120); if(strlen($film['acteurs'])>120){ echo '...'; } 
							}
						?>
					</div>
				</div>
		</div>
		</a>
	<?php } ?>
<?php }else{ ?>
	<div class="aucun"><i><?php echo utf8_encode('Aucun film trouvé pour "'.$titre.'"'); ?></i></div>
<?php } ?>
