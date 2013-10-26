<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!-- apps/frontend/templates/layout.php -->
  <head>
    <title>Dvdtheque -
    <?php if (!include_slot('title')): ?>
     Les meilleurs Films
    <?php endif; ?>
	
	 </title>
    <link rel="shortcut icon" href="/images/icone.png" />
	
	
 <!--  <script type="text/javascript" src="/js/jquery.js"></script>-->
	<link rel="stylesheet" type="text/css" media="screen" href="/css/film.css" />
	<link rel="stylesheet" href="/js/onglet/jquery.ui.all.css">
	
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js">

 <!-- inclusion des librairies jQuery et jQuery UI (fichier principal et plugins) -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
	<?php use_stylesheet('main.css') ?>
	<?php use_stylesheet('ui.multiselect.css') ?>
	
 <!-- 	Inclusion des fichiers necessaires pour bootstrap, mais cela change la mise en page d'origine car des classes définit sont également utilisées dans bootstrap -->
 	<?php //use_stylesheet('bootstrap.css') ?>
	<?php //use_javascript('bootstrap.min.js') ?>  
	
	
	<?php //use_javascript('jquery-1.4.4.min.js') ?>
	<?php //use_javascript('jquery-ui-1.8.7.custom.min.js') ?>
    <?php use_javascript('plugins/localisation/jquery.localisation-min.js') ?>
    <?php use_javascript('ui.multiselect.js') ?>
	<?php use_javascript('fancybox/jquery.fancybox-1.3.4.js') ?>
	<?php use_javascript('script_demarrage_frontend.js') ?>
    <?php use_javascript('script.js') ?>
    <?php use_javascript('jquery.cycle.all.js') ?>
    <?php use_javascript('jquery.easing.1.1.1.js') ?>
	<?php use_javascript('verif.js') ?>
    <?php use_javascript('search.js') ?>
	
	
	
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
	<script src="/js/script.js"></script>
	
	
	<script src="/js/onglet/jquery.cookie.js"></script>
	<script src="/js/onglet/ui/jquery.ui.widget.js"></script>
	<script src="/js/onglet/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript" src="js/fileprogress.js"></script>
<!--
	<link type="text/css" rel="stylesheet" href="/css/main-ie.css" />
-->
<!--[if IE]>
<![endif]-->
	<link rel="stylesheet" type="text/css" href="/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	
	
	
  
		
		
		<?php
		
		$rand=rand(0,1);
		if($rand==0){
			$fx='scrollDown';
			$easing='bounceout';
		}else{
			$fx='scrollRight';
			$easing='backinout';
		}
		?>
		<script type="text/javascript">
		
			 
function getXHR(){
         if (window.XMLHttpRequest) {
            xhr = new XMLHttpRequest();
         }
         else if (window.ActiveXObject) {
            try
            {
               xhr = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e)
            {
               xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
         }
         else
         {
         alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest !");
         xhr = false;
         }
      }
function verifUpload() {
   var xhr = getXHR();
  if(xhr && xhr.readyState != 0) {
    xhr.abort();
  }

  var keyFile = document.getElementById('keyFile').value;
   /*
  xhr.open('POST', 'verifUpload.php', true);
   alert("2");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   alert("3");
  xhr.send('keyFile='+ keyFile);
   alert("4");
  xhr.onreadystatechange = function(){
    if(xhr.readyState == 4) {
      if(xhr.responseText != 'false') {
        var response = eval('('+xhr.responseText+')');
        
        document.getElementById('fileName').innerHTML = response.filename;
        document.getElementById('progress').innerHTML =
          Math.round(response.current / response.total * 100) + '%';
        alert("xhs"+response);
        if(response.done != 1) {
          verifUpload();
        }
      } else {
        verifUpload();
      }
    }
  };
  
  */
    $.ajax({
               type: "POST",
               url: '<?php echo url_for('film/verifUpload'); ?>',
               data: 'keyFile='+ keyFile,
               success: function(reponse){
                   if(reponse != 'false') {
						var response = eval('('+reponse+')');
						
						$('#fileName').html(response.filename);
						$('#progress').html(Math.round(response.current / response.total * 100) + '%');
						if(response.done != 1) {
						  verifUpload();
						}
					  } else {
						verifUpload();
					  }
               }
             });
  

}
	</script>
		
		
	<script type="text/javascript">
		//fx: 'scrollDown'
		//easing: 'bounceout'		
		$(function() {
		/*
		$('#imageDefil').cycle({
				fx:     '<?php echo $fx; ?>',
				easing: '<?php echo $easing; ?>',
				delay:  -2000,
	            timeout: 7000
			});
			*/
			
			$('#imageDefil').cycle({
				fx:     'all',
				easing: '<?php echo $easing; ?>',
				delay:  -2000,
	            timeout: 7000
			});
			
			
			
			var tabs1 = $("#tabs").tabs({
			cookie: {
				// store cookie for a day, without, it would be a session cookie
				expires: 1
			}
		}); 			
			
			$("#destroylink").click(function (event) { 
				tabs1.tabs('destroy');
			});	
			$("#selectlink").click(function (event) { 
				tabs1.tabs('select', 2);
			});	
			$("#disablelink").click(function (event) { 
				tabs1.tabs('disable', 2);
			});	
			$("#removelink").click(function (event) { 
				tabs1.tabs('remove', 2);
			});	
			$("#addlink").click(function (event) { 
				tabs1.tabs('add', "ajax/content1.html", "Added Tab");
			});			
			
			
			$(".multiselect").multiselect();
			$('#switcher').themeswitcher();
			
			// add themeswitcher
			/*
			$(function(){ 
				var ts = $('<div class="ui-button ui-widget ui-state-default ui-corner-all" style="font-size: 0.8em; padding: 2px 5px; position: absolute; top: 20px; right: 10px;">Click here to add Themeswitcher!</div>')
				.appendTo('body')
				.bind("click", function() {
					ts.text("Loading Themeswitcher...");
					$.getScript('http://ui.jquery.com/applications/themeroller/themeswitchertool/', function() {
						ts.removeClass("ui-button ui-widget ui-state-default ui-corner-all").text("").unbind("click").themeswitcher(); 
					});
				}); 
			});		
			*/			
		});		

	</script>


<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20866985-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

  </head>
  <body>

    <div id="wrapper">

	  <div id="bottom_frame">
	      <div id="top_frame">
		  <div id="header">
		      <h1><a href="" title="Accueil">Dvdtheque</a></h1>
		      <h2>| Annuaire de films</h2>
		      <div id="rss">
			  <a href="rss.php"><img src="/images/spacer.gif" width="64" height="67" alt="Flux RSS" /></a>
		      </div>
		      <div id="navigation">
				  <ul>
						<li><a id="menuFilm" href="<?php echo url_for('video/index?t=film'); ?>" title="Films">Films</a></li>
						<li><a id="menuSpectacle" href="<?php echo url_for('video/index?t=spectacle'); ?>" title="Spectacles"> Spectacles</a></li>
						<li><a id="menuSerie" href="<?php echo url_for('serie/index'); ?>" title="Series">Series</a></li>
						<li><a id="menuActeur" href="<?php echo url_for('personne/index?p=acteur'); ?>" title="Acteurs">Acteurs</a></li>
						<li><a id="menuRealisateur" href="<?php echo url_for('personne/index?p=realisateur'); ?>" title="Réalisateurs">Réalisateurs</a></li>
				  </ul>
		      </div>
		      <div id="welcome">
			  <div id="explic">
					Les cinemas 
					<?php 
					$i=0;
					foreach($sf_request->getAttribute('proprio') as $proprio){ 
					
						if($sf_user->getAttribute("proprio")){
							if($proprio->getId()==$sf_user->getAttribute("proprio")->getId()){
								$class='encadre'.$proprio->getId();
								$class2='barre'.$proprio->getId();
								$lien=false;
							}else{
								$class='barre'.$proprio->getId();
								$class2='encadre'.$proprio->getId();
								$lien=true;
							}
						}else{
							$class='encadre'.$proprio->getId();
							$class2='barre'.$proprio->getId();
							$lien=true;
						}
						if($i!=0){
							echo ' et ';
						}
						if($lien){
					?>
						<a href="<?php echo url_for('video/filtrerVideo?id='.$proprio->getId()); ?>" onMouseOver="$('#pro<?php echo $proprio->getId(); ?>').attr('class','<?php echo $class2; ?>')" onMouseOut="$('#pro<?php echo $proprio->getId(); ?>').attr('class','<?php echo $class; ?>')">
					<?php
						}
					?>
							<span id="pro<?php echo $proprio->getId(); ?>" class="<?php echo $class; ?>" ><?php echo $proprio; ?></span>
					<?php
						if($lien){
					?>
						</a>
					<?php
						}
						$i++;
					} 
					?>
					sont heureux de vous présenter leurs films </div>
			  <?php if(!$sf_user->getAttribute("login")){ ?>
				<span <?php if($sf_request->getAttribute("incorr")){ echo 'style="font-size:10px;color:red;"'; }else{ echo 'style="visibility: hidden;"'; }?> >Login ou mot de passe incorrecte</span>
				  <div id="connectionform">
					  <form action="<?php echo url_for('utilisateur/connection') ?>" method="post">
						<table>
							<tr>
								<td>
									<label for="login">Login: </label>
								</td>
								<td>
									<input name="login" style="width:100px;" type="text" value="<?php echo $sf_request->getParameter('login'); ?>" id="login" /><br/>
								</td>
							</tr>
							<tr>
								<td>
									<label for="login">Pass: </label>
								</td>
								<td>
									<input name="pass" style="width:100px;" type="password" value="" id="pass" />
								</td>
								<td>
									<input type="submit" id="connectionsubmit" alt="connection" value="OK" />
								</td>
							</tr>
							<tr>
								<td colspan="3" align="center">
									<a href="<?php echo url_for('utilisateur/new'); ?>" class="iframe300_300">mot de passe oublié?</a>
									<a href="<?php echo url_for('utilisateur/new'); ?>" class="iframe300_300">s'inscrire</a>
								</td>
							</tr>
						</table>
					  </form>
				  </div>
			  <?php }else{ ?>
				<div id="connecte">
					<div style="margin-bottom:7px;">
						<i>Bonjour,</i> <b><?php echo $sf_user->getAttribute("login"); ?></b><br/>
						<?php if($sf_user->getAttribute("admin")){ echo '<span style="font-size:10px;"><i>Vous etes un Administrateur</i></span>'; } ?>
					</div>
					<a href="<?php echo url_for('utilisateur/deconnection') ?>">Deconnection</a>
				</div>
			  <?php } ?>
		      </div>
		      <div id="searchform">
				  <form action="<?php echo url_for('recherche/index') ?>" method="post">
					  <input name="query" type="text" class="searchtext" value="<?php if($sf_request->getParameter('query')!=''){ echo $sf_request->getParameter('query'); }else{ echo 'Recherche'; }; ?>" id="search_keywords" onfocus="if (this.value == 'Recherche') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Recherche';}" />
					  <input type="image" src="/images/spacer.gif" id="searchsubmit" alt="Recherche" value="search" />
				  </form>
				  <a href="<?php echo url_for('recherche/avance'); ?>" id="rechercheAv" title="recherche_avancee">Recherche avancée</a>
		      </div>
		  </div>
		  <div id="container">
                      <div id="content">

                            <?php if ($sf_user->hasFlash('notice')): ?>
                              <div class="flash_notice">
                                <?php echo $sf_user->getFlash('notice') ?>
                              </div>
                            <?php endif; ?>

                            <?php if ($sf_user->hasFlash('error')): ?>
                              <div class="flash_error">
                                <?php echo $sf_user->getFlash('error') ?>
                              </div>
                            <?php endif; ?>

                            <div class="content">
                              <?php echo $sf_content ?>
                            </div>



                      </div>
                      <div id="sidebar">
                              <ul>
                                  <li>
                                      <?php
                                      $videos=$sf_request->getAttribute('derVideo');
                                      ?>
                                      <a href="<?php echo url_for('nouveautes/index') ?>" title="Derniers ajouts"><h3>Derniers ajouts</h3></a>
										<div id="derFilms">
                                          <div id="imageDefil" class="center" >
												<?php
												$testSaison=array();
												foreach($videos as $video){
													if($video->getImage()!=""){
														$image='videos/'.$video->getImage();
													}else{
														$image='image_vide.jpeg';
													}
													
													$lien=url_for('video/show?id='.$video->getId());
													$first=false;
													$type=$video->getType();
													if($type=="episode"){
														if(!$testSaison[$video->getSaison()->getId()]){
															$testSaison[$video->getSaison()->getId()]=true;
															$first=true;
															if($video->getSaison()->getImage()!=""){
																$image='saisons/'.$video->getSaison()->getImage();
															}else{
																$image='image_vide.jpeg';
															}
															$lien=url_for('saison/show?id='.$video->getSaison()->getId());
														}
													}
													if($type!="episode" || ($type=="episode" && $first)){
												?>
														<a class="lienderfilm" href="<?php echo url_for('video/show?id='.$video->getId()) ?>" title="<?php echo $video->getTitre(); ?>">
															<div style="text-align: center;" class="bordure">
																<img class="imgder" src="<?php echo '/uploads/'.$image; ?>" alt="<?php echo $video->getTitre(); ?>" height="160" width="120"/>
															</div>
														</a>
												<?php
													}
												}
												?>
											</div>
										</div>
                                                  <span id="fich" style="display:none;"><?php echo url_for('video/ajaxDerVideo') ?></span>
                                                  <span id="tab" style="display:none;"><?php echo $sf_request->getAttribute('tab'); ?></span>


                                  </li>
                                  <li>
                                      <h3>Navigation</h3>
										
                                      <ul>
										  <li><a href="" title="Accueil">Accueil</a></li>
                                          <li class="page_item"><a href="<?php echo url_for('note/index'); ?>" title="Top Votes">Top Notes</a></li>
                                          <li class="page_item"><a href="<?php echo url_for('nouveautes/index') ?>" title="Nouveaut&eacute;s">Nouveaut&eacute;s</a></li>
										  <li class="page_item"><a href="<?php echo url_for('categorie/index'); ?>" title="categories">Catégories</a></li>
                                          
										  <li class="page_item"><a href="<?php echo url_for('recherche/index'); ?>" id="rechercheAv" title="recherche_avancee">Recherche avancée</a></li>
                                      </ul>
                                  </li>
                                  <li>
                                      <h3>Statistiques</h3>
                                      <ul class='xoxo blogroll'>
                                          <li><a href="<?php echo url_for('video/index'); ?>"><?php echo $sf_request->getAttribute('nbfilms'); ?> Fims</a></li>
                                          <li><a href="<?php echo url_for('video/index'); ?>"><?php echo $sf_request->getAttribute('nbspectacles'); ?> Spactacles</a></li>
                                          <li><a href="<?php echo url_for('serie/index'); ?>"><?php echo $sf_request->getAttribute('nbseries'); ?> Series</a></li>

                                      </ul>
                                  </li>
                              </ul>
                      </div>
                      <div class="endline"></div>
		  </div>
		  <div id="footer">
		      <div class="credit">
			  Copyright &copy; 2010 - Tous droits réservés - Propulsé par : <a href="" title="Dvdtheque">Dvdtheque</a>

		      </div>
		  </div>
	      </div>
	  </div>
      </div>
      <script type="Text/Javascript">
		      if(document.links.length > 0)
		      {
			      for(var i=0; i < document.links.length; i++)
			      {
				      if (document.links[i].className.indexOf("_blank") > -1)
				      {
					      document.links[i].target="_blank";
				      }
			      }
		      }
      </script>
          <script type="text/javascript">
window.setInterval("affichImage()", 5000); 


    </script>
 
  </body>
</html>