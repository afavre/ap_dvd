<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Dvdtheque - Admin</title>
    <link rel="shortcut icon" href="/images/icone.png" />
	<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/ui.all.css" />

	
    <?php use_stylesheet('admin.css') ?>
    <?php use_stylesheet('ui.multiselect.css') ?>

    <?php use_javascript('jquery-1.4.4.min.js') ?>
    <?php use_javascript('jquery-ui-1.8.7.custom.min.js') ?>
    <?php use_javascript('plugins/localisation/jquery.localisation-min.js') ?>
    <?php use_javascript('ui.multiselect.js') ?>
    <?php use_javascript('fancybox/jquery.fancybox-1.3.4.js') ?>
    <?php use_javascript('script_demarrage_admin.js') ?>
    <?php use_javascript('script.js') ?>
	<?php use_javascript('verif.js') ?>
    <?php use_javascript('search.js') ?>

    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
	
	
	<link rel="stylesheet" type="text/css" href="/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	

<script>
	window.onbeforeunload = function(){
		$("#loader").show();
	} 
</script>

  </head>
  <body>
			
		<div id="container">
		<div id='loader' class="invisible">
			<div id='fond_loader'>
				<div id="info_loader">
					<div id='image_loader'>
						<img width="70" src="/images/loader-admin.gif" /> 
					</div>
					<div id='txt_loader'>
						<br />Chargement en cours...
						<br/>Veuillez patienter. 
					</div>
				</div>
			</div>
		</div>
		  <div id="header_admin">
			<div id="img_header">
				<img src="/images/logo.jpg" alt="Jobeet Job Board" />
			</div>
		  </div>
		  <?php if ($sf_user->isAuthenticated()): ?>
		  <?php 
			$tab = split('[/.-]', $_SERVER["PHP_SELF"]);
			$module = $tab[3];
			if($module=="video"){
				if($sf_request->getParameter('type')){
					$module=$sf_request->getParameter('type');
				}else{
					$module='film';
				}
			}
		  ?>
		  <div id="menu">
			<table class="princ">
				<tr>
				  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('video/index?type=film'); ?>'"
				  <?php 
				  if($module=='film' || $module=='spectacle' || $module=='serie' || $module=='categorie' || $module=='motscle' || $module=='version' || $module=='qualite' || $module=='personne' || $module=='nationalite' || $module=='saga' || $module=='saison' || $module=='episode' || $module==''){
						echo ' class="sel"';
				  }
				  ?>
				  >Vid&eacute;os</td>
			  
			  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('utilisateur'); ?>'"
				  <?php 
				  if($module=='utilisateur'){
						echo ' class="sel"';
				  }
				  ?>
				  >
				<?php echo link_to('Utilisateurs', '@utilisateur') ?>
			  </td>
			  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('sauvegarde_visiteur'); ?>'"
				  <?php 
				  if($module=='visiteur'){
						echo ' class="sel"';
				  }
				  ?>
				  >Visiteur</td>
			  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('sf_guard_user'); ?>'"
				  <?php 
				  if($module=='sf_guard_user'){
						echo ' class="sel"';
				  }
				  ?>
				  >Administrateurs</td>
				 
				<td style="border-left:1px #aaa solid;" onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('sf_guard_signout'); ?>'" >
					<?php echo link_to('Deconnexion', 'sf_guard_signout') ?>
				</td>
			   </tr>
			</table>
			<div class="sel">
			<?php 
				  if($module=='film' || $module=='spectacle' || $module=='serie' || $module=='categorie' || $module=='motscle' || $module=='version' || $module=='qualite' || $module=='personne' || $module=='nationalite' || $module=='saga' || $module=='saison' || $module=='episode' || $module==''){
			?>
					<table class="second">
						<tr class="sel">
						  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('video/index?type=film'); ?>'"
						  <?php 
						  if($module=='film' || $module=='saga' || $module==''){
								echo ' class="sel2"';
						  }
						  ?>
						  >Films</td>
						  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('video/index?type=spectacle'); ?>'"
						  <?php 
						  if($module=='spectacle'){
								echo ' class="sel2"';
						  }
						  ?>
						  >Spectacles</td>
						  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('serie'); ?>'"
							  <?php 
							  if($module=='serie' || $module=='saison' || $module=='episode'){
									echo ' class="sel2"';
							  }
							  ?>
							  >Series</td>
					  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('personne'); ?>'"
						  <?php 
						  if($module=='personne'){
								echo ' class="sel2"';
						  }
						  ?>
						  >Casting</td>
					  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('version'); ?>'"
						  <?php 
						  if($module=='version'){
								echo ' class="sel2"';
						  }
						  ?>
						  >Versions</td>
					  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('qualite'); ?>'"
						  <?php 
						  if($module=='qualite'){
								echo ' class="sel2"';
						  }
						  ?>
						  >Qualites</td>
					  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('categorie'); ?>'"
						  <?php 
						  if($module=='categorie'){
								echo ' class="sel2"';
						  }
						  ?>
						  >Categories</td>
					  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('motscle'); ?>'"
						  <?php 
						  if($module=='motscle'){
								echo ' class="sel2"';
						  }
						  ?>
						  >Mots cle</td>
						 
					   </tr>
					</table>
			
			<?php
				}
			?>
			</div>
			<div class="sel2">
			<?php 
				  if($module=='film' || $module=='saga' || $module==''){
			?>
				<table class="trois">
					<tr class="sel2">
					  
					  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('video/index?type=film'); ?>'"
						  <?php 
						  if($module=='film' || $module==''){
								echo ' class="sel3"';
						  }
						  ?>
						  >Films</td>
					  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('saga'); ?>'"
						  <?php 
						  if($module=='saga'){
								echo ' class="sel3"';
						  }
						  ?>
						  >Sagas</td>
					 
				   </tr>
				</table>
			<?php 
				 }else if($module=='serie' || $module=='saison' || $module=='episode'){
			?>
				<table class="trois">
					<tr class="sel2">
					  
				  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('serie'); ?>'"
					  <?php 
					  if($module=='serie'){
							echo ' class="sel3"';
					  }
					  ?>
					  >Series</td>
				  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('saison'); ?>'"
					  <?php 
					  if($module=='saison'){
							echo ' class="sel3"';
					  }
					  ?>
					  >Saisons</td>
				  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('video/index?type=episode'); ?>'"
					  <?php 
					  if($module=='episode'){
							echo ' class="sel3"';
					  }
					  ?>
					  >Episodes</td>
					 
				   </tr>
				</table>
			<?php 
				 }else if($module=='personne' || $module=='nationalite'){
			?>
				<table class="trois">
					<tr class="sel2">
					  
				  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('personne'); ?>'"
					  <?php 
					  if($module=='personne'){
							echo ' class="sel3"';
					  }
					  ?>
					  >Personnes</td>
				  <td onmouseover="style.cursor='pointer';" onClick="location.href='<?php echo url_for('nationalite'); ?>'"
					  <?php 
					  if($module=='nationalite'){
							echo ' class="sel3"';
					  }
					  ?>
					  >Nationalites</td>
					 
				   </tr>
				</table>
				<?php 
				 }
			?>
			</div>
		  </div>
		 <?php endif ?>
		  <div id="content_admin">
			  <div id="info_content">
				<?php echo $sf_content ?>
					 

			  </div>
		  </div>

		  <div id="footer">
			  <div id="img_footer">
				<img width="100" src="/images/logo.jpg" alt="Jobeet Job Board" />
				powered by <a href="http://www.symfony-project.org/">
				<img src="/images/symfony.gif" alt="symfony framework" /></a>
			  </div>
		  </div>
		</div>
  </body>
</html>