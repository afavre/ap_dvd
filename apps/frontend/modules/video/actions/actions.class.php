<?php

/**
 * video actions.
 *
 * @package    sitedvd
 * @subpackage video
 * @author     Your name here
 */
class videoActions extends sfActions
{

  public function preExecute()
  {
  
		UtilisateurPeer::preAll($this);
  }




  public function executeIndex(sfWebRequest $request)
  {
  /*
    $videos=VideoPeer::doSelect(new Criteria());
	foreach($videos as $video){
		echo $video->getTitre().'</br></br>';
		$video->updateLuceneIndex();
	}
  exit;
  */
  
	
  
	$type=$request->getParameter('t');
	$lettre=$request->getParameter('le');
	$this->lettre=$request->getParameter('le');
	
	$pro=$this->getUser()->getAttribute("proprio");
	
	$c = new Criteria();
	
	$sel='';
	if($type=='film'){
		if($pro){
			$sel='and video.id IN (select video_id from videoproprietaire where utilisateur_id='.$pro->getId().')';
		}
		if($lettre=='autre'){
			$subSelect = "((video.saga_id is NULL and video.titre not REGEXP '^[a-z]') or video.id IN (select id from video where saga_id is not NULL and video.titre not REGEXP '^[a-z]' group by saga_id)) ".$sel." and video.type='film' order by titre";
		}else if($lettre!=''){
			$subSelect = "((video.saga_id is NULL and video.titre LIKE '".$lettre."%') or video.id IN (select id from video where saga_id is not NULL ".$sel." and video.titre LIKE '".$lettre."%' group by saga_id)) ".$sel." and video.type='film' order by titre";
		}else{
			$subSelect = "((video.saga_id is NULL) or video.id IN (select id from video where saga_id is not NULL group by saga_id)) ".$sel." and video.type='film' order by titre";
		}
		$c->addOr(VideoPeer::ID, $subSelect, Criteria::CUSTOM);
	}else if($type=='spectacle'){
		if($pro){
			$c->addJoin(VideoproprietairePeer::VIDEO_ID,VideoPeer::ID, Criteria::LEFT_JOIN);
			$c->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
		}
		if($lettre=='autre'){
			$c->add(VideoPeer::TYPE, 'spectacle');
			$regex = VideoPeer::TITRE." NOT REGEXP '^[a-z]'";
			$c->add(VideoPeer::TITRE, $regex, Criteria::CUSTOM);
			$c->addAscendingOrderByColumn(VideoPeer::TITRE);
		}else if($lettre!=''){
			$c->add(VideoPeer::TYPE, 'spectacle');
			$c->addJoin(VideoPeer::REALISATEUR_ID, PersonnePeer::ID, Criteria::LEFT_JOIN);
			$c2=$c->getNewCriterion(VideoPeer::TITRE, $lettre.'%', Criteria::LIKE);
			$c3=$c->getNewCriterion(PersonnePeer::NOM, $lettre.'%', Criteria::LIKE);
			$c2->addOr($c3);
			$c->add($c2);
			$c->addAscendingOrderByColumn(VideoPeer::TITRE);
		}else{
			$c->add(VideoPeer::TYPE, 'spectacle');
			$c->addAscendingOrderByColumn(VideoPeer::TITRE);
		}
	}
	$videos = VideoPeer::doSelect($c);
	$page_act = 1;
	if($request->getParameter('page')){
		$page_act = $request->getParameter('page');
	}
	$this->pager = VideoPeer::getPager($videos, $page_act, sfConfig::get('app_nb_affichage'));
	/*
	$this->pager = new sfPropelPager(
    'Video',sfConfig::get('app_nb_affichage')
    );
	$this->pager->setCriteria($c);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
	*/




  }

  
  
  public function executeActeursFilm(sfWebRequest $request)
  {
    $this->film = VideoPeer::retrieveByPk($request->getParameter('id'));
   $this->acteur_list = $this->film->getActeurs();
  }
  
  
  /*
    public function executeMeilleurnote(sfWebRequest $request)
  {
		$lettre=$request->getParameter('le');
		$this->lettre=$request->getParameter('le');
		
		$pro=$this->getUser()->getAttribute("proprio");
		$crit = new Criteria();
        $crit = VideoPeer::getCritMeilleursNotes($pro,20);
        
		$this->pager = new sfPropelPager(
		'Video',sfConfig::get('app_nb_affichage')
		);
		$this->pager->setCriteria($crit);
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();
  }
  */

  public function executeShow(sfWebRequest $request)
  {
    $this->video = VideoPeer::retrieveByPk($request->getParameter('id'));
    $this->admins = SfGuardUserPeer::doSelect(new Criteria());
    $this->forward404Unless($this->video);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new VideoForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new VideoForm();

    $res = $this->processForm($request, $this->form);
	
	if($res){
		$rep=$res->getVersion()->getId().'/-/'.$res->getQualite()->getId().'/-/'.$res->getTitre();
	}else{
		$rep="false";
	}
    $saison = $res->getSaison();
	$tabEp = array();
	$listEp = $saison->getEpisodesOrdre();
	$i = $res->getNumero();
	$tabEp[$i] = new VideoForm($res);
		
	
    $this->episode = $res;
	$this->i = $i;
    $this->form2 = $tabEp;
    $this->versions = VersionPeer::getAllVersions();
    $this->qualites = QualitePeer::getAllQualites();
	
	//return $this->renderText($rep);
	
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($video = VideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object video n\'existe pas (%s).', $request->getParameter('id')));
    $this->form = new VideoForm($video);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($video = VideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object video n\'existe pas (%s).', $request->getParameter('id')));
    $this->form = new VideoForm($video);
	
    $res = $this->processForm($request, $this->form);
	
	if($res){
		$rep=$video->getVersion()->getId().'/-/'.$video->getQualite()->getId().'/-/'.$video->getTitre();
	}else{
		$rep="false";
	}
	
	return $this->renderText($rep);
    //$this->redirect('saison/show?id='.$video->getSaison()->getId());
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($video = VideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object video n\'existe pas (%s).', $request->getParameter('id')));
    $video->delete();

    $this->redirect('video/index');
  }
  
  public function executeAjoutProprio(sfWebRequest $request)
  {
  
	if($request->getParameter('id')){
		$video = VideoPeer::retrieveByPk($request->getParameter('id'));
		if(!$this->getUser()->getAttribute("login")->possede($video)){
			$videoPro= new Videoproprietaire();
			$videoPro->setVideo($video);
			$videoPro->setsfGuardUser($this->getUser()->getAttribute("login"));
			$videoPro->save();
			$video->addVideoproprietaire($videoPro);
		}
	}else if($request->getParameter('ids')){
		$saga = SagaPeer::retrieveByPk($request->getParameter('ids'));
		foreach($saga->getVideos() as $video){
			if(!$this->getUser()->getAttribute("login")->possede($video)){
				$videoPro= new Videoproprietaire();
				$videoPro->setVideo($video);
				$videoPro->setsfGuardUser($this->getUser()->getAttribute("login"));
				$videoPro->save();
				$video->addVideoproprietaire($videoPro);
			}
		}
	}
	

	return $this->renderText('');
	//$this->redirect($_SERVER['HTTP_REFERER']);
  }
  
  public function executeSupprProprio(sfWebRequest $request)
  {
	if($request->getParameter('id')){
		$video = VideoPeer::retrieveByPk($request->getParameter('id'));
		if($this->getUser()->getAttribute("login")->possede($video)){
			$criteria = new Criteria();
			$criteria->add(VideoproprietairePeer::VIDEO_ID, $video->getId());
			$criteria->add(VideoproprietairePeer::UTILISATEUR_ID, $this->getUser()->getAttribute("login")->getId());
			$videoPro = VideoproprietairePeer::doSelect($criteria, $con);
			$videoPro[0]->delete();
		}
	}else if($request->getParameter('ids')){
		$saga = SagaPeer::retrieveByPk($request->getParameter('ids'));
		foreach($saga->getVideos() as $video){
			if($this->getUser()->getAttribute("login")->possede($video)){
				$criteria = new Criteria();
				$criteria->add(VideoproprietairePeer::VIDEO_ID, $video->getId());
				$criteria->add(VideoproprietairePeer::UTILISATEUR_ID, $this->getUser()->getAttribute("login")->getId());
				$videoPro = VideoproprietairePeer::doSelect($criteria, $con);
				$videoPro[0]->delete();
			}
		}
	}
	$pro=$this->getUser()->getAttribute("proprio");
	$rep='';
	if($pro){
		$rep='pro';
	}
	return $this->renderText($rep);
	//$this->redirect($_SERVER['HTTP_REFERER']);
  }
  
  
    public function executeNoteVideoAdmin(sfWebRequest $request)
  {
  
	if($request->getParameter('id') && $request->getParameter('note')){
		$this->video = VideoPeer::retrieveByPk($request->getParameter('id'));
		$this->user = SfGuardUserPeer::retrieveByPk($this->getUser()->getAttribute("login"));
		$this->note=$request->getParameter('note');
		$this->setLayout(false);
	}
	
	
  }

	public function executeAjouterNoteVideoAdmin(sfWebRequest $request)
  {
  
	if($request->getParameter('id')){
		$video = VideoPeer::retrieveByPk($request->getParameter('id'));
		$c= new Criteria();
		$c->add(NotevideoadminPeer::VIDEO_ID, $request->getParameter('id'));
		$c->add(NotevideoadminPeer::UTILISATEUR_ID, $this->getUser()->getAttribute("login")->getId());
        $verif = NotevideoadminPeer::doSelect($c);
		if(sizeof($verif)==0){
			$note= new Notevideoadmin();
			$note->setVideo($video);
			$note->setsfGuardUser($this->getUser()->getAttribute("login"));
			$note->setNote($request->getParameter('note'));
			$note->setMessage($request->getParameter('comment'));
			$note->save();
		}else{
			foreach($verif as $note)
			$note->setNote($request->getParameter('note'));
			$note->setMessage($request->getParameter('comment'));
			$note->save();
		}
	}
	echo '<script>
			  parent.location = "show?id='.$request->getParameter('id').'";
			</script>';
	//$this->redirect('video/show?id='.$request->getParameter('id'));
	
  }
  
  
  public function executeFiltrerVideo(sfWebRequest $request)
  {
		if ($this->hasRequestParameter("id")){
			$idProprio = $this->getRequestParameter('id');
			if($this->getUser()->getAttribute('proprio')){
				if($this->getUser()->getAttribute('proprio')->getId()!=$idProprio){
					$this->getUser()->getAttributeHolder()->remove('proprio');
				}
			}else{
				foreach(sfGuardUserPeer::getProprio() as $proprio){
					if($idProprio!=$proprio->getId()){
						$this->getUser()->setAttribute('proprio', $proprio);
					}
				}
			}
		}
		
		$sauv=SauvegardeVisiteurPeer::getSauvegardeVisiteur($_SERVER['REMOTE_ADDR']);
		$pro=$this->getUser()->getAttribute("proprio");
		if($sauv){
			if($pro){
				$sauv->setProprioId($pro->getId());
			}else{
				$sauv->setProprioId(0);
			}
			$sauv->save();
		}else{
			$sauv= new SauvegardeVisiteur();
			$sauv->setAdresse($_SERVER['REMOTE_ADDR']);
			if($pro){
				$sauv->setProprioId($pro->getId());
			}else{
				$sauv->setProprioId(0);
			}
			$sauv->save();
		}
		
		$this->redirect($_SERVER['HTTP_REFERER']);
	
  }
  
  
  
	public function executeVerifUpload(sfWebRequest $request)
  {
  }
  

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $video = $form->save();
	  
		return $video;
		//$this->redirect('video/edit?id='.$video->getId().'&type=episode');
    }else{
		return false;
	}
  }

}
