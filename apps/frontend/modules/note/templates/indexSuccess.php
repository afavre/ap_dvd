
<?php use_stylesheet('films.css') ?>
<?php use_helper('Text') ?>
<h1><?php echo utf8_encode('Les meilleurs notes'); ?></h1>
<div id="list">
<?php
	$lienPage = 'note/index';
	$paramPage = Array();
	if($lettre){
		$paramPage['le'] = $lettre;
	}
?>
	<div id="listbis">
		

		<?php 
		if ($pager['haveToPaginate']){
			include_partial('video/pagination', array('pager' => $pager, 'lien' => $lienPage, 'param' => $paramPage));
		}
		?>
	
		<?php 
		if(count($pager['getResults'])>0 || sizeof($sagas)){ ?>
		<?php include_partial('video/listVideo', array('videos' => $pager['getResultsPageAct'])) ?>

		<?php }else{ ?>
			<div class="centre rouge"><?php echo utf8_encode('Aucune videos n\'a été trouvé'); ?></div>
		<?php } ?>
	
		<?php 
		if ($pager['haveToPaginate']){
			include_partial('video/pagination', array('pager' => $pager, 'lien' => $lienPage, 'param' => $paramPage));
		}
		?>
		<div class="clear"></br></div>
 
		<div class="pagination_desc centre">
		  <strong><?php echo count($pager['getResults']) ?></strong> videos
		 
		  <?php if ($pager['haveToPaginate']): ?>
			- page <strong><?php echo $pager['getPage'] ?>/<?php echo $pager['getLastPage'] ?></strong>
		  <?php endif; ?>
		</div>
	</div>
	<div class="centre" style="margin-top:60px;"><img id="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
</div>
