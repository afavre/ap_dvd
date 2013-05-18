<?php decorate_with(false); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Dvdtheque - inscription</title>
	

    <link rel="shortcut icon" href="/images/icone.png" />


	
	<?php use_stylesheet('main-iframe.css') ?>
	
	
    <?php include_javascripts() ?>
    <?php include_stylesheets() ?>
	
	

  </head>
  <body>
	  <div id="inscr">
		<h2>Inscription</h2>

		<?php include_partial('form', array('form' => $form)) ?> 
	  </div>
  </body>
</html>
