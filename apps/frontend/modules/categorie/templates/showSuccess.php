<?php slot('title') ?>
  <?php echo $categorie->getNom(); ?>
<?php end_slot(); ?>

<?php use_stylesheet('job.css') ?>
<?php use_helper('Text') ?>

    <h1><?php echo $categorie->getNom() ?></h1>

    <div id="list">
		<?php
		$lienPage = 'categorie/show?id='.$categorie->getId();
		$paramPage = Array();
		if ($pager['haveToPaginate']){
			include_partial('video/pagination', array('pager' => $pager, 'lien' => $lienPage, 'param' => $paramPage));
		}
		?>
		
		<?php if(count($pager['getResultsPageAct'])>0 ){ ?>
		<?php include_partial('video/listVideo', array('videos' => $pager['getResultsPageAct'])) ?>
		<?php }else{ ?>
			<div class="centre rouge"><?php echo utf8_encode('Aucun Film n\'a été trouvé'); ?></div>
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


