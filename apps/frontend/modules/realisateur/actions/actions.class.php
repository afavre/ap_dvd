<?php

/**
 * realisateur actions.
 *
 * @package    sitedvd
 * @subpackage realisateur
 * @author     Your name here
 */
class realisateurActions extends sfActions
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
	$pro=$this->getUser()->getAttribute("proprio");
	if($pro){
		$c->setDistinct();
		$c->addJoin(FilmproprietairePeer::FILM_ID,FilmPeer::ID, Criteria::LEFT_JOIN);
		$c->add(FilmproprietairePeer::UTILISATEUR_ID, $pro->getId());
		$c->addJoin(FilmPeer::REALISATEUR_ID,RealisateurPeer::ID, Criteria::LEFT_JOIN);
	}
    $c->add(RealisateurPeer::NOM, $lettre.'%', Criteria::LIKE);
	$c->addAscendingOrderByColumn(RealisateurPeer::NOM);	
	$this->pager = new sfPropelPager(
    'Realisateur',sfConfig::get('app_nb_affichage')
    );

    $this->pager->setCriteria($c);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

  }

  public function executeShow(sfWebRequest $request)
  {
    $this->realisateur = RealisateurPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->realisateur);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new RealisateurForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new RealisateurForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($realisateur = RealisateurPeer::retrieveByPk($request->getParameter('id')), sprintf('Object realisateur does not exist (%s).', $request->getParameter('id')));
    $this->form = new RealisateurForm($realisateur);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($realisateur = RealisateurPeer::retrieveByPk($request->getParameter('id')), sprintf('Object realisateur does not exist (%s).', $request->getParameter('id')));
    $this->form = new RealisateurForm($realisateur);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($realisateur = RealisateurPeer::retrieveByPk($request->getParameter('id')), sprintf('Object realisateur does not exist (%s).', $request->getParameter('id')));
    $realisateur->delete();

    $this->redirect('realisateur/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $realisateur = $form->save();

      $this->redirect('realisateur/edit?id='.$realisateur->getId());
    }
  }
}
