<?php slot('title') ?>
  <?php echo $saison; ?>
<?php end_slot(); ?>

<?php use_helper('Text') ?>





<?php
    if($saison->getImage()!=""){
        $image='saisons/'.$saison->getImage();
    }else{
        $image='image_vide.jpeg';
    }
	$val=284;
	$val2=8;
	$allNote=$saison->getNoteAdmin();


?>
        <h1 class="titreF">
			<table width="100%">
				<tr>
					<td>
						<div id="titreFilm">
							<img id="1gris" src="/images/saisonbis.png" />
							<?php echo $saison;
							if($saison->getSousTitre()){
								echo '<span id="titreFilmS"><i> - '.$saison->getSousTitre().'</i></span>';
							}
							if($saison->getTitreOriginal()){
								echo '<span id="titreFilmO"><i> ( '.$saison->getTitreOriginal().' )</i></span>';
							}
							?>
						</div>
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
			  <div id="synopsis_visible_part" style="overflow: hidden; margin-bottom:5px;">
				<div id="synopsis_full" style="padding-bottom:1px;">
	<?php
		$widthMin=130;
		$height=220;
		$margeNote=20;
		
		
		$img_size = getimagesize('uploads/'.$image);
		$W_Src = $img_size[0]; // largeur
		$H_Src = $img_size[1]; // hauteur
		$taille='';
		if($W_Src<$H_Src){
			$widthTest = ($W_Src / $H_Src) * $height;
			if($widthTest>=$widthMin){
				$diff=$widthTest - $widthMin;
				$diff2=round($diff/2);
				$marge=$diff2;
			}else{
				$taille=$widthMin;
				$marge=0;
			}
		}
	?>
        <div class="logo" style="width:<?php echo $taille; ?>px;" >
		<a class="lookimg" href="/uploads/<?php echo $image; ?>">
            <img class="thumb img_princ" height="<?php echo $height; ?>" src="/uploads/<?php echo $image; ?>" alt="<?php echo $saison->getTitre() ?>" />
		</a>
<?php

	foreach($admins as $admin){
		if($admin->possede($saison)){
	?>
		<div style="margin-left:<?php echo $marge; ?>px;">
		
		
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
			<div id="divCom<?php echo $admin->getUsername().'_'.$id; ?>" class="blockComment" style="margin-left:<?php echo $mar2; ?>px;margin-top:<?php echo $martop2; ?>px;width:200px;">
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
						echo '<a href='.url_for('saison/noteVideoAdmin?id='.$saison->getId().'&note='.$i).' style="" id="star_'.$i.'" class="star"></a>';
					}else{
						echo '<div style="" id="starnot_'.$i.'" class="starnot"></div>';
					}
					$ii=$i+1;
					if($move){
						echo '<a href='.url_for('saison/noteVideoAdmin?id='.$saison->getId().'&note='.$ii).' style="" id="star_'.($i+1).'" class="star"></a>';
					}else{
						echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
					}
				 }
			}else{
				for ($i=1;$i<=$vote;$i+=2){ // de 1 à $vote étoiles (+1 si impaire)
					if($move){
						echo '<a href='.url_for('saison/noteVideoAdmin?id='.$saison->getId().'&note='.$i).' id="star_'.$i.'" class="star_hover"></a>';
					}else{
						echo '<div style="" id="starnot_'.$i.'" class="star_hovernot"></div>';
					}			
					$ii=$i+1;
					 if ($i<$vote){
						if($move){
							echo '<a href='.url_for('saison/noteVideoAdmin?id='.$saison->getId().'&note='.$ii).' id="star_'.($i+1).'" class="star_hover"></a>';
						}else{
							echo '<div style="" id="starnot_'.($i+1).'" class="star_hovernot"></div>';
						}
					 }else{
						if($move){
							echo '<a href='.url_for('saison/noteVideoAdmin?id='.$saison->getId().'&note='.$ii).' id="star_'.($i+1).'" class="star"></a>';
						}else{
							echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
						}
					 }
				}
				for ($i;$i<=10;$i+=2){ // de ($vote (+1 si impaire)) $i à 10
					if($move){
						echo '<a href='.url_for('saison/noteVideoAdmin?id='.$saison->getId().'&note='.$i).' id="star_'.$i.'" class="star"></a>';
					}else{
						echo '<div style="" id="starnot_'.$i.'" class="starnot"></div>';
					}
					$ii=$i+1;
					if($move){
						echo '<a href='.url_for('saison/noteVideoAdmin?id='.$saison->getId().'&note='.$ii).' id="star_'.($i+1).'" class="star"></a>';
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
     <span id="noter" style="display:none;" ><?php echo url_for('saison/noteVideoAdmin?id='.$saison->getId().'&note=') ?></span>

        </div>
		

        <div class="infos">
			<div id="infosMob">
					  <div class="categorie">
						<?php
							if($saison->getRealisateur()){
								echo 'Réalisé par ';
						?>
								<b><a href="<?php echo url_for('personne/show?id='.$saison->getRealisateurId()) ?>" width="100%"><?php echo $saison->getRealisateur()->getPrenom().' '.$saison->getRealisateur()->getNom(); ?></a></b>
						<?php
							}else{
								echo '<i>inconnu</i>';
							}
						?>
					  </div>
				  <?php
					if(sizeof($saison->getCategories())!=0){
				  ?>
					<div class="categorie">
					  Categorie:
						<b>
				  <?php
							foreach($saison->getCategories() as $i => $categorie){
								?><a href="<?php echo url_for('categorie/show?id='.$categorie->getId()) ?>" width="100%"><?php echo $categorie->getNom(); ?></a>
							   <?php
							   if(sizeof($saison->getCategories())!=$i+1){
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
					if($saison->getFormatDuree()){
				  ?>
					  <div class="categorie">
						  Format durée des épisodes: 
							<b><?php echo $saison->getFormatDuree(); ?> min</b>
					  </div>
				  <?php
					}
				  ?>
				  
			  </div>
				  <?php
					if($saison->getResume()!=''){
				  ?>
				  <div class="description">
					  <b>Résumé de la Saison <?php echo $saison->getNumero(); ?>: </b>
							<p id="resume"> <?php echo $saison->getResume(); ?></p>
					  

				  </div>
			  <?php
				}else if($saison->getSerie()->getResume()!=''){
				?>
				  <div class="description">
					  <b>Résumé de la Série: </b>
							<p id="resume"> <?php echo $saison->getSerie()->getResume(); ?></p>
					  

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
				<li><a href="#tabs-1"><?php echo 'Episodes (<span class="nbAff">'.sizeof($saison->getEpisodesPossede($pro)).'</span>)'; ?></a></li>
				<li>
					<a href="#tabs-2">
					<?php 
						$nbAc='';
						if(sizeof($saison->getActeurs())!=0){
							$nbAct=' ('.sizeof($saison->getActeurs()).')';
						}
						echo 'Casting'.$nbAc;
					?>
					</a>
				</li>
				<?php if($saison->getBandeAnnonce() || $saison->getSerie()->getBandeAnnonce()){ ?>
				<li><a href="#tabs-3" disabled><?php if($saison->getBandeAnnonce()){ echo 'Bande Annonce de la Saison '.$saison->getNumero(); }else if($saison->getSerie()->getBandeAnnonce()){ echo 'Bande Annonce de la Série'; } ?></a></li>
				<?php } ?>
			</ul>
			<div id="tabs-1">
				<div id="episodes">
					
					<?php if($saison->getNbEpisodeTot()!=0 || sizeof($saison->getEpisodes())!=0){ ?>
						<a href="" width="100%"><h2>Episodes (<span class="nbAff"><?php echo sizeof($saison->getEpisodesPossede($pro)); ?></span>)<span id="repOK" class="invisible"><img src="/images/valide.png" />Episode correctement modifié</span><span id="repOKnew" class="invisible"><img src="/images/valide.png" />Episode correctement inséré</span><span id="repErr" class="invisible"><img src="/images/invalide.png" />Erreur: L'Episode n'a pas été modifié</span></h2></a>
						<span id="Affich">
							<?php include_partial('saison/episodes', array('saison' => $saison, 'form' => $form, 'qualites' => $qualites, 'versions' => $versions)) ?>
						</span>
					<?php 
						}else{
					?>
						   <h2>Episodes</h2>
							<div class="aucun">Aucun Episode</div>
					<?php 
						}	
					?>
				</div>
			</div>
			<div id="tabs-2">
				<div id="acteursserie">
					<?php if($saison->getRealisateur()){ ?>
					<?php $realisateur = $saison->getRealisateur(); ?>
						<a href="<?php echo url_for('personne/show?id='.$realisateur->getId()) ?>" width="100%"><h2><?php echo 'Réalisateur'; ?></h2></a>
							<div class="list_effet_photo list_img100_by">
								<ul>
									<?php
										if($realisateur->getImage()!=""){
											$imageR='personnes/'.$realisateur->getImage();
										}else{
											$imageR='image_vide.jpeg';
										}
									?>
									<li>
										<a href="<?php echo url_for('personne/show?id='.$realisateur->getId()) ?>" width="100%">
											<span><img class="thumb" src="/uploads/<?php echo $imageR; ?>" width="50"/></span>
											 <b><?php echo $realisateur->getPrenom().' '.$realisateur->getNom(); ?></b>
										</a>
									</li>
								</ul>
								<div class="clear"></div>
							</div>
					<?php }else{ ?>
						   <h2><?php echo 'Realisateur'; ?></h2>
							<div class="aucun">Aucun Realisateur</div>
					<?php } ?>
					<?php if(sizeof($saison->getActeurs())!=0){ ?>
						<a href="<?php echo url_for('saison/acteursSaison?id='.$saison->getId()) ?>" width="100%"><h2>Acteurs (<?php echo sizeof($saison->getActeurs()); ?>)</h2></a>
							<div class="list_effet_photo list_img100_by">
								<ul>
								 <?php foreach($saison->getActeurs(7) as $i => $acteur){ ?>
									<?php
										if($acteur->getImage()!=""){
											$imageA='personnes/'.$acteur->getImage();
										}else{
											$imageA='image_vide.jpeg';
										}
									?>
									<li>
										<a href="<?php echo url_for('personne/show?id='.$acteur->getId()) ?>" width="100%">
											<span><img class="thumb" src="/uploads/<?php echo $imageA; ?>" width="50"/></span>
											 <b><?php echo $acteur->getPrenom().' '.$acteur->getNom(); ?></b>
										</a>
									</li>
								 <?php } ?>
								</ul>
								<div class="clear"></div>
							</div>
					<?php 
						}else{
					?>
						   <h2>Acteurs</h2>
							<div class="aucun">Aucun Acteur</div>
					<?php 
						}	
					?>
				</div>
			</div>
			<?php if($saison->getBandeAnnonce() || $saison->getSerie()->getBandeAnnonce()){ ?>
			<div id="tabs-3">
				<div>
					<?php 
						$ba='';
						if($saison->getBandeAnnonce()){ 
							$ba=$saison->getBandeAnnonce();
						}else if($saison->getSerie()->getBandeAnnonce()){
							$ba=$saison->getSerie()->getBandeAnnonce();
						}
					?>
					<?php if($ba){ ?>
						<a href="" onClick="window.open('<?php echo $ba; ?>','popup','fullscreen=yes');return false;" ><h2><?php echo 'Bande Annonce'; ?><i><span class="fulls">grand écran</span></i></h2></a>

								<div id='blogvision' style='width:100%; height:335px;'>
								
										<?php
										if(substr($ba, 11, 7)=="youtube"){
										?>
											<iframe title="" width="100%" height="100%" src="<?php echo $ba; ?>" frameborder="0" allowfullscreen></iframe>
										
										<?php }else if(substr($ba, 18, 10)=="cinemovies" || substr($ba, 11, 10)=="cinemovies"){ ?>
											<object width="100%" height="100%" data="http://www.cinemovies.fr/player/export/cinemovies-player.swf" type="application/x-shockwave-flash">
											<param name="flashvars" value="config=<?php echo $ba; ?>" />
											<param name="src" value="http://www.cinemovies.fr/player/export/cinemovies-player.swf" />
											<param name="allowfullscreen" value="true" />
											</object>
										
										<?php }else{ ?>
											<object width='100%' height='100%'>
													<param name='movie' value='<?php echo $ba; ?>'></param>
													<param name='allowFullScreen' value='true'></param>
													<param name='allowScriptAccess' value='always'></param>
													<embed src='<?php echo $ba; ?>' type='application/x-shockwave-flash' width='100%' height='100%' allowFullScreen='true' allowScriptAccess='always'/>
											</object>
											
										<?php } ?>
										
								</div>
						<?php }else{ ?>
								<h2><?php echo 'Bande Annonce'; ?></h2>
								<div class="aucun">Aucune <?php echo 'Bande Annonce'; ?></div>
						<?php } ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php } ?>
		</div>

	</div>
    
	<br/>
	<br/>

<span class="test" style="display:none;opacity:0;">0</span>

<script>
var tailleInfosMob = parseInt($("#infosMob").css('height'));
var taille = <?php echo $val; ?>;
var tailleInfos = tailleInfosMob + 39;
var tailleResume = taille - tailleInfos;
tailleResume = Math.floor(tailleResume/20);
tailleResume = tailleResume*20;
taille = tailleResume + tailleInfos - 1;

$("#synopsis_visible_part").css('height', taille+'px');
var taille2 = taille + <?php echo $val2; ?>;

if(parseInt($("#synopsis_full").css('height'))<=taille2){
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
			height: taille+"px"
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




