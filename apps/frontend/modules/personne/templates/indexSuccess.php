<?php
$typeMaj=ucfirst($type);

if($type!=""){
	if($lettre!=''){ 
		if($lettre=='autre'){
			echo utf8_encode('<h1><img src="/images/'.$type.'bis.png" />'.$typeMaj.'s commençant par un caractere special</h1>');
		}else{
			echo utf8_encode('<h1><img src="/images/'.$type.'bis.png" />'.$typeMaj.'s commençant par la lettre "'.$lettre.'"<a href="'.url_for('personne/index?p='.$type).'" class="right lienInfo"><i>afficher tout</i></a></h1>');
		}
	}else{
		echo '<h1><img src="/images/'.$type.'bis.png" /> Tous les '.$typeMaj.'s</h1>';
	}
}else{
	echo '<h1>Tous les Acteurs et R&eacute;alisateurs</h1>';
}
?>

<div id="list">
	
	<?php
	$lienPage = 'personne/index';
	$lienLettre = 'personne/index';
	if($type){
		$paramPage['p'] = $type;
		$paramLettre['p'] = $type;
	}
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
	
	<?php if(count($pager['getResultsPageAct'])>0 ){ ?>
    <?php include_partial('personne/listPersonne', array('personnes' => $pager['getResultsPageAct'])) ?>
	<?php }else{ ?>
		<div class="aucun"><?php echo utf8_encode('Aucun '.$type.' n\'a été trouvé'); ?></div>
	<?php } ?>
	
	
	<?php 
	if ($pager['haveToPaginate']){
		include_partial('video/pagination', array('pager' => $pager, 'lien' => $lienPage, 'param' => $paramPage));
	}
	?>
 
	<div class="clear"></br></div>
	
	<div class="pagination_desc centre">
	  <?php if (count($pager['getResultsPageAct'])>0){ ?>
		<strong><?php echo count($pager['getResultsPageAct']) ?></strong> <?php echo $type; ?>s
	  <?php } ?>
	 
	  <?php if ($pager['haveToPaginate']): ?>
		- page <strong><?php echo $pager['getPage'] ?>/<?php echo $pager['getLastPage'] ?></strong>
	  <?php endif; ?>
	</div>
	</div>
	<div class="centre" style="margin-top:60px;"><img id="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
</div>