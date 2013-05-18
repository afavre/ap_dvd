<?php 
$listEp = $saison->getEpisodesOrdre();
if($listEp[$i]){
	$episode = $listEp[$i];
		
	if($episode->getProprietaires()!=0){
		$poss="";
		$onMouseOver="this.style.backgroundColor='#e3d5b6';";
		$onMouseOut="this.style.backgroundColor='';";
	}else{
		$poss="nonPossede";
		$onMouseOver="";
		$onMouseOut="";
	}
?>
	<tr id="visEp<?php echo $episode->getId(); ?>" class="vis <?php echo $poss; ?>" onMouseOver="<?php echo $onMouseOver; ?>" onMouseOut="<?php echo $onMouseOut; ?>">
		<?php include_partial('video/episodeVis', array('episode' => $episode, 'qualites' => $qualites, 'versions' => $versions)); ?>
	</tr>
<?php 
	if($sf_user->getAttribute("admin")){ ?>
		<tr id="editEp<?php echo $episode->getId(); ?>" class="edit invisible <?php echo $poss; ?>">
			<?php include_partial('video/episodeEdit', array('episode' => $episode, 'i' => $i, 'form' => $form)); ?>
		</tr>
<?php 
	} 
}else{
?>
	<tr id="visnotEp<?php echo $i; ?>" class="visnot nonPossede">
		<?php include_partial('video/episodeVisnot', array('saison' => $saison, 'i' => $i)); ?>
	</tr>
<?php
	if($sf_user->getAttribute("admin")){
?>
		<tr id="newEp<?php echo $i; ?>" class="new invisible nonPossede">							
			<?php include_partial('video/episodeNew', array('saison' => $saison, 'i' => $i, 'form' => $form)); ?>
		</tr>
<?php
	}
}
?>