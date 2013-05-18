<?php
	$lien .= '?';
	if(sizeof($param)>0){
		foreach($param as $i => $p){
			$lien .= $i.'='.$p.'&';
		}
	}
	?>
	<div class="clear"></br></div>
  <div class="pagination centre">
	<?php if($pager['getPage']>1){ ?>
		<a href="<?php echo url_for($lien.'page=1') ?>"><img src="/images/premier.png" alt="Previous page" title="Previous page" /></a>
		<a href="<?php echo url_for($lien.'page='.$pager['getPreviousPage']) ?>"><img src="/images/prec.png" alt="First page" title="First page" /></a>
	<?php }else{ ?>
		<span class='flechDis'><img src='/images/premier_gris.png' /></span>
		<span class='flechDis'><img src='/images/prec_gris.png' /></span>
	<?php } ?>
	
	<?php
		if($pager['pageInf'] > 1){
			echo '...';
		}
	?>
	
    <?php for ($page=$pager['pageInf'];$page<=$pager['pageSup'];$page++): ?>
      <?php if ($page == $pager['getPage']): ?>
        <?php echo '<span class="this-page">'.$page.'</span>'; ?>
      <?php else: ?>
         <a href="<?php echo url_for($lien.'page='.$page) ?>"><?php echo $page ?></a>
       <?php endif; ?>
    <?php endfor; ?>
	
	<?php
		if($pager['pageSup'] < $pager['getLastPage']){
			echo '...';
		}
	?>
	
	<?php if($pager['getPage']<$pager['getLastPage']){ ?>
		<a href="<?php echo url_for($lien.'page='.$pager['getNextPage']) ?>"><img src="/images/suiv.png" alt="Next page" title="Next page" /></a>
		<a href="<?php echo url_for($lien.'page='.$pager['getLastPage']) ?>"><img src="/images/dernier.png" alt="Last page" title="Last page" /></a>
	<?php }else{ ?>
		<span class='flechDis'><img src='/images/suiv_gris.png' /></span>
		<span class='flechDis'><img src='/images/dernier_gris.png' /></span>
	<?php } ?>
	<div class="clear"></br></div>
  </div>
