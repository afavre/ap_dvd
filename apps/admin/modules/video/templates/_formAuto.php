<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>


<form id="formRechercheAuto" action="<?php echo url_for('video/rechercheFilm'); ?>" onSubmit="rechercheFilmAuto(this, '<?php echo url_for('video/rechercheFilm'); ?>');return false;" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> width="100%">
	
	<input type="hidden" id="type" name="type" value="<?php echo $sf_request->getParameter('type'); ?>" />
	<div id="formAuto" >
		<table>
			<tbody>
				<?php echo $form->renderGlobalErrors() ?>
				<?php echo $form ?>
			</tbody>
		</table>
	</div>
	<div id="boutonAuto" >
		<input type="submit" value="Rechercher" />
	</div>
</form>