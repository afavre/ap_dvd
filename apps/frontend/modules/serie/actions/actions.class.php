<?php

/**
 * serie actions.
 *
 * @package    sitedvd
 * @subpackage serie
 * @author     Your name here
 */
class serieActions extends sfActions
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
    $c->add(SeriePeer::TITRE, $lettre.'%', Criteria::LIKE);
	$c->addAscendingOrderByColumn(SeriePeer::TITRE);
	
	$series = SeriePeer::doSelect($c);
	$page_act = 1;
	if($request->getParameter('page')){
		$page_act = $request->getParameter('page');
	}
	$this->pager = VideoPeer::getPager($series, $page_act, sfConfig::get('app_nb_affichage'));
	/*
	$this->pager = new sfPropelPager(
    'Serie',sfConfig::get('app_nb_affichage')
    );

    $this->pager->setCriteria($c);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
	*/
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->serie = SeriePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->serie);
  }
  
  public function executeSaisonsSerie(sfWebRequest $request)
  {
    $this->serie = SeriePeer::retrieveByPk($request->getParameter('id'));
   $this->saisons_list = $this->serie->getSaisons();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SerieForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new SerieForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($serie = SeriePeer::retrieveByPk($request->getParameter('id')), sprintf('Object serie does not exist (%s).', $request->getParameter('id')));
    $this->form = new SerieForm($serie);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($serie = SeriePeer::retrieveByPk($request->getParameter('id')), sprintf('Object serie does not exist (%s).', $request->getParameter('id')));
    $this->form = new SerieForm($serie);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($serie = SeriePeer::retrieveByPk($request->getParameter('id')), sprintf('Object serie does not exist (%s).', $request->getParameter('id')));
    $serie->delete();

    $this->redirect('serie/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $serie = $form->save();

      $this->redirect('serie/edit?id='.$serie->getId());
    }
  }
}
