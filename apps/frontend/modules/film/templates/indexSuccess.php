
<?php use_stylesheet('films.css') ?>
<?php use_helper('Text') ?>
<?php 
if($lettre!=''){ 
	if($lettre=='autre'){
		echo utf8_encode('<h2>Films commençant par un caractere special</h2>');
	}else{
		echo utf8_encode('<h2>Films commençant par la lettre "'.$lettre.'"<a href="'.url_for('film/index').'" class="right lienInfo"><i>afficher tout</i></a></h2>');
	}
}else{
	echo '<h2>Tous les Films</h2>';
}
?>
<div id="list">

	<table id="tableLettre" width="100%" class="centre" cellspacing="0">
		<tr>
			<?php if($lettre=='autre'){
					$lettreSel='lettreSel';
					$javascript='';
				}else{
					$lettreSel='';
					$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="location.href=\''.url_for('film/index?le=autre') .'\'" onMouseOut="this.style.backgroundColor=\'\';"';
					//$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="lettre(\''. url_for('film/index?le=autre') .'\',\'autre\');return false;" onMouseOut="this.style.backgroundColor=\'\';"';
				}?>
			<td width="3.7%" class="<?php echo $lettreSel; ?>" <?php echo $javascript; ?> >
					#
			</td>
			<?php for( $i='A';$i<'Z';$i++){?>
				
				<?php if($i==$lettre){
					$lettreSel='lettreSel';
					$javascript='';
				}else{
					$lettreSel='';
					$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="location.href=\''.url_for('film/index?le='.$i) .'\'" onMouseOut="this.style.backgroundColor=\'\';"';
					//$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="lettre(\''. url_for('film/index?le='.$i) .'\',\''.$i .'\');return false;" onMouseOut="this.style.backgroundColor=\'\';"';
				}?>
				<td width="3.7%" class="<?php echo $lettreSel; ?>" <?php echo $javascript; ?> >
						<?php echo $i ?>
				</td>
			<?php } ?>
			<?php if($lettre=='Z'){
					$lettreSel='lettreSel';
					$javascript='';
				}else{
					$lettreSel='';
					$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="location.href=\''.url_for('film/index?le=Z') .'\'" onMouseOut="this.style.backgroundColor=\'\';"';
					//$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="lettre(\''. url_for('film/index?le=Z') .'\',\'Z\');return false;" onMouseOut="this.style.backgroundColor=\'\';"';
				}?>
			<td width="3.7%" class="<?php echo $lettreSel; ?>" <?php echo $javascript; ?> >
					Z
			</td>
		</tr>
	</table>
	<div id="listbis">
		<?php 
		if(count($pager)>0 || sizeof($sagas)){ ?>
		<?php include_partial('film/listFilm', array('films' => $pager->getResults())) ?>

		<?php }else{ ?>
			<div class="centre rouge"><?php echo utf8_encode('Aucun films n\'a été trouvé'); ?></div>
		<?php } ?>
	<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination centre">
    <a href="<?php echo url_for('film/index?page=1&le='.$lettre) ?>">
      <img src="/images/first.png" alt="First page" title="First page" />
    </a>
 
    <a href="<?php echo url_for('film/index?page='.$pager->getPreviousPage().'&le='.$lettre) ?>">
      <img src="/images/previous.png" alt="Previous page" title="Previous page" />
    </a>
 
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo '<span class="lettreSel">'.$page.'</span>'; ?>
      <?php else: ?>
         <a href="<?php echo url_for('film/index?page='.$page.'&le='.$lettre) ?>"><?php echo $page ?></a>
       <?php endif; ?>
    <?php endforeach; ?>
 
    <a href="<?php echo url_for('film/index?page='.$pager->getNextPage().'&le='.$lettre) ?>">
      <img src="/images/next.png" alt="Next page" title="Next page" />
    </a>

 
    <a href="<?php echo url_for('film/index?page='.$pager->getLastPage().'&le='.$lettre) ?>">
      <img src="/images/last.png" alt="Last page" title="Last page" />
    </a>

 
   
  </div>
  
<?php endif; ?>
 
<div class="pagination_desc centre">
  <strong><?php echo count($pager) ?></strong> films
 
  <?php if ($pager->haveToPaginate()): ?>
    - page <strong><?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?></strong>
  <?php endif; ?>
</div>

	</div>
	<div class="centre" style="margin-top:60px;"><img id="loader" src="/images/loader.gif" style="display:none;" alt="" /></div>
</div>
