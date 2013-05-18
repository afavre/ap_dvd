<?php

/**
 * saga actions.
 *
 * @package    dvdtheque
 * @subpackage saga
 * @author     Your name here
 */
class sagaActions extends sfActions
{


  public function preExecute()
  {
		UtilisateurPeer::preAll($this);
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->sagas = SagaPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->saga = SagaPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->saga);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SagaForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SagaForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($saga = SagaPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Saga does not exist (%s).', $request->getParameter('id')));
    $this->form = new SagaForm($saga);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($saga = SagaPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Saga does not exist (%s).', $request->getParameter('id')));
    $this->form = new SagaForm($saga);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($saga = SagaPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Saga does not exist (%s).', $request->getParameter('id')));
    $saga->delete();

    $this->redirect('saga/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $saga = $form->save();

      $this->redirect('saga/edit?id='.$saga->getId());
    }
  }
}
