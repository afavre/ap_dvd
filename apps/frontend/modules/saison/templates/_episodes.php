
<table width="100%" CELLSPACING="0" >
	<?php 
	for($i=1;$i<=$saison->getMaxEpisodesTot();$i++){
			include_partial('video/episode', array('saison' => $saison, 'i' => $i, 'form' => $form, 'qualites' => $qualites, 'versions' => $versions));
	}
	?>
</table>