<?php

/**
 * saison actions.
 *
 * @package    dvdtheque
 * @subpackage saison
 * @author     Your name here
 */
class saisonActions extends sfActions
{
  public function preExecute()
  {
  
		UtilisateurPeer::preAll($this);
  }
  public function executeIndex(sfWebRequest $request)
  {
    $this->Saisons = SaisonPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->saison = SaisonPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->saison);
	$tabEp = array();
	$listEp = $this->saison->getEpisodesOrdre();
	for($i=1;$i<=$this->saison->getMaxEpisodesTot();$i++){
		if($listEp[$i]){
			$tabEp[$i] = new VideoForm($listEp[$i]);
		}else{
			$_REQUEST['type']='episode';
			$_REQUEST['frontend']='1';
			$v = new Video();
			$v->setNumero($i);
			$v->setSaison($this->saison);
			$v->setRealisateurId($this->saison->getRealisateur()->getId());
			$v->setVersionId($this->saison->getVersionGeneraleId());
			
			$obj = new Videoproprietaire();
			$obj->setVideo($v);
			$obj->setUtilisateurId(2);
			$v->addVideoproprietaire($obj);
			
			$tabEp[$i] = new VideoForm($v);
		}
	}
	
	
    $this->form = $tabEp;
    $this->versions = VersionPeer::getAllVersions();
    $this->qualites = QualitePeer::getAllQualites();
  }
  
  
  public function executeActeursSaison(sfWebRequest $request)
  {
    $this->saison = SaisonPeer::retrieveByPk($request->getParameter('id'));
   $this->acteur_list = $this->saison->getActeurs();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SaisonForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SaisonForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Saison = SaisonPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Saison does not exist (%s).', $request->getParameter('id')));
    $this->form = new SaisonForm($Saison);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Saison = SaisonPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Saison does not exist (%s).', $request->getParameter('id')));
    $this->form = new SaisonForm($Saison);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Saison = SaisonPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Saison does not exist (%s).', $request->getParameter('id')));
    $Saison->delete();

    $this->redirect('saison/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Saison = $form->save();

      $this->redirect('saison/edit?id='.$Saison->getId());
    }
  }
  
  
  public function executeEpisodesAjax(sfWebRequest $request)
  {
    $this->saison = SaisonPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->saison);
	$tabEp = array();
	$listEp = $this->saison->getEpisodesOrdre();
	for($i=1;$i<=$this->saison->getMaxEpisodesTot();$i++){
		if($listEp[$i]){
			$tabEp[$i] = new VideoForm($listEp[$i]);
		}else{
			$_REQUEST['type']='episode';
			$_REQUEST['frontend']='1';
			$v = new Video();
			$v->setNumero($i);
			$v->setSaison($this->saison);
			$v->setRealisateurId($this->saison->getRealisateur()->getId());
			$v->setVersionId($this->saison->getVersionGeneraleId());
			
			$obj = new Videoproprietaire();
			$obj->setVideo($v);
			$obj->setUtilisateurId(2);
			$v->addVideoproprietaire($obj);
			
			$tabEp[$i] = new VideoForm($v);
		}
	}
    $this->form = $tabEp;
  }
}
