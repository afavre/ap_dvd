<?php slot('title') ?>
  <?php echo $serie->getTitre(); ?>
<?php end_slot(); ?>

<?php use_helper('Text') ?>

<?php
    if($serie->getImage()!=""){
        $image='series/'.$serie->getImage();
    }else{
        $image='image_vide.jpeg';
    }
	
	$val=284;
	$val2=8;
?>
        <h1><?php echo $serie->getTitre() ?><div style="float:right;"> </div></h1>


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
            <img class="thumb img_princ" height="<?php echo $height; ?>" src="/uploads/<?php echo $image; ?>" alt="<?php echo $serie->getTitre() ?>" />
		</a>
	</div>
        <div class="infos">
			<div id="infosMob">
					  <div class="categorie">
						<?php
							if($serie->getRealisateur()){
								if($type=='film'){ echo 'Réalisé par '; }else{ echo 'Auteur : '; }
						?>
								<b><a href="<?php echo url_for('personne/show?id='.$serie->getRealisateurId()) ?>" width="100%"><?php echo $serie->getRealisateur()->getPrenom().' '.$serie->getRealisateur()->getNom(); ?></a></b>
						<?php
							}else{
								echo '<i>inconnu</i>';
							}
						?>
					  </div>
				  <?php
					if(sizeof($serie->getCategories())!=0){
				  ?>
					<div class="categorie">
					  Categorie:
						<b>
				  <?php
							foreach($serie->getCategories() as $i => $categorie){
								?><a href="<?php echo url_for('categorie/show?id='.$categorie->getId()) ?>" width="100%"><?php echo $categorie->getNom(); ?></a>
							   <?php
							   if(sizeof($serie->getCategories())!=$i+1){
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
					if($serie->getFormatDuree()){
				  ?>
					  <div class="categorie">
						  Format durée: 
							<b><?php echo $serie->getFormatDuree(); ?> min ( <?php echo $serie->getFormatDureeHeure(); ?> )</b>
					  </div>
				  <?php
					}
				  ?>
			  </div>
				  <?php
					if($serie->getResume()!=''){
				  ?>
				  <div class="description">
					  <b>Résumé: </b>
							<p id="resume"> <?php echo $serie->getResume(); ?></p>
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
				<li><a href="#tabs-1">Saisons (<?php echo sizeof($serie->getSaisons()); ?>)</a></li>
				<li>
					<a href="#tabs-2">
					<?php 
						$nbAc='';
						if(sizeof($serie->getActeurs())!=0){
							$nbAct=' ('.sizeof($serie->getActeurs()).')';
						}
						echo 'Casting'.$nbAc;
					?>
					</a>
				</li>
				<li><a href="#tabs-3">Bande Annonce</a></li>
			</ul>

			<div id="tabs-1">
				
				<div id="saisons">
					<?php if(sizeof($serie->getSaisons())!=0){ ?>
						<a href="<?php echo url_for('serie/saisonsSerie?id='.$serie->getId()) ?>" width="100%"><h2>Saisons (<?php echo sizeof($serie->getSaisons()); ?>)</h2></a>
							<div class="list_effet_photo list_img100_by">
								<ul>
								 <?php foreach($serie->getSaisons() as $i => $saison){ ?>
									<?php
										if($saison->getImage()!=""){
											$imageS='saisons/'.$saison->getImage();
										}else{
											$imageS='image_vide.jpeg';
										}
									?>
									<li>
										<a href="<?php echo url_for('saison/show?id='.$saison->getId()) ?>" width="100%">
											<span><img class="thumb" src="/uploads/<?php echo $imageS; ?>" width="50"/></span>
											 <b><?php echo 'Saison '.$saison->getNumero(); ?></b>
											 <i><?php echo $saison->getTitre(); ?></i>
										</a>
									</li>
								 <?php } ?>
								</ul>
							</div>
					<?php }else{ ?>
						   <h2>Saisons</h2>
							<div style="margin-left:10px;">Acune Saison</div>
					<?php } ?>
				</div>
			</div>
			<div id="tabs-2">
				<div id="acteursserie">
					<?php if($serie->getRealisateur()){ ?>
					<?php $realisateur = $serie->getRealisateur(); ?>
							<a href="<?php echo url_for('personne/show?id='.$realisateur->getId()) ?>" width="100%"><h2>Réalisateur</h2></a>
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
						   <h2>Realisateur</h2>
							<div class="aucun">Aucun Realisateur</div>
					<?php } ?>
					<?php if(sizeof($serie->getActeurs())!=0){ ?>
						<a href="<?php echo url_for('serie/acteursSerie?id='.$serie->getId()) ?>" width="100%"><h2>Acteurs (<?php echo sizeof($serie->getActeurs()); ?>)</h2></a>
							<div class="list_effet_photo list_img100_by">
								<ul>
								 <?php foreach($serie->getActeurs(7) as $i => $acteur){ ?>
									<?php
										if($acteur->getImage()!=""){
											$imageA='personnes/'.$acteur->getImage();
										}else{
											$imageA='image_vide.jpeg';
										}
									?>
									<li width="70" valign="top">
										<a href="<?php echo url_for('personne/show?id='.$acteur->getId()) ?>" width="100%">
											<span><img src="/uploads/<?php echo $imageA; ?>" width="50"/></span>
											 <b><?php echo $acteur->getPrenom().' '.$acteur->getNom(); ?></b>
										</a>
									</li>
								 <?php } ?>
								</ul>
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
			<div id="tabs-3">
				<div>
					<?php if($serie->getBandeAnnonce()!=""){ ?>
						<a href="" onClick="window.open('<?php echo $serie->getBandeAnnonce(); ?>','popup','fullscreen=yes');return false;" ><h2>Bande Annonce<i><span class="fulls">grand écran</span></i></h2></a>

								<div id='blogvision' style='width:100%; height:335px;'>
								
										<?php
										if(substr($serie->getBandeAnnonce(), 11, 7)=="youtube"){
										?>
											<iframe title="" width="100%" height="100%" src="<?php echo $serie->getBandeAnnonce(); ?>" frameborder="0" allowfullscreen></iframe>
										
										<?php }else if(substr($serie->getBandeAnnonce(), 18, 10)=="cinemovies" || substr($serie->getBandeAnnonce(), 11, 10)=="cinemovies"){ ?>
											<object width="100%" height="100%" data="http://www.cinemovies.fr/player/export/cinemovies-player.swf" type="application/x-shockwave-flash">
											<param name="flashvars" value="config=<?php echo $serie->getBandeAnnonce(); ?>" />
											<param name="src" value="http://www.cinemovies.fr/player/export/cinemovies-player.swf" />
											<param name="allowfullscreen" value="true" />
											</object>
										
										<?php }else{ ?>
											<object width='100%' height='100%'>
													<param name='movie' value='<?php echo $serie->getBandeAnnonce(); ?>'></param>
													<param name='allowFullScreen' value='true'></param>
													<param name='allowScriptAccess' value='always'></param>
													<embed src='<?php echo $serie->getBandeAnnonce(); ?>' type='application/x-shockwave-flash' width='100%' height='100%' allowFullScreen='true' allowScriptAccess='always'/>
											</object>
											
										<?php } ?>
										
								</div>
						<?php }else{ ?>
								<h2>Bande Annonce</h2>
								<div style="margin-left:10px;">Aucune Bande Annonce</div>
						<?php } ?>
				</div>
			</div>
		</div>

	</div>

    

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
        $(".affich").html("cacher tous");
    }else{
        $(".reste").stop().css("opacity", 1).text($(".reste").html()).fadeOut(600);
        $(".test").html('0');
        $(".affich").html("afficher tous");
        setTimeout('points()',500);
    }
});
function points(){
    $(".points").stop().css("opacity", 1).text("...").fadeIn(600);
}
*/
</script>




