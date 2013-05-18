<?php

/**
 * categorie actions.
 *
 * @package    dvdtheque
 * @subpackage categorie
 * @author     Your name here
 */
class categorieActions extends sfActions
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
		$c->addJoin(VideoproprietairePeer::VIDEO_ID,VideoPeer::ID, Criteria::LEFT_JOIN);
		$c->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
		$c->addJoin(VideoproprietairePeer::VIDEO_ID,CategorievideoPeer::VIDEO_ID, Criteria::LEFT_JOIN);
		$c->addJoin(CategorievideoPeer::CATEGORIE_ID,CategoriePeer::ID, Criteria::LEFT_JOIN);
	}
    $c->add(CategoriePeer::NOM, $lettre.'%', Criteria::LIKE);
	$c->addAscendingOrderByColumn(CategoriePeer::NOM);
	
	$categories = CategoriePeer::doSelect($c);
	$page_act = 1;
	if($request->getParameter('page')){
		$page_act = $request->getParameter('page');
	}
	$this->pager = VideoPeer::getPager($categories, $page_act, sfConfig::get('app_nb_affichage'));
	/*
	$this->pager = new sfPropelPager(
    'Categorie',sfConfig::get('app_nb_affichage')
    );
	$this->pager->setCriteria($c);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
	*/
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->categorie = CategoriePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->categorie);
	
	$pro=$this->getUser()->getAttribute("proprio");
	
	$videos = $this->categorie->getVideos($pro);
	$page_act = 1;
	if($request->getParameter('page')){
		$page_act = $request->getParameter('page');
	}
	$this->pager = VideoPeer::getPager($videos, $page_act, sfConfig::get('app_nb_affichage'));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new categorieForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new categorieForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($categorie = CategoriePeer::retrieveByPk($request->getParameter('id')), sprintf('Object categorie does not exist (%s).', $request->getParameter('id')));
    $this->form = new categorieForm($categorie);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($categorie = CategoriePeer::retrieveByPk($request->getParameter('id')), sprintf('Object categorie does not exist (%s).', $request->getParameter('id')));
    $this->form = new categorieForm($categorie);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($categorie = CategoriePeer::retrieveByPk($request->getParameter('id')), sprintf('Object categorie does not exist (%s).', $request->getParameter('id')));
    $categorie->delete();

    $this->redirect('categorie/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $categorie = $form->save();

      $this->redirect('categorie/edit?id='.$categorie->getId());
    }
  }
}
