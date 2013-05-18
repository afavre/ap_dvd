
<h2>Tous les Acteurs</h2>
<div id="list">
	<table width="90%" class="centre">
		<tr>
			<?php for( $i='A';$i<'Z';$i++){?>
				
				<?php if($i==$lettre){
					$lettreSel='lettreSel';
					$javascript='';
				}else{
					$lettreSel='';
					$javascript='onmouseover="this.style.backgroundColor=\'#f6e0d0\';style.cursor=\'pointer\';" onClick="location.href=\''.url_for('acteur/index?le='.$i) .'\'" onMouseOut="this.style.backgroundColor=\'\';"';
				}?>
				
				<td class="<?php echo $lettreSel; ?>" <?php echo $javascript; ?> >
						<?php echo $i ?>
				</td>
			<?php } ?>
			<?php if($lettre=='Z'){
					$lettreSel='lettreSel';
					$javascript='';
				}else{
					$lettreSel='';
					$javascript='onmouseover="this.style.backgroundColor=\'#f6e0d0\';style.cursor=\'pointer\';" onClick="location.href=\''.url_for('acteur/index?le=Z') .'\'" onMouseOut="this.style.backgroundColor=\'\';"';
					// $javascript='onmouseover="this.style.backgroundColor=\'#f6e0d0\';style.cursor=\'pointer\';" onClick="lettre(\''. url_for('acteur/index?le=Z') .'\',\'Z\');return false;" onMouseOut="this.style.backgroundColor=\'\';"';
				}?>
			<td class="<?php echo $lettreSel; ?>" <?php echo $javascript; ?> >
					Z
			</td>
		</tr>
	</table>

	<div id="listbis">
	<?php if(count($pager)>0 ){ ?>
    <?php include_partial('acteur/listActeur', array('acteurs' => $pager->getResults())) ?>
	<?php }else{ ?>
		<div class="centre rouge"><?php echo utf8_encode('Aucun acteur n\'a été trouvé'); ?></div>
	<?php } ?>
	<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination centre">
	<a href="<?php echo url_for('acteur/index?page=1&le='.$lettre) ?>">
      <img src="/images/first.png" alt="First page" title="First page" />
    </a>
 
    <a href="<?php echo url_for('acteur/index?page='.$pager->getPreviousPage().'&le='.$lettre) ?>">
      <img src="/images/previous.png" alt="Previous page" title="Previous page" />
    </a>
 
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo '<span class="lettreSel">'.$page.'</span>'; ?>
      <?php else: ?>
         <a href="<?php echo url_for('acteur/index?page='.$page.'&le='.$lettre) ?>"><?php echo $page ?></a>
       <?php endif; ?>
    <?php endforeach; ?>
 
    <a href="<?php echo url_for('acteur/index?page='.$pager->getNextPage().'&le='.$lettre) ?>">
      <img src="/images/next.png" alt="Next page" title="Next page" />
    </a>

 
    <a href="<?php echo url_for('acteur/index?page='.$pager->getLastPage().'&le='.$lettre) ?>">
      <img src="/images/last.png" alt="Last page" title="Last page" />
    </a>

 
   
  </div>
  
<?php endif; ?>
 
	<div class="pagination_desc centre">
	  <strong><?php echo count($pager) ?></strong> acteurs
	 
	  <?php if ($pager->haveToPaginate()): ?>
		- page <strong><?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?></strong>
	  <?php endif; ?>
	</div>
	</div>
	<div class="centre" style="margin-top:60px;"><img id="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
</div>