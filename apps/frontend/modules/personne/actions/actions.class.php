<?php

/**
 * personne actions.
 *
 * @package    dvdtheque
 * @subpackage personne
 * @author     Your name here
 */
class personneActions extends sfActions
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
		$c->setDistinct();
		if($pro){
			$c->addJoin(VideoproprietairePeer::VIDEO_ID,VideoPeer::ID, Criteria::LEFT_JOIN);
			$c->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
			if($request->getParameter('p')=="acteur"){
				$c->addJoin(VideoproprietairePeer::VIDEO_ID,ActeurvideoPeer::VIDEO_ID, Criteria::LEFT_JOIN);
				$c->addJoin(ActeurvideoPeer::ACTEUR_ID,PersonnePeer::ID, Criteria::LEFT_JOIN);
				$this->type='acteur';
			}else if($request->getParameter('p')=="realisateur"){
				$c->addJoin(VideoPeer::REALISATEUR_ID,PersonnePeer::ID, Criteria::LEFT_JOIN);
				$this->type='realisateur';
			}else{
				$c->addJoin(VideoproprietairePeer::VIDEO_ID,ActeurvideoPeer::VIDEO_ID, Criteria::LEFT_JOIN);
				$c->addJoin(ActeurvideoPeer::ACTEUR_ID,PersonnePeer::ID, Criteria::LEFT_JOIN);
				$this->type='';
			}
		}else{
			if($request->getParameter('p')=="acteur"){
				$c->addJoin(PersonnePeer::ID, ActeurvideoPeer::ACTEUR_ID, Criteria::RIGHT_JOIN);
				$this->type='acteur';
			}else if($request->getParameter('p')=="realisateur"){
				$c->addJoin(PersonnePeer::ID, VideoPeer::REALISATEUR_ID, Criteria::RIGHT_JOIN);
				$this->type='realisateur';
			}else{
				$this->type='';
			}
		}
		if($lettre=='autre'){
			$regex = PersonnePeer::NOM." NOT REGEXP '^[a-z]'";
			$c->add(PersonnePeer::NOM, $regex, Criteria::CUSTOM);
		}else{
			$c->add(PersonnePeer::NOM, $lettre.'%', Criteria::LIKE);
		}
		$c->addAscendingOrderByColumn(PersonnePeer::NOM);
		
		$personnes = PersonnePeer::doSelect($c);
		$page_act = 1;
		if($request->getParameter('page')){
			$page_act = $request->getParameter('page');
		}
		$this->pager = VideoPeer::getPager($personnes, $page_act, sfConfig::get('app_nb_affichage'));
		/*
		$this->pager = new sfPropelPager(
			'Personne',sfConfig::get('app_nb_affichage')
		);

		$this->pager->setCriteria($c);
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();
		*/
	
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->personne = PersonnePeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->personne);
  }
  
  
  
  public function executeVideos(sfWebRequest $request)
  {
	$pro=$this->getUser()->getAttribute("proprio");
    $this->personne = PersonnePeer::retrieveByPk($request->getParameter('id'));
    $this->v = $request->getParameter('v');
	if($request->getParameter('v')=='realisateur'){
        $this->video_list=$this->personne->getFilmsRealisateur($pro);
	}else if($request->getParameter('v')=='acteur'){	
        $this->video_list=$this->personne->getFilmsActeur($pro);
	}else if($request->getParameter('v')=='realisateur_serie'){
        $this->video_list=$this->personne->getSaisonsRealisateur($pro);
	}else if($request->getParameter('v')=='acteur_serie'){
        $this->video_list=$this->personne->getSaisonsActeur($pro);
	}else if($request->getParameter('v')=='auteur'){	
        $this->video_list=$this->personne->getSpectaclesAuteur($pro);
	}
  }
  

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PersonneForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PersonneForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Personne = PersonnePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Personne does not exist (%s).', $request->getParameter('id')));
    $this->form = new PersonneForm($Personne);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Personne = PersonnePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Personne does not exist (%s).', $request->getParameter('id')));
    $this->form = new PersonneForm($Personne);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Personne = PersonnePeer::retrieveByPk($request->getParameter('id')), sprintf('Object Personne does not exist (%s).', $request->getParameter('id')));
    $Personne->delete();

    $this->redirect('personne/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Personne = $form->save();

      $this->redirect('personne/edit?id='.$Personne->getId());
    }
  }
}
