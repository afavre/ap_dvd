<?php

/**
 * acteur actions.
 *
 * @package    sitedvd
 * @subpackage acteur
 * @author     Your name here
 */
class acteurActions extends sfActions
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
		$c->addJoin(FilmproprietairePeer::FILM_ID,ActeurfilmPeer::FILM_ID, Criteria::LEFT_JOIN);
		$c->addJoin(ActeurfilmPeer::ACTEUR_ID,PersonnePeer::ID, Criteria::LEFT_JOIN);
	}
    $c->add(PersonnePeer::NOM, $lettre.'%', Criteria::LIKE);
	$c->addAscendingOrderByColumn(PersonnePeer::NOM);
	$this->pager = new sfPropelPager(
    'Personne',sfConfig::get('app_nb_affichage')
    );

    $this->pager->setCriteria($c);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeActeursFilm(sfWebRequest $request)
  {
    $this->film = FilmPeer::retrieveByPk($request->getParameter('id'));
   $this->acteur_list = $this->film->getActeurs();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->acteur = PersonnePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->acteur);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PersonneForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new PersonneForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($acteur = PersonnePeer::retrieveByPk($request->getParameter('id')), sprintf('Object acteur does not exist (%s).', $request->getParameter('id')));
    $this->form = new PersonneForm($acteur);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($acteur = PersonnePeer::retrieveByPk($request->getParameter('id')), sprintf('Object acteur does not exist (%s).', $request->getParameter('id')));
    $this->form = new PersonneForm($acteur);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($acteur = PersonnePeer::retrieveByPk($request->getParameter('id')), sprintf('Object acteur does not exist (%s).', $request->getParameter('id')));
    $acteur->delete();

    $this->redirect('acteur/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $acteur = $form->save();

      $this->redirect('acteur/edit?id='.$acteur->getId());
    }
  }
}
