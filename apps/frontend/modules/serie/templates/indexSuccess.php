<?php
	if($lettre!=''){ 
		if($lettre=='autre'){
			echo '<h1><img src="/images/seriebis.png" /> Séries commençant par un caractere special</h1>';
		}else{
			echo '<h1><img src="/images/seriebis.png" /> Séries commençant par la lettre "'.$lettre.'"<a href="'.url_for('serie/index').'" class="right lienInfo"><i>afficher tout</i></a></h1>';
		}
	}else{
		echo '<h1><img src="/images/seriebis.png" /> Toutes les Séries</h1>';
	}
?>

<div id="list">
	
	<?php
	$lienPage = 'serie/index';
	$lienLettre = 'serie/index';
	$paramPage = Array();
	$paramLettre = Array();
	if($lettre){
		$paramPage['le'] = $lettre;
	}
	include_partial('video/lettres', array('lettre' => $lettre, 'lien' => $lienLettre, 'param' => $paramLettre));
	?>

	<div id="listbis">
	
	<?php 
	if ($pager['haveToPaginate']){
		include_partial('video/pagination', array('pager' => $pager, 'lien' => $lienPage, 'param' => $paramPage));
	}
	?>
	
	<?php if(count($pager['getResults'])>0 ){ ?>
    <?php include_partial('serie/listSerie', array('series' => $pager['getResultsPageAct'])) ?>
	<?php }else{ ?>
		<div class="aucun"><?php echo 'Aucune série n\'a été trouvé'; ?></div>
	<?php } ?>
	
	<?php 
	if ($pager['haveToPaginate']){
		include_partial('video/pagination', array('pager' => $pager, 'lien' => $lienPage, 'param' => $paramPage));
	}
	?>
  
	<div class="clear"></br></div>
 
<div class="pagination_desc centre">
	<?php if (count($pager['getResults'])>0){ ?>
		<strong><?php echo count($pager['getResults']) ?></strong> series
	<?php } ?>
 
  <?php if ($pager['haveToPaginate']): ?>
    - page <strong><?php echo $pager['getPage'] ?>/<?php echo $pager['getLastPage'] ?></strong>
  <?php endif; ?>
</div>
	</div>
	<div class="centre" style="margin-top:60px;"><img id="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
</div>