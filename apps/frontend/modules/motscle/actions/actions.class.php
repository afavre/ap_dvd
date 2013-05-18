<?php

/**
 * motscle actions.
 *
 * @package    dvdtheque
 * @subpackage motscle
 * @author     Your name here
 */
class motscleActions extends sfActions
{

   public function preExecute()
  {
  
		UtilisateurPeer::preAll($this);
		
  }
  
  public function executeIndex(sfWebRequest $request)
  {

	$lettre=$request->getParameter('le');
	$this->lettre=$request->getParameter('le');

    $c= new Criteria();
    $c->add(MotsclePeer::MOT, $lettre.'%', Criteria::LIKE);
	$c->addAscendingOrderByColumn(MotsclePeer::MOT);
	$this->pager = new sfPropelPager(
    'Motscle',sfConfig::get('app_nb_affichage')
    );
	$this->pager->setCriteria($c);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->motscle = MotsclePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->motscle);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new motscleForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new motscleForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($motscle = MotsclePeer::retrieveByPk($request->getParameter('id')), sprintf('Object motscle does not exist (%s).', $request->getParameter('id')));
    $this->form = new motscleForm($motscle);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($motscle = MotsclePeer::retrieveByPk($request->getParameter('id')), sprintf('Object motscle does not exist (%s).', $request->getParameter('id')));
    $this->form = new motscleForm($motscle);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($motscle = MotsclePeer::retrieveByPk($request->getParameter('id')), sprintf('Object motscle does not exist (%s).', $request->getParameter('id')));
    $motscle->delete();

    $this->redirect('motscle/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $motscle = $form->save();

      $this->redirect('motscle/edit?id='.$motscle->getId());
    }
  }
}
