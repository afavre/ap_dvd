<?php

require_once dirname(__FILE__).'/../lib/acteurGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/acteurGeneratorHelper.class.php';

/**
 * acteur actions.
 *
 * @package    sitedvd
 * @subpackage acteur
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class acteurActions extends autoActeurActions
{
protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      $acteur = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $acteur)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.',false);

        $this->redirect('@acteur_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);
		echo '<script>
				if(parent!=window){
					parent.location.reload();
				}
			</script>';
        
        $this->redirect(array('sf_route' => 'acteur_edit', 'sf_subject' => $acteur));
		
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
  }
    }
//Permet de mettre a jour l'index des acteurs pour la recherche
  public function executeBatchMaj(sfWebRequest $request)
  {
    $acteurs = ActeurPeer::doSelect(new criteria());
    foreach ($acteurs as $acteur)
    {
		$acteur->updateLuceneIndex();
	}
    $this->getUser()->setFlash('notice', 'Les acteurs séléctionnés ont été ajoutés a Aurel');
	$this->redirect('acteur');
  }
}	