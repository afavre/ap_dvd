<?php decorate_with(false); ?>

<!-- apps/frontend/templates/layout.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Dvdtheque - Notes</title>
	

    <link rel="shortcut icon" href="/images/icone.png" />


	
	<?php use_stylesheet('main-iframe.css') ?>
	
	
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
	
	
		
		


  </head>
  <body>

    <div >
		<div id="text">
		Vous souhaitez attribuer la note de <span class="note<?php echo $note; ?>" ><?php echo $note.'/10'; ?></span> au video "<b><?php echo $video->getTitre(); ?></b>"
		</div>
		<div id="textCom">
		Merci de commenter votre note:
		</div>
		<form method="POST" action="<?php echo url_for('video/AjouterNoteVideoAdmin') ?>" >
			<input type="hidden" name="note" value="<?php echo $note; ?>" />
			<input type="hidden" name="id" value="<?php echo $video->getId(); ?>" />
			<textarea name="comment" cols="33" rows="6"></textarea>
			<input class="right" type="submit" value="Enregistrer" />
		</form>
	</div>

  </body>
</html>
