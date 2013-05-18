<?php slot('title') ?>
  <?php echo $video->getTitre(); ?>
<?php end_slot(); ?>

<?php use_helper('Text') ?>





<?php
    if($video->getImage()!=""){
        $image='videos/'.$video->getImage();
    }else{
        $image='image_vide.jpeg';
    }
	$type=$video->getType();
	$val=284;
	$val2=8;
	$allNote=$video->getNoteAdmin();
?>
        <h1 class="titreF">
			<table width="100%">
				<tr>
					<td>
						<div id="titreFilm">
							<img id="1gris" src="/images/videobis.png" />
							<?php echo $video->getTitre();
							if($video->getSousTitre()){
								echo '<span id="titreFilmS"><i> - '.$video->getSousTitre().'</i></span>';
							}
							if($video->getTitreOriginal()){
								echo '<span id="titreFilmO"><i> ( '.$video->getTitreOriginal().' )</i></span>';
							}
							?>
						</div>
					</td>
					<td align="top" id="duree" >
						<?php echo $video->getDuree(); ?> min </br> (<?php echo $video->getDureeHeure(); ?>)
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
            <img class="thumb img_princ" height="<?php echo $height; ?>" src="/uploads/<?php echo $image; ?>" alt="<?php echo $video->getTitre() ?>" />
		</a>
<?php
	

	foreach($admins as $admin){
		if($admin->possede($video)){
	?>
		<div style="margin-left:<?php echo $marge; ?>px;">
		
		
			<span>
						<?php
								$mar=-80;
								$martop=-35;
						?>
								<div id="div<?php echo $admin->getUsername().'_'.$video->getId(); ?>" class="blockPropriobis" style="margin-left:<?php echo $mar; ?>px;margin-top:<?php echo $martop; ?>px;">
									Noté par <b><?php echo $admin; ?></b>
								</div>
								<img style="float:left;" onmouseover="$('#div<?php echo $admin->getUsername().'_'.$video->getId(); ?>').show();return false;" onmouseout="$('#div<?php echo $admin->getUsername().'_'.$video->getId(); ?>').hide();return false;" width="15" src="/images/<?php echo $admin->getUsername(); ?>.png"/>
						
			</span>
					
			<?php
				$mar2=135;
				$martop2=0;
				$js=' onmouseover="$(\'#divCom'.$admin->getUsername().'_'.$video->getId().'\').show();$(this).attr(\'style\',\'background-color:red;\');return false;" onmouseout="$(\'#divCom'.$admin->getUsername().'_'.$video->getId().'\').hide();return false;"';
			?>
			<div id="divCom<?php echo $admin->getUsername().'_'.$video->getId(); ?>" class="blockComment" style="margin-left:<?php echo $mar2; ?>px;margin-top:<?php echo $martop2; ?>px;width:200px;">
				<?php if(isset($allNote[$admin->getId()]) && $allNote[$admin->getId()]['mess']!=''){ echo $allNote[$admin->getId()]['mess']; }else{ echo 'Aucune critique ...'; } ?>
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
			
			if(isset($allNote[$admin->getId()]) && $allNote[$admin->getId()]['note']){
				$vote=$allNote[$admin->getId()]['note'];
			}else{
				$vote=0;
			}
			
				echo '<div '.$js.'>';
			
			
				 $vote_isset_user = 1;

			if (!$vote){ // Si $vote = false, alors aucune note n'ai prise en compte à l'affichage
				 for ($i=1;$i<=10;$i+=2){
					if($move){
						echo '<a href='.url_for('video/noteVideoAdmin?id='.$video->getId().'&note='.$i).' style="" id="star_'.$i.'" class="star"></a>';
					}else{
						echo '<div style="" id="starnot_'.$i.'" class="starnot"></div>';
					}
					$ii=$i+1;
					if($move){
						echo '<a href='.url_for('video/noteVideoAdmin?id='.$video->getId().'&note='.$ii).' style="" id="star_'.($i+1).'" class="star"></a>';
					}else{
						echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
					}
				 }
			}else{
				for ($i=1;$i<=$vote;$i+=2){ // de 1 à $vote étoiles (+1 si impaire)
					if($move){
						echo '<a href='.url_for('video/noteVideoAdmin?id='.$video->getId().'&note='.$i).' id="star_'.$i.'" class="star_hover"></a>';
					}else{
						echo '<div style="" id="starnot_'.$i.'" class="star_hovernot"></div>';
					}			
					$ii=$i+1;
					 if ($i<$vote){
						if($move){
							echo '<a href='.url_for('video/noteVideoAdmin?id='.$video->getId().'&note='.$ii).' id="star_'.($i+1).'" class="star_hover"></a>';
						}else{
							echo '<div style="" id="starnot_'.($i+1).'" class="star_hovernot"></div>';
						}
					 }else{
						if($move){
							echo '<a href='.url_for('video/noteVideoAdmin?id='.$video->getId().'&note='.$ii).' id="star_'.($i+1).'" class="star"></a>';
						}else{
							echo '<div style="" id="starnot_'.($i+1).'" class="starnot"></div>';
						}
					 }
				}
				for ($i;$i<=10;$i+=2){ // de ($vote (+1 si impaire)) $i à 10
					if($move){
						echo '<a href='.url_for('video/noteVideoAdmin?id='.$video->getId().'&note='.$i).' id="star_'.$i.'" class="star"></a>';
					}else{
						echo '<div style="" id="starnot_'.$i.'" class="starnot"></div>';
					}
					$ii=$i+1;
					if($move){
						echo '<a href='.url_for('video/noteVideoAdmin?id='.$video->getId().'&note='.$ii).' id="star_'.($i+1).'" class="star"></a>';
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
     <span id="noter" style="display:none;" ><?php echo url_for('video/noteVideoAdmin?id='.$video->getId().'&note=') ?></span>

        </div>
		

        <div class="infos">
			<div id="infosMob">
					  <div class="categorie">
						<?php
							if($video->getRealisateur()){
								if($type=='film'){ echo 'Réalisé par '; }else{ echo 'Auteur : '; }
						?>
								<b><a href="<?php echo url_for('personne/show?id='.$video->getRealisateurId()) ?>" width="100%"><?php echo $video->getRealisateur()->getPrenom().' '.$video->getRealisateur()->getNom(); ?></a></b>
						<?php
							}else{
								echo '<i>inconnu</i>';
							}
						?>
					  </div>
				  <?php
					if(sizeof($video->getCategories())!=0){
				  ?>
					<div class="categorie">
					  Categorie:
						<b>
				  <?php
							foreach($video->getCategories() as $i => $categorie){
								?><a href="<?php echo url_for('categorie/show?id='.$categorie->getId()) ?>" width="100%"><?php echo $categorie->getNom(); ?></a>
							   <?php
							   if(sizeof($video->getCategories())!=$i+1){
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
					if($video->getDuree()){
				  ?>
					  <div class="categorie">
						  Durée: 
							<b><?php echo $video->getDuree(); ?> min ( <?php echo $video->getDureeHeure(); ?> )</b>
					  </div>
				  <?php
					}
				  ?>
				  <?php
					if($video->getQualite()){
						$qualite=$video->getQualite();
						$mar2=300;
						$martop2=-30;
						$js=' onmouseover="$(\'#divDesc\').show();return false;" onmouseout="$(\'#divDesc\').hide();return false;"';
				  ?>
						<div class="categorie">
						  Qualité: 
							<span><b><?php echo $video->getQualite()->getNom(); ?></b><img style="padding-left:2px;padding-bottom:4px;" <?php echo $js; ?> width="10" src="/images/infos.png" /><span>
						</div>
						<div id="divDesc" class="blockComment" style="margin-left:<?php echo $mar2; ?>px;margin-top:<?php echo $martop2; ?>px;width:170px;">
							<?php if($qualite->getDescription()!=''){ echo $qualite->getDescription(); }else{ echo '...'; } ?>
						</div>
				  <?php
					}
				  ?>
				  <?php
					if($video->getAvertissement()){
				  ?>
					  <div class="categorie rouge">
							<b><?php echo $video->getAvertissement(); ?></b>
					  </div>
				  <?php
					}
				  ?>
			  </div>
				  <?php
					if($video->getResume()!=''){
				  ?>
				  <div class="description">
					  <b>Résumé: </b>
							<p id="resume"> <?php echo $video->getResume(); ?></p>
					  

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
				<li>
					<a href="#tabs-1">
					<?php 
					if($type=='film'){
						$nbAc='';
						if(sizeof($video->getActeurs())!=0){
							$nbAct=' ('.sizeof($video->getActeurs()).')';
						}
						echo 'Casting'.$nbAc;
					}else if($type=='spectacle'){ 
						echo 'Auteur'; 
					} 
					?>
					</a>
				</li>
				<li><a href="#tabs-2"><?php if($type=='film'){ echo 'Bande Annonce'; }else if($type=='spectacle'){ echo 'Extrait'; } ?></a></li>
				<?php if($video->getSaga()){ ?>
					<li><a href="#tabs-3"><?php if(sizeof($video->getSaga()->getFilms($pro))==3){ echo 'La Tilogie "<b>'.$video->getSaga().'</b>"'; }else{ echo 'La Saga "<b>'.$video->getSaga().'</b>" ('.sizeof($video->getSaga()->getFilms($pro)).')'; } ?></a></li>
				<?php } ?>
			</ul>

			<div id="tabs-1">
				<div id="acteursserie">
					<?php if($video->getRealisateur()){ ?>
					<?php $realisateur = $video->getRealisateur(); ?>
						<a href="<?php echo url_for('personne/show?id='.$realisateur->getId()) ?>" width="100%"><h2><?php if($type=='film'){ echo 'Réalisateur'; }else if($type=='spectacle'){ echo 'Auteur'; } ?></h2></a>
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
						   <h2><?php if($type=='film'){ echo 'Realisateur'; }else if($type=='spectacle'){ echo 'Auteur'; } ?></h2>
							<div class="aucun">Aucun Realisateur</div>
					<?php } ?>
					<?php if(sizeof($video->getActeurs())!=0){ ?>
						<a href="<?php echo url_for('video/acteursFilm?id='.$video->getId()) ?>" width="100%"><h2>Acteurs (<?php echo sizeof($video->getActeurs()); ?>)</h2></a>
							
							<div class="list_effet_photo list_img100_by">
								<ul>
								 <?php foreach($video->getActeurs(7) as $i => $acteur){ ?>
									<?php
										if($acteur->getImage()!=""){
											$imageA='personnes/'.$acteur->getImage();
										}else{
											$imageA='image_vide.jpeg';
										}
									?>
									<li>
										<a href="<?php echo url_for('personne/show?id='.$acteur->getId()) ?>">
											<span><img class="thumb" src="/uploads/<?php echo $imageA; ?>" width="50"/></span>
											<b><?php echo $acteur->getPrenom().' '.$acteur->getNom(); ?></b>
										</a>
									</li>
								 <?php } ?>
								</ul>
							</div>
					<?php 
						}else{
							if($type=='film'){
					?>
						   <h2>Acteurs</h2>
							<div class="aucun">Aucun Acteur</div>
					<?php 
							}
						}	
					?>
				</div>
			</div>
			<div id="tabs-2">
				<div>
					<?php if($video->getBandeAnnonce()!=""){ ?>
						<a href="" onClick="window.open('<?php echo $video->getBandeAnnonce(); ?>','popup','fullscreen=yes');return false;" ><h2><?php if($type=='film'){ echo 'Bande Annonce'; }else if($type=='spectacle'){ echo 'Extrait'; } ?><i><span class="fulls">grand écran</span></i></h2></a>

								<div id='blogvision' style='width:100%; height:335px;'>
									<?php
										$video->afficheBandeAnnonce('100%', '100%'); 
									?>
								</div>
						<?php }else{ ?>
								<h2><?php if($type=='film'){ echo 'Bande Annonce'; }else if($type=='spectacle'){ echo 'Extrait'; } ?></h2>
								<div class="aucun">Aucune <?php if($type=='film'){ echo 'Bande Annonce'; }else if($type=='spectacle'){ echo 'Extrait'; } ?></div>
						<?php } ?>
				</div>
			</div>
			<?php if($video->getSaga()){ ?>
				<div id="tabs-3">
					<div id="acteursserie">
						<?php if(sizeof($video->getSaga()->getFilms($pro))!=0){ ?>
							<a href="<?php echo url_for('saga/show?id='.$video->getSaga()->getId()) ?>" width="100%"><h2>Films de <?php if(sizeof($video->getSaga()->getFilms($pro))==3){ echo 'la Tilogie "<b>'.$video->getSaga().'</b>"'; }else{ echo 'la Saga "<b>'.$video->getSaga().'</b>" ('.sizeof($video->getSaga()->getFilms($pro)).')'; } ?></h2></a>
								<div class="list_effet_photo list_img100_by">
									<ul>
									 <?php foreach($video->getSaga()->getFilms($pro) as $i => $video){ ?>
										<?php
											if($video->getImage()!=""){
												$imageA='videos/'.$video->getImage();
											}else{
												$imageA='image_vide.jpeg';
											}
										?>
										<li>
											<a href="<?php echo url_for('video/show?id='.$video->getId()) ?>" width="100%">
												<span><img class="thumb" src="/uploads/<?php echo $imageA; ?>" width="50"/></span>
												 <b><?php echo $video->getTitre(); ?></b>
											</a>
										</li>
									 <?php } ?>
									</ul>
								</div>
						<?php }else{ ?>
							   <h2>Films de la Saga <?php echo $video->getSaga().' ('.sizeof($video->getActeurs()).')'; ?></h2>
								<div class="aucun">Aucun Film</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="clear"></div>
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




