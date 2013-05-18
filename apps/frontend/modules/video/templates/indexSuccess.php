
<?php use_stylesheet('films.css') ?>
<?php use_helper('Text') ?>
<?php 
$type=$sf_request->getParameter('t');
$typeMaj=ucfirst($type);
if($lettre!=''){ 
	if($lettre=='autre'){
		echo utf8_encode('<h1><img src="/images/'.$type.'bis.png" />'.$typeMaj.'s commençant par un caractere special</h1>');
	}else{
		echo utf8_encode('<h1><img src="/images/'.$type.'bis.png" />'.$typeMaj.'s commençant par la lettre "'.$lettre.'"<a href="'.url_for('video/index?t='.$type).'" class="right lienInfo"><i>afficher tout</i></a></h1>');
	}
}else{
	echo '<h1><img src="/images/'.$type.'bis.png" /> Tous les '.$typeMaj.'s</h1>';
}
?>
<div id="list">

	<?php
	$lienPage = 'video/index';
	$lienLettre = 'video/index';
	if($type){
		$paramPage['t'] = $type;
		$paramLettre['t'] = $type;
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
	
		<?php 
		if(count($pager['getResults'])>0 || sizeof($sagas)){ ?>
		<?php include_partial('video/list', array('videos' => $pager['getResultsPageAct'])) ?>

		<?php }else{ ?>
			<div class="aucun"><?php echo utf8_encode('Aucun '.$type.'s n\'a été trouvé'); ?></div>
		<?php } ?>
		
		
	<?php 
	if ($pager['haveToPaginate']){
		include_partial('video/pagination', array('pager' => $pager, 'lien' => $lienPage, 'param' => $paramPage));
	}
	?>
	<div class="clear"></br></div>
  
<div class="pagination_desc centre">
	<?php if (count($pager['getResults'])>0){ ?>
		<strong><?php echo count($pager['getResults']) ?></strong> <?php echo $type; ?>s
	<?php } ?>
  <?php if ($pager['haveToPaginate']): ?>
    - page <strong><?php echo $pager['getPage'] ?>/<?php echo $pager['getLastPage'] ?></strong>
  <?php endif; ?>
</div>

	</div>
	<div class="centre" style="margin-top:60px;"><img id="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
</div>
