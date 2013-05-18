<?php slot('title') ?>
  <?php echo $spectacle->getTitre(); ?>
<?php end_slot(); ?>

<?php use_helper('Text') ?>





<?php
    if($spectacle->getImage()!=""){
        $image='spectacles/'.$spectacle->getImage();
    }else{
        $image='image_vide.jpeg';
    }
	$val=297;
	$val2=$val+8;
	$tailleInfos=$val.'px';
	$allNote=$spectacle->getNoteAdmin();


?>
        <h1 class="titreF">
			<table width="100%">
				<tr>
					<td>
						<div id="titreFilm">
							<img id="1gris" src="/images/videobis.png" />
							<?php echo $spectacle->getTitre();
							if($spectacle->getTitreOfficiel()){
								echo '<span id="titreFilmO"><i> - '.$spectacle->getTitreOfficiel().'</i></span>';
							}
							?>
						</div>
					</td>
					<td align="top" id="duree" >
						<?php echo $spectacle->getDuree(); ?> min </br> (<?php echo $spectacle->getDureeHeure(); ?>)
					</td>
				</tr>
			</table>
		</h1>
<!--
	<div onload="NotationSystem();">

		<img id="1gris" src="/images/plein_gris_l.png" /><img style="display:none;" id="1jaune" src="/images/plein_l.png" /><img id="2gris" src="/images/plein_gris_r.png" /><img style="display:none;" id="2jaune" src="/images/plein_r.png" />
			
	</div>	
	-->

	
	
	<div class="post">
			  <div id="synopsis_visible_part" style="overflow: hidden; height: <?php echo $tailleInfos; ?>; margin-bottom:5px;">
				<div id="synopsis_full" style="padding-bottom:1px;">
        <div class="logo">
		<a class="lookimg" href="/uploads/<?php echo $image; ?>">
            <img height="220" src="/uploads/<?php echo $image; ?>" alt="<?php echo $spectacle->getTitre() ?>" />
		</a>
<?php
	

	foreach($admins as $admin){
		if($admin->possedeSpectacle($spectacle)){
	?>
		<div style="margin-left:20px;">
		
		
	<span>
						<?php
								$mar=-80;
								$martop=-35;
						?>
								<div id="div<?php echo $admin->getUsername().'_'.$id; ?>" class="blockPropriobis" style="margin-left:<?php echo $mar; ?>px;margin-top:<?php echo $martop; ?>px;">
									Noté par <b><?php echo $admin; ?></b>
								</div>
								<img style="float:left;" onmouseover="$('#div<?php echo $admin->getUsername().'_'.$id; ?>').show();return false;" onmouseout="$('#div<?php echo $admin->getUsername().'_'.$id; ?>').hide();return false;" width="15" src="/images/<?php echo $admin->getUsername(); ?>.png"/>
						
					</span>
					
					<?php
								$mar2=135;
								$martop2=0;
								$js=' onmouseover="$(\'#divCom'.$admin->getUsername().'_'.$id.'\').show();$(this).attr(\'style\',\'background-color:red;\');return false;" onmouseout="$(\'#divCom'.$admin->getUsername().'_'.$id.'\').hide();return false;"';
						?>
					<div id="divCom<?php echo $admin->getUsername().'_'.$id; ?>" class="blockComment" style="margin-left:<?php echo $mar2; ?>px;margin-top:<?php echo $martop2; ?>px;width:120px;">
									<?php if($allNote[$admin->getId()]['mess']!=''){ echo $allNote[$admin->getId()]['mess']; }else{ echo 'Aucune critique ...'; } ?>
					</div>
	<?php
	if($sf_user->getAttribute("admin") && $sf_user->getAttribute("login")){
		if($sf_user->getAttribute("login")->getId()==$admin->getId()){
			$move=true;
		}else{
			$move=false;
		}
	}else{
		$move=false;
	}
	
	if($allNote[$admin->getId()]['note']){
		$vote=$allNote[$admin->getId()]['note'];
	}else{
		$vote=0;
	}
	
		echo '<div '.$js.'>';
	
	
		 $vote_isset_user = 1;

	if (!$vote){ // Si $vote = false, alors aucune note n'ai prise en compte à l'affichage
		 for ($i=1;$i<=10;$i+=2){
			if($move){
				echo '<a href='.url_for('spectacle/noteSpectacleAdmin?id='.$spectacle->getId().'&note='.$i).' style="" id="star_'.$i.'" class="star"></a>';
			}else{
				echo '<div style="" id="starnot_'.$i.'" class="starnot"></div>';
			}
			$ii=$i+1;
			if($move){
				echo '<a href='.url_for('spectacle/noteSpectacleAdmin?id='.$spectacle->getId().'&note='.$ii).' style="" id="star_'.($i+1).'" class="star"></a>';
			}else{
				echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
			}
		 }
	}else{
		for ($i=1;$i<=$vote;$i+=2){ // de 1 à $vote étoiles (+1 si impaire)
			if($move){
				echo '<a href='.url_for('spectacle/noteSpectacleAdmin?id='.$spectacle->getId().'&note='.$i).' id="star_'.$i.'" class="star_hover"></a>';
			}else{
				echo '<div style="" id="starnot_'.$i.'" class="star_hovernot"></div>';
			}			
			$ii=$i+1;
			 if ($i<$vote){
				if($move){
					echo '<a href='.url_for('spectacle/noteSpectacleAdmin?id='.$spectacle->getId().'&note='.$ii).' id="star_'.($i+1).'" class="star_hover"></a>';
				}else{
					echo '<div style="" id="starnot_'.($i+1).'" class="star_hovernot"></div>';
				}
			 }else{
				if($move){
					echo '<a href='.url_for('spectacle/noteSpectacleAdmin?id='.$spectacle->getId().'&note='.$ii).' id="star_'.($i+1).'" class="star"></a>';
				}else{
					echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
				}
			 }
		}
		for ($i;$i<=10;$i+=2){ // de ($vote (+1 si impaire)) $i à 10
			if($move){
				echo '<a href='.url_for('spectacle/noteSpectacleAdmin?id='.$spectacle->getId().'&note='.$i).' id="star_'.$i.'" class="star"></a>';
			}else{
				echo '<div style="" id="starnot_'.$i.'" class="starnot"></div>';
			}
			$ii=$i+1;
			if($move){
				echo '<a href='.url_for('spectacle/noteSpectacleAdmin?id='.$spectacle->getId().'&note='.$ii).' id="star_'.($i+1).'" class="star"></a>';
			}else{
				echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
			}
		}
	}
		if($move){
				echo '<div id="affichNote" class="note'.$vote.'" style="float:left;">('.$vote.'/10)</div>';
				echo '<div id="affichNoteFixe" style="display:none;">'.$vote.'</div>';
		}else{
			echo '<div class="note'.$vote.'" style="float:left;">('.$vote.'/10)</div>';
		}
		echo '</div>';
	echo '</div></br>';
	}
}

	?>
     <span id="noter" style="display:none;" ><?php echo url_for('spectacle/noteSpectacleAdmin?id='.$spectacle->getId().'&note=') ?></span>

        </div>
		

        <div class="infos">
		<?php
			if($spectacle->getAuteur()){
		?>
			  <div class="categorie">
				  de 
					<b><a href="<?php echo url_for('personne/show?id='.$spectacle->getAuteurId()) ?>" width="100%"><?php echo $spectacle->getAuteur()->getPrenom().' '.$spectacle->getAuteur()->getNom(); ?></a></b>
			  </div>
		  <?php
			}
		  ?>
		  <?php
			if(sizeof($spectacle->getCategories())!=0){
		  ?>
			<div class="categorie">
              Categorie:
				<b>
          <?php
					foreach($spectacle->getCategories() as $i => $categorie){
						?><a href="<?php echo url_for('categorie/show?id='.$categorie->getId()) ?>" width="100%"><?php echo $categorie->getNom(); ?></a>
					   <?php
					   if(sizeof($spectacle->getCategories())!=$i+1){
							echo ', ';
						}
					}
          ?>
			</b>
			</div>
		  <?php
			}
		  ?>
		  <?php
			if($spectacle->getDuree()){
		  ?>
			  <div class="categorie">
				  Durée: 
					<b><?php echo $spectacle->getDuree(); ?> min (<?php echo $spectacle->getDureeHeure(); ?>)</b>
			  </div>
		  <?php
			}
		  ?>
		  <?php
			if($spectacle->getQualite()){
				$qualite=$spectacle->getQualite();
				$mar2=275;
				$martop2=-30;
				$js=' onmouseover="$(\'#divDesc\').show();return false;" onmouseout="$(\'#divDesc\').hide();return false;"';
		  ?>
				<div class="categorie">
				  Qualité: 
					<span <?php echo $js; ?>><b><?php echo $spectacle->getQualite()->getNom(); ?></b><span>
				</div>
				<div id="divDesc" class="blockComment" style="margin-left:<?php echo $mar2; ?>px;margin-top:<?php echo $martop2; ?>px;width:170px;">
					<?php if($qualite->getDescription()!=''){ echo $qualite->getDescription(); }else{ echo '...'; } ?>
				</div>
		  <?php
			}
		  ?>
		  <?php
			if($spectacle->getAvertissement()){
		  ?>
			  <div class="categorie rouge">
					<b><?php echo $spectacle->getAvertissement(); ?></b>
			  </div>
		  <?php
			}
		  ?>
		  <?php
			if($spectacle->getResume()!=''){
		  ?>
			  <div class="description">
				  <b>Résumé: </b>
						<p id="resume"> <?php echo $spectacle->getResume(); ?></p>
				  

			  </div>
		  <?php
			}
		  ?>
        </div>


				</div>
			  </div>

<i><a class="affich" href="" onclick="return false;"><span id="textSuite">Lire la suite </span>&nbsp;<img id="fleche" class="ico" alt=" " title="" width="0" height="0" src="http://images.allocine.fr/commons/empty.gif"/></a></i>

    </div>
	

	
	
   <div id="onglet">	
	
		<?php $pro=$sf_user->getAttribute("proprio"); ?>
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Auteur</a></li>
				<li><a href="#tabs-2">Bande Annonce</a></li>
			</ul>

			<div id="tabs-1">
				<div id="acteursserie">
					<?php if($spectacle->getAuteur()){ ?>
					<?php $realisateur = $spectacle->getAuteur(); ?>
						<a href="<?php echo url_for('personne/show?id='.$realisateur->getId()) ?>" width="100%"><h2>Auteur</h2></a>
							<table>
								<tr>
									<?php
										if($realisateur->getImage()!=""){
											$imageR='personnes/'.$realisateur->getImage();
										}else{
											$imageR='image_vide.jpeg';
										}
									?>
									<td width="70" valign="top">
										<a href="<?php echo url_for('personne/show?id='.$realisateur->getId()) ?>" width="100%">
											 <img src="/uploads/<?php echo $imageR; ?>" width="50"/><br/>
											 <b><?php echo $realisateur->getPrenom().' '.$realisateur->getNom(); ?></b>
										</a>
									</td>
								</tr>
							</table>
					<?php }else{ ?>
						   <h2>Auteur</h2>
							<div style="margin-left:10px;">Aucun Auteur</div>
					<?php } ?>
					
				</div>
			</div>
			<div id="tabs-2">
				<div>
					<?php if($spectacle->getExtrait()!=""){ ?>
						<a href="" onClick="window.open('<?php echo $spectacle->getExtrait(); ?>','popup','fullscreen=yes');return false;" ><h2>Extrait<i><span class="fulls">grand écran</span></i></h2></a>

								<div id='blogvision' style='width:100%; height:335px;'>
								
										<?php
										if(substr($spectacle->getExtrait(), 11, 7)=="youtube"){
										?>
											<iframe title="" width="100%" height="100%" src="<?php echo $spectacle->getExtrait(); ?>" frameborder="0" allowfullscreen></iframe>
										
										
										
										<?php }else if(substr($spectacle->getExtrait(), 18, 10)=="cinemovies"){ ?>
										<object width="100%" height="100%" data="http://www.cinemovies.fr/player/export/cinemovies-player.swf" type="application/x-shockwave-flash">
										<param name="flashvars" value="<?php echo $spectacle->getExtrait(); ?>" />
										<param name="src" value="http://www.cinemovies.fr/player/export/cinemovies-player.swf" />
										<param name="allowfullscreen" value="true" />
										</object>
										<?php }else{ ?>
											<object width='100%' height='100%'>
													<param name='movie' value='<?php echo $spectacle->getExtrait(); ?>'></param>
													<param name='allowFullScreen' value='true'></param>
													<param name='allowScriptAccess' value='always'></param>
													<embed src='<?php echo $spectacle->getExtrait(); ?>' type='application/x-shockwave-flash' width='100%' height='100%' allowFullScreen='true' allowScriptAccess='always'/>
											</object>
											
										<?php } ?>
										
								</div>
						<?php }else{ ?>
								<h2>Extrait</h2>
								<div style="margin-left:10px;">Aucun Extrait</div>
						<?php } ?>
				</div>
			</div>
		</div>

	</div>
    
	<br/>
	<br/>

<span class="test" style="display:none;opacity:0;">0</span>

<script>
if(parseInt($("#synopsis_full").css('height'))<=<?php echo $val2; ?>){
	$(".affich").html("");
}

$(".affich").click(function () {
	if($(".test").html()=='0'){
        $(".test").html('1');
		$("#textSuite").html("Fermer");
		$('#fleche').attr('class','icoferm');
		$("#synopsis_visible_part").animate({ 
			height: $("#synopsis_full").css('height')
		  }, 500 );
	}else{
        $(".test").html('0');
        $("#textSuite").html("Lire la suite");
		$('#fleche').attr('class','ico');
		$("#synopsis_visible_part").animate({ 
			height: "<?php echo $tailleInfos; ?>"
		  }, 500 );
    }
});
/*
$(".affich").click(function () {
   if($(".test").html()=='0'){
        $(".points").css("display", "none");
        $(".reste").stop().css("opacity", 1).text($(".reste").html()).fadeIn(600);
        $(".test").html('1');
        $(".affich").html("cacher tout");
    }else{
        $(".reste").stop().css("opacity", 1).text($(".reste").html()).fadeOut(600);
        $(".test").html('0');
        $(".affich").html("afficher tout");
        setTimeout('points()',500);
    }
});
function points(){
    $(".points").stop().css("opacity", 1).text("...").fadeIn(600);
}
*/
</script>




