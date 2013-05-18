<?php

require_once dirname(__FILE__).'/../lib/motscleGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/motscleGeneratorHelper.class.php';

/**
 * motscle actions.
 *
 * @package    dvdtheque
 * @subpackage motscle
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class motscleActions extends autoMotscleActions
{
protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      $motscle = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $motscle)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.',false);

        $this->redirect('@motscle_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);
			echo '<script>
				if(parent!=window){
					parent.location.reload();
				}
			</script>';
        
			$this->redirect(array('sf_route' => 'motscle_edit', 'sf_subject' => $motscle));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
  }
    }
}
