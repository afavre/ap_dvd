<?php use_stylesheet('film.css') ?>
<?php use_helper('Text') ?>

<div>
        <h2>Recherche avancée</h2>
	
		   <div id="onglet">	
	
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Films</a></li>
				<li><a href="#tabs-2">Acteurs</a></li>
				<li><a href="#tabs-3">Realisateurs</a></li>
			</ul>

			<div id="tabs-1">
				<form action="<?php echo url_for('recherche/searchAdvance') ?>" method="post">
				<table>
					<tr>
						<td>
							<label for="version">Version:</label>
						</td>
						<td>
							<?php
										echo '<script type="text/javascript">
											var sel="";
										</script>';
										echo '<input type="hidden" name="tabSelVers" id="tabSelVers" value="" />';
									$selAll='';
								foreach($versions as $version){
										if($selAll!=""){
											$selAll.='/'.$version->getId();
										}else{
											$selAll=$version->getId();
										}
									echo '<input type="hidden" name="versVal'.$version->getId().'" id="versVal'.$version->getId().'" value="1" />';
									
									echo '<a href="" onclick="selVers(\''.$version->getId().'\');return false;" class="nonselRech" id="vers'.$version->getId().'">'.$version->getNom().'</a> | ';
								
									echo '<script type="text/javascript">
										if($("#versVal'.$version->getId().'").val()=="1"){
											$("#vers'.$version->getId().'").attr("class","selRech");
											if(sel!=""){
												sel+="/'.$version->getId().'";
											}else{
												sel="'.$version->getId().'";
											}
										}
									</script>';
								}
								echo '<input type="hidden" name="tabAllVers" id="tabAllVers" value="'.$selAll.'" />';
							?>
						</td>
					</tr>
					
					<tr>
						<td>
							<label for="qualite">Qualite:</label>
						</td>
						<td>
							<div id="qualites">
							<?php
										echo '<script type="text/javascript">
											var sel="";
										</script>';
										echo '<input type="hidden" name="tabSelQual" id="tabSelQual" value="" />';
									$selAll='';
								foreach($qualites as $qualite){
										if($selAll!=""){
											$selAll.='/'.$qualite->getId();
										}else{
											$selAll=$qualite->getId();
										}
									echo '<input type="hidden" name="qualVal'.$qualite->getId().'" id="qualVal'.$qualite->getId().'" value="0" />';
									echo '<a href="" onclick="selQual('.$qualite->getId().');return false;" class="nonselRech" id="qual'.$qualite->getId().'">'.$qualite->getNom().'</a> | ';
								
									echo '<script type="text/javascript">
										if($("#qualVal'.$qualite->getId().'").val()=="1"){
											$("#qual'.$qualite->getId().'").attr("class","selRech");
											if(sel!=""){
												sel+="/'.$qualite->getId().'";
											}else{
												sel="'.$qualite->getId().'";
											}
										}
									</script>';
								}
								echo '<input type="hidden" name="tabAllQual" id="tabAllQual" value="'.$selAll.'" />';
							?>
							</div>
						</td>
					</tr>
					
					<tr>
						<td>
							<label for="categorie">Categorie:</label>
						</td>
						<td>
							<?php 
							$taille=290;
							$taille2=20;
							?>
							<div class="HautMult" style="width:<?php echo $taille; ?>px;height:<?php echo $taille2; ?>px;">
							<span class="left">Selection: <span id="catNb"></span></span>
							<span class="right" style="margin-right:3px;"><a href="" onclick="AllSelCat();return false;">Tous S&eacute;lect</a> | <a href=""  onclick="AllSupprSelCat();return false;">Tous D&eacute;s&eacute;lect</a></span>
							</div>
							<div id="categories" style="overflow-y:auto;overflow-x:hidden; width:<?php echo $taille; ?>px; max-height:118px;border:1px solid #654b24;"> 
								<?php
									
										echo '<script type="text/javascript">
											var num=0;
											var sel="";
										</script>';
										echo '<input type="hidden" name="tabSelCat" id="tabSelCat" value="" />';
									$selAll='';
									$nbAll=0;
									foreach($categories as $categorie){
										$nbAll++;
										if($selAll!=""){
											$selAll.='/'.$categorie->getId();
										}else{
											$selAll=$categorie->getId();
										}
										echo '<input type="hidden" class="cat" name="catVal'.$categorie->getId().'" id="catVal'.$categorie->getId().'" value="0" />';
										echo '<div style="width:100%;" onmouseover="style.cursor=\'pointer\';" onclick="selCat('.$categorie->getId().');return false;" class="nonselRechMult" id="cat'.$categorie->getId().'">'.$categorie->getNom().'</div>';
									
										echo '<script type="text/javascript">
											if($("#catVal'.$categorie->getId().'").val()=="1"){
												num++;
												$("#cat'.$categorie->getId().'").attr("class","selRechMult");
												if(sel!=""){
													sel+="/'.$categorie->getId().'";
												}else{
													sel="'.$categorie->getId().'";
												}
											}
										</script>';
									}
									
										echo '<script type="text/javascript">
											$("#catNb").html(num);
											$("#tabSelCat").val(sel);
										</script>';
										echo '<input type="hidden" name="tabAllCat" id="tabAllCat" value="'.$selAll.'" />';
										echo '<input type="hidden" name="nbAllCat" id="nbAllCat" value="'.$nbAll.'" />';
								?>
							</div>
						</td>
					</tr>
					
					
					<tr>
						<td>
							<label for="duree">Duree:</label>
						</td>
						<td>
							de <input type="text" name="dureeMin" id="dureeMin" size="3" />min &agrave; <input type="text" name="dureeMax" id="dureeMax" size="3" />min
						</td>
					</tr>
					
					<tr>
						<td>
							<label for="annee">Annee:</label>
						</td>
						<td>
							de <input type="text" name="anneeMin" id="anneeMin" size="3" /> &agrave; <input type="text" name="anneeMax" id="anneeMax" size="3" />min
						</td>
					</tr>
					
					<tr>
						<td>
							<label for="acteurs">Acteurs:</label>
						</td>
						<td>
							<?php 
							$taille=350;
							$taille2=40;
							?>
							<div class="HautMult" style="width:<?php echo $taille; ?>px;height:<?php echo $taille2; ?>px;">
							<span class="left">Selection: <span id="actNb"></span></span>
							<span class="right" style="margin-right:3px;"><a href="" onclick="AllSelAct();return false;">Tous S&eacute;lect</a> | <a href=""  onclick="AllSupprSelAct();return false;">Tous D&eacute;s&eacute;lect</a></span>
							</br>
							<span class="right" style="margin-right:3px;"><input type="texte" onKeyUp="autoCompletionAct();return false;" name="autoAct" id="autoAct" /></span>
							</div>
							<div id="acteurs" style="overflow-y:auto;overflow-x:hidden; width:<?php echo $taille; ?>px; max-height:250px;border:1px solid #654b24;"> 
								<?php
									
										echo '<script type="text/javascript">
											var num=0;
											var sel="";
										</script>';
										echo '<input type="hidden" name="tabSelAct" id="tabSelAct" value="" />';
									$selAll='';
									$nbAll=0;
									foreach($acteurs as $acteur){
										$nbAll++;
										if($selAll!=""){
											$selAll.='/'.$acteur->getId();
										}else{
											$selAll=$acteur->getId();
										}
										
										if($acteur->getImage()!=""){
											$image='acteurs/'.$acteur->getImage();
										}else{
											$image='image_vide.jpeg';
										}
										echo '<input type="hidden" class="act" name="actVal'.$acteur->getId().'" id="actVal'.$acteur->getId().'" value="0" />';
										echo '<div style="width:100%;height:45px;" onmouseover="style.cursor=\'pointer\';" onclick="selAct('.$acteur->getId().');return false;" class="nonselRechMult" id="act'.$acteur->getId().'">
											<table>
												<tr>
													<td>
														<img src="/uploads/'.$image.'" height="40" />
													</td>
													<td>
														'.$acteur->getPrenom().' '.$acteur->getNom().'
													</td>
												</tr>
											</table>
										</div>';
									
										echo '<script type="text/javascript">
											if($("#actVal'.$acteur->getId().'").val()=="1"){
												num++;
												$("#act'.$acteur->getId().'").attr("class","selRechMult");
												if(sel!=""){
													sel+="/'.$acteur->getId().'";
												}else{
													sel="'.$acteur->getId().'";
												}
											}
										</script>';
									}
									
										echo '<script type="text/javascript">
											$("#actNb").html(num);
											$("#tabSelAct").val(sel);
										</script>';
										echo '<input type="hidden" name="tabAllAct" id="tabAllAct" value="'.$selAll.'" />';
										echo '<input type="hidden" name="nbAllAct" id="nbAllAct" value="'.$nbAll.'" />';
								?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" />
						</td>
					</tr>
				</table>
			</form>
					
			</div>
		
			<div id="tabs-2">

			</div>
		</div>

	</div>
</div>