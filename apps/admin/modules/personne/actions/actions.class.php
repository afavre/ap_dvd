<?php

require_once dirname(__FILE__).'/../lib/personneGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/personneGeneratorHelper.class.php';

/**
 * personne actions.
 *
 * @package    dvdtheque
 * @subpackage personne
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class personneActions extends autoPersonneActions
{
protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'La personne a ete cree avec succes.' : 'La personne a ete modifie avec succes.';

      $personne = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $personne)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' Vous pouvez en ajouter une autre ci-dessous.',false);

        $this->redirect('@personne_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);
 
			echo '<script>
				if(parent!=window){
					parent.location.reload();
				}
			</script>';
			$this->redirect(array('sf_route' => 'personne_edit', 'sf_subject' => $personne));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'La personne n\'a pas ete enregistre en raison de certaines erreurs.', false);
  }
    }
}
