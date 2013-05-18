
<div id="list">
<h1>Toutes les Categories</h1>
	
	<div id="listbis">
	
		<?php
		$lienPage = 'categorie/index';
		$paramPage = Array();
		if($lettre){
			$paramPage['le'] = $lettre;
		}
		if ($pager['haveToPaginate']){
			include_partial('video/pagination', array('pager' => $pager, 'lien' => $lienPage, 'param' => $paramPage));
		}
		?>
		
		<?php if(count($pager['getResultsPageAct'])>0 ){ ?>
		<?php include_partial('categorie/listCategorie', array('categories' => $pager['getResultsPageAct'])) ?>
		<?php }else{ ?>
			<div class="centre rouge"><?php echo utf8_encode('Aucun categorie n\'a été trouvé'); ?></div>
		<?php } ?>
	  
	  
			<?php 
			if ($pager['haveToPaginate']){
				include_partial('video/pagination', array('pager' => $pager, 'lien' => $lienPage, 'param' => $paramPage));
			}
			?>
		<div class="clear"></br></div>
	 
		<div class="pagination_desc centre">
		  <strong><?php echo count($pager['getResultsPageAct']) ?></strong> categories
		 
		  <?php if ($pager['haveToPaginate']): ?>
			- page <strong><?php echo $pager['getPage'] ?>/<?php echo $pager['getLastPage'] ?></strong>
		  <?php endif; ?>
		</div>
	</div>
	<div class="centre" style="margin-top:60px;"><img id="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
</div>