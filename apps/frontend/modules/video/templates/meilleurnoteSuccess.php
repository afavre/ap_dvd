
<?php use_stylesheet('films.css') ?>
<?php use_helper('Text') ?>
<h1><?php echo utf8_encode('Les meilleurs notes'); ?></h1>
<div id="list">

	<div id="listbis">
		<?php 
		if(count($pager)>0 || sizeof($sagas)){ ?>
		<?php include_partial('film/listFilm', array('films' => $pager->getResults())) ?>

		<?php }else{ ?>
			<div class="centre rouge"><?php echo utf8_encode('Aucun films n\'a été trouvé'); ?></div>
		<?php } ?>
	<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination centre">
    <a href="<?php echo url_for('film/nouveautes?page=1&le='.$lettre) ?>">
      <img src="/images/first.png" alt="First page" title="First page" />
    </a>
 
    <a href="<?php echo url_for('film/nouveautes?page='.$pager->getPreviousPage().'&le='.$lettre) ?>">
      <img src="/images/previous.png" alt="Previous page" title="Previous page" />
    </a>
 
    <?php foreach ($pager->getLinks() as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo '<span class="lettreSel">'.$page.'</span>'; ?>
      <?php else: ?>
         <a href="<?php echo url_for('film/nouveautes?page='.$page.'&le='.$lettre) ?>"><?php echo $page ?></a>
       <?php endif; ?>
    <?php endforeach; ?>
 
    <a href="<?php echo url_for('film/nouveautes?page='.$pager->getNextPage().'&le='.$lettre) ?>">
      <img src="/images/next.png" alt="Next page" title="Next page" />
    </a>

 
    <a href="<?php echo url_for('film/nouveautes?page='.$pager->getLastPage().'&le='.$lettre) ?>">
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
