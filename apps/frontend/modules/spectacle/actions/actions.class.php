<?php

/**
 * spectacle actions.
 *
 * @package    dvdtheque
 * @subpackage spectacle
 * @author     Your name here
 */
class spectacleActions extends sfActions
{

  public function preExecute()
  {
		UtilisateurPeer::preAll($this);
  }

  public function executeIndex(sfWebRequest $request)
  {
    $lettre=$request->getParameter('le');
	$this->lettre=$request->getParameter('le');
	
	$pro=$this->getUser()->getAttribute("proprio");
	
	$c = new Criteria();
	
	
	$sel='';
	if($pro){
		$sel='and spectacle.id IN (select spectacle_id from spectacleproprietaire where utilisateur_id='.$pro->getId().')';
	}
	if($lettre=='autre'){
		$subSelect = "spectacle.titre not REGEXP '^[a-z]' ".$sel." order by titre";
	}else{
		$subSelect = "spectacle.titre LIKE '".$lettre."%' ".$sel." order by titre";
	}
	
	
	$c->addOr(SpectaclePeer::ID, $subSelect, Criteria::CUSTOM);

	
	$this->pager = new sfPropelPager(
    'Spectacle',sfConfig::get('app_nb_affichage')
    );
	$this->pager->setCriteria($c);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->spectacle = SpectaclePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->spectacle);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SpectacleForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SpectacleForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Spectacle = SpectaclePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Spectacle does not exist (%s).', $request->getParameter('id')));
    $this->form = new SpectacleForm($Spectacle);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Spectacle = SpectaclePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Spectacle does not exist (%s).', $request->getParameter('id')));
    $this->form = new SpectacleForm($Spectacle);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Spectacle = SpectaclePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Spectacle does not exist (%s).', $request->getParameter('id')));
    $Spectacle->delete();

    $this->redirect('spectacle/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Spectacle = $form->save();

      $this->redirect('spectacle/edit?id='.$Spectacle->getId());
    }
  }
}
