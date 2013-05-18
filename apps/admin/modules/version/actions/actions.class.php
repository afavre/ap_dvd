<?php

require_once dirname(__FILE__).'/../lib/versionGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/versionGeneratorHelper.class.php';

/**
 * version actions.
 *
 * @package    sitedvd
 * @subpackage version
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class versionActions extends autoVersionActions
{
protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      $version = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $version)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.',false);

        $this->redirect('@version_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

			echo '<script>
				if(parent!=window){
					parent.location.reload();
				}
			</script>';
			$this->redirect(array('sf_route' => 'version_edit', 'sf_subject' => $version));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
  }
    }
}
