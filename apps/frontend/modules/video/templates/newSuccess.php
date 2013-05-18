<?php 
	echo $episode->getId();
	echo "/-/-/";
		
	if($episode->getProprietaires()!=0){
		$poss="";
		$onMouseOver="this.style.backgroundColor='#e3d5b6';";
		$onMouseOut="this.style.backgroundColor='';";
	}else{
		$poss="nonPossede";
		$onMouseOver="";
		$onMouseOut="";
	}
	include_partial('video/episodeVis', array('episode' => $episode, 'qualites' => $qualites, 'versions' => $versions));
	if($sf_user->getAttribute("admin")){
		echo "/-/-/";
		include_partial('video/episodeEdit', array('episode' => $episode, 'i' => $i, 'form' => $form2));
	}
?>