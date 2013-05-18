<?php

require_once dirname(__FILE__).'/../lib/videoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/videoGeneratorHelper.class.php';

/**
 * video actions.
 *
 * @package    dvdtheque
 * @subpackage video
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class videoActions extends autoVideoActions
{


  public function executeIndex(sfWebRequest $request){
    // sorting
    if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }
	if($request->getParameter('type')){
		$this->pager = $this->getPagerType($request->getParameter('type'));
	}else{
		$request->setParameter('type','film');
		$this->pager = $this->getPagerType('film');
	}
    $this->sort = $this->getSort();
    $this->type = $request->getParameter('type');
  }
  
  
  public function executeNewAuto(sfWebRequest $request)
  {
	$this->form = new FilmAutoForm();
  }
  
  public function executeRechercheFilm(sfWebRequest $request)
  {
	$tab_film = Array();
	if($request->getParameter('titre') && $request->getParameter('titre')!=''){
		$tab_film = VideoPeer::rechercheFilmAllocine($request->getParameter('titre'));
		//$this->form = new FilmAutoForm();
		$this->tab_film = $tab_film;
		$this->titre = $request->getParameter('titre');
		//$this->setTemplate('newAuto');
	}
	$this->setLayout(false);
	
  }
  
  public function executeCeationFilmAuto(sfWebRequest $request)
  {
	
	if($request->getParameter('c') && $request->getParameter('c')!=''){
		include_once sfConfig::get('sf_web_dir')."/api-allocine-helper-2.2.php";
		
		$code = $request->getParameter('c');
		$infos = VideoPeer::InfosFilmAllocine($code);
		
		if($request->getParameter('i') != ''){
			$pos_code_1 = strpos($request->getParameter('i'), "medias/nmedia/");
			$pos_code_2 = strlen($request->getParameter('i'));
			if ($pos_code_1 && $pos_code_2) {
				$fin_img = substr($request->getParameter('i'),$pos_code_1,$pos_code_2 - $pos_code_1);
				//$der_img = "http://images.allocine.fr/r_240_340/b_1_d6d6d6/medias/nmedia/".$fin_img;
				$der_img = "http://images.allocine.fr/".$fin_img;
			}else{
				$der_img = $request->getParameter('i');
			}
			$infos['all_images'][] = $der_img;
		}
	
		
		$infos['image'] = $infos['all_images'][0];
		
		$infos['bande_annonce'] = $infos['all_bandes_annonce'][0]['lien'];
		
		//array('email' => 'Votre email ici', 'name' => 'Votre nom ici');
		
		//print_r($infos);
		
		$this->video = new Video();
				
		
		//echo '//////////////////////////////////////////////////////////////////</br>';
		//echo '///////////////////// CATEGORIES ///////////////////////</br>';
		//echo '//////////////////////////////////////////////////////////////////</br>';
		foreach($infos['categorie'] as $cat){
			if($cat!=''){
				$c = new Criteria();
				$c->add(CategoriePeer::NOM, $cat);
				$test_categorie = CategoriePeer::doSelect($c);
				//echo '- test de "'.$cat.'" : </br>';
				if(!$test_categorie){
					//echo ' -> il n\'existe pas donc je le créé et je l\ajoute au film</br>';
					$categorie = new Categorie();
					$categorie->setNom($cat);
					$categorie->save();
					$catVid= new Categorievideo();
					$catVid->setVideo($this->video);
					$catVid->setCategorie($categorie);
				}else{
					//echo ' -> il existe deja donc je l\ajoute au film</br>';
					$categorie = $test_categorie[0];
					$catVid= new Categorievideo();
					$catVid->setVideo($this->video);
					$catVid->setCategorie($categorie);
				}
				$this->video->addCategorievideo($catVid);
			}
		}

		//echo '</br></br>';
		
		//echo '//////////////////////////////////////////////////////////////////</br>';
		//echo '///////////////////// MOTS CLE //////////////////////////</br>';
		//echo '//////////////////////////////////////////////////////////////////</br>';

		foreach($infos['mot_cle'] as $mc){
			if($mc!=''){
				$c = new Criteria();
				$c->add(MotsclePeer::MOT, $mc);
				$test_mots_cle = MotsclePeer::doSelect($c);
				//echo '- test de "'.$mc.'" : </br>';
				if(!$test_mots_cle){
					//echo ' -> il n\'existe pas donc je le créé et je l\ajoute au film</br>';
					$mot_cle = new Motscle();
					$mot_cle->setMot($mc);
					$mot_cle->save();
					$mcVid= new Motsclevideo();
					$mcVid->setVideo($this->video);
					$mcVid->setMotscle($mot_cle);
				}else{
					//echo ' -> il existe deja donc je l\ajoute au film</br>';
					$mot_cle = $test_mots_cle[0];
					$mcVid= new Motsclevideo();
					$mcVid->setVideo($this->video);
					$mcVid->setMotscle($mot_cle);
				}
				$this->video->addMotsclevideo($mcVid);
			}
		}
		

		//echo '</br></br>';
		
		//echo '//////////////////////////////////////////////////////////////////</br>';
		//echo '///////////////////// REALISATEUR ////////////////////////</br>';
		//echo '//////////////////////////////////////////////////////////////////</br>';
		
		
		$real = $infos['realisateur'];
		if($real['prenom'].$real['nom']!=''){
			$c = new Criteria();
			$c->add(PersonnePeer::NOM_PRENOM_CLEAN, VideoPeer::clean($real['prenom'].$real['nom']));
			$test_realisateur = PersonnePeer::doSelect($c);
			//echo '- test de "'.$real['prenom'].' '.$real['nom'].' '.VideoPeer::clean($real['prenom'].$real['nom']).'" : </br>';
			if(!$test_realisateur){
				//echo ' -> il n\'existe pas donc je le créé et je l\ajoute au film</br>';
				$realisateur = new Personne();
				$realisateur->setNom($real['nom']);
				$realisateur->setPrenom($real['prenom']);
				$realisateur->setDateNaissance($real['date_naissance']);
				if($real['pays']){
					$cNat = new Criteria();
					$cNat->add(NationalitePeer::PAYS, $real['pays']);
					$test_pays = NationalitePeer::doSelect($cNat);
					//echo '---- test de "'.$real['pays'].'" : </br>';
					if(!$test_pays){
						//echo ' ------> il n\'existe pas donc je le créé et je l\ajoute au film</br>';
						$nationalite = new Nationalite();
						$nationalite->setPays($real['pays']);
						$nationalite->save();
					}else{
						//echo ' ------> il existe deja donc je l\ajoute au film</br>';
						$nationalite = $nationalite;
					}
					$realisateur->setNationalite($nationalite);
				}
				$realisateur->uploadImageUrl($real['photo']);
				$realisateur->save();
			}else{
				//echo ' -> il existe deja donc je l\ajoute au film</br>';
				$realisateur = $test_realisateur[0];
			}
			$this->video->setPersonne($realisateur);
		}
		

		
		//echo '</br></br>';
		
		//echo '//////////////////////////////////////////////////////////////////</br>';
		//echo '/////////////////////// ACTEUR //////////////////////////</br>';
		//echo '//////////////////////////////////////////////////////////////////</br>';
		
		
		
		foreach($infos['acteur'] as $act){
			if($act['prenom'].$act['nom']!=''){
				$c = new Criteria();
				$c->add(PersonnePeer::NOM_PRENOM_CLEAN, VideoPeer::clean($act['prenom'].$act['nom']));
				$test_acteur = PersonnePeer::doSelect($c);
				//echo '- test de "'.$act['prenom'].' '.$act['nom'].' '.VideoPeer::clean($act['prenom'].$act['nom']).'" : </br>';
				if(!$test_acteur){
					//echo ' -> il n\'existe pas donc je le créé et je l\ajoute au film</br>';
					$acteur = new Personne();
					$acteur->setNom($act['nom']);
					$acteur->setPrenom($act['prenom']);
					$acteur->setDateNaissance($act['date_naissance']);
					if($act['pays']){
						$cNat = new Criteria();
						$cNat->add(NationalitePeer::PAYS, $act['pays']);
						$test_pays = NationalitePeer::doSelect($cNat);
						//echo '---- test de "'.$act['pays'].'" : </br>';
						if(!$test_pays){
							//echo ' ------> il n\'existe pas donc je le créé et je l\ajoute au film</br>';
							$nationalite = new Nationalite();
							$nationalite->setPays($act['pays']);
							$nationalite->save();
						}else{
							//echo ' ------> il existe deja donc je l\ajoute au film</br>';
							$nationalite = $nationalite;
						}
						$acteur->setNationalite($nationalite);
					}
					$acteur->uploadImageUrl($act['photo']);
					$acteur->save();
					$actVid= new Acteurvideo();
					$actVid->setVideo($this->video);
					$actVid->setPersonne($acteur);
					
				}else{
					//echo ' -> il existe deja donc je l\ajoute au film</br>';
					$acteur = $test_acteur[0];
					$actVid= new Acteurvideo();
					$actVid->setVideo($this->video);
					$actVid->setPersonne($acteur);
				}
			}
		}
		//echo '</br></br>';

		
		//echo ' ajout du film à l\'admin connecté</br>';
		$vPro= new VideoProprietaire();
		$vPro->setVideo($this->video);
		$vPro->setsfGuardUser($this->getUser()->getGuardUser());
		$this->video->addVideoproprietaire($vPro);
		
		if($infos['image']!=''){
			$this->video->uploadImageUrlTemp($infos['image']);
		}
		
		//echo $infos['resume'];
		

		$this->video->setTitre($infos['titre']);
		$this->video->setSousTitre($infos['ss_titre']);
		$this->video->setResume($infos['resume']);
		$this->video->setBandeAnnonce($infos['bande_annonce']);
		$this->video->setAnneeSortie($infos['annee']);
		$this->video->setDuree($infos['duree']);
		$this->video->setAvertissement($infos['avertissement']);
        $fini = false;
		
		//echo "getResume: ".$this->video->getResume();
		
        foreach(SagaPeer::getAllSaga() as $saga){
			$m = VideoPeer::cleanAccent($saga->getTitre());
			
			if(!$fini && strpos(VideoPeer::cleanAccent($this->video->getTitre()), VideoPeer::cleanAccent($saga->getTitre())) !== FALSE){
                $this->video->setSaga($saga);
                $fini = true;
            }
        }
		
		//$this->form = $this->configuration->getForm($this->video);
		$this->form = $this->configuration->getForm($this->video);
		
		$acteur = '';
		foreach($this->video->getActeurs() as $av){
			$acteur .= '/'.$av->getId();
		}
		$this->acteur_ordre = $acteur;
		$this->real_saison = '';
		$this->der_insert_saison = '';
		$this->liste_images = $infos['all_images'];
		$this->liste_bandes_annonce = $infos['all_bandes_annonce'];
		$this->type = $request->getParameter('type');
		$this->setTemplate('new');
	}else{
		$this->form = new FilmAutoForm();
		$this->setTemplate('newAuto');
	}

  }
  
  public function executeChangerImageAjax(sfWebRequest $request)
  {
	if($request->getParameter('img') && $request->getParameter('img')!=''){
		$url = $request->getParameter('img');
		$name = $request->getParameter('name_img');
		
		$video = new Video();
		if($video->uploadImageUrlTemp($url, $name)){
			$reponse = "/uploads/videos/temp/".$video->getImage();
		}else{
			$reponse = 'false';
		}
	}else{
		$reponse = 'false';
	}
    return $this->renderText($reponse);
  }
  
  public function executeNew(sfWebRequest $request)
  {
	$this->video = new Video();
	/*
    $this->form = $this->configuration->getForm();
    $this->video = $this->form->getObject();
	*/
	
	$vPro= new VideoProprietaire();
	$vPro->setVideo($this->video);
	$vPro->setsfGuardUser($this->getUser()->getGuardUser());
		
	$this->video->addVideoproprietaire($vPro);
	
    $this->form = $this->configuration->getForm($this->video);
	
	$c = new Criteria();
	$c->add(ActeurvideoPeer::VIDEO_ID, $this->video->getId());
	$c->addAscendingOrderByColumn(ActeurvideoPeer::ID);
	$a = ActeurvideoPeer::doSelect($c);
	$acteur = '';
	foreach($a as $av){
		$acteur .= '/'.$av->getActeurId();
	}
	$this->acteur_ordre = $acteur;
	
	$saison = '';
	$derE = '';
	if($request->getParameter('type')=='episode'){
		$s = SaisonPeer::doSelect(new Criteria());
		foreach($s as $sa){
			$saison .= '/'.$sa->getId().'-'.$sa->getRealisateurId().'-'.$sa->getVersion()->getId();
			if($sa->getNbEpisodeTot()){
				$nbEp=$sa->getNbEpisodeTot();
			}else{
				$nbEp=0;
			}
			$saison .= '-'.$nbEp;
			foreach($sa->getEpisodeSaison() as $e){
				if($this->video->getNumero()!=$e->getNumero() || $this->video->getSaison()->getId()!=$sa->getId() ){
					$saison .= '-'.$e->getNumero();
				}
			}
		}
		
		$c = new Criteria();
		$c->add(VideoPeer::TYPE, "episode");
		$c->addDescendingOrderByColumn(VideoPeer::CREATED_AT);
		$derV = VideoPeer::doSelectOne($c);
		$derE = $derV->getSaison()->getId();
	}
	$this->type = $request->getParameter('type');
	$this->real_saison = $saison;
	$this->der_insert_saison = $derE;
	$this->liste_images = Array();
	
	
  }
  
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->video = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->video);
	$c = new Criteria();
	$c->add(ActeurvideoPeer::VIDEO_ID, $this->video->getId());
	$c->addAscendingOrderByColumn(ActeurvideoPeer::ID);
	$a = ActeurvideoPeer::doSelect($c);
	$acteur = '';
	foreach($a as $av){
		$acteur .= '/'.$av->getActeurId();
	}
	$this->acteur_ordre = $acteur;
	
	$this->type = $this->video->getType();
	$saison = '';
	if($this->video->getType()=='episode'){
		$s = SaisonPeer::doSelect(new Criteria());
		foreach($s as $sa){
			$saison .= '/'.$sa->getId().'-'.$sa->getRealisateurId().'-'.$sa->getVersion()->getId();
			if($sa->getNbEpisodeTot()){
				$nbEp=$sa->getNbEpisodeTot();
			}else{
				$nbEp=0;
			}
			$saison .= '-'.$nbEp;
			foreach($sa->getEpisodeSaison() as $e){
				if($this->video->getNumero()!=$e->getNumero() || $this->video->getSaison()->getId()!=$sa->getId() ){
					$saison .= '-'.$e->getNumero();
				}
			}
		}
	}
	$this->real_saison = $saison;
	$this->liste_images = Array();
  }
  
  
  protected function getPagerType($type)
  {
  
    $pager = $this->configuration->getPager('Video');
	$c = new Criteria();
	$c=$this->buildCriteria();
	$c->add(VideoPeer::TYPE, $type);
	$pager->setCriteria($c);
    $pager->setPage($this->getPage());
    $pager->setPeerMethod($this->configuration->getPeerMethod());
    $pager->setPeerCountMethod($this->configuration->getPeerCountMethod());
    $pager->init();

    return $pager;
  }  
  
    protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
		$tab_variables = $request->getParameter('video');
		$vid_existe = VideoPeer::verifExiste($tab_variables['type'], VideoPeer::clean($tab_variables['titre'].$tab_variables['sous_titre']));
		if(!$form->getObject()->isNew() || ($form->getObject()->isNew() && !$vid_existe)){
			
			$notice = $form->getObject()->isNew() ? 'La video a ete cree avec succes.' : 'Le '.$request->getParameter('type').' a ete modifie avec succes.';
			//$form->getObject()->setType($request->getParameter('type'));
			if($request->getParameter('imgurl')!=''){
				$form->getObject()->setImage($request->getParameter('imgurl'));
				if($form->getObject()->getImage()){
					$filetmp = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'videos'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.$form->getObject()->getImage();

					//echo $filetmp.'tttttttttt';  
					$img = new sfImage($filetmp) ;
					$tab_file = explode("/",$img->getFilename());
					if($tab_file[sizeof($tab_file)-2]=='temp'){
						$file = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'videos'.DIRECTORY_SEPARATOR.$form->getObject()->getImage();
						$img->saveas($file);
						unlink($filetmp);
					}
				}
			}
			
			
		  $isNew = $form->getObject()->isNew();
		  $video = $form->save();
		  
		  /*
			if(apc_fetch('list_derniers_ajout')){
				$possede = false;
				$tab_der_video = apc_fetch('list_derniers_ajout');
				$admins = SfGuardUserPeer::doSelect(new Criteria());
				foreach($admins as $admin){
					if($admin->possede($video)){
						if(isset($tab_der_video[$admin->getId()])){
							if($request->getParameter('type')=="episode"){
							}else{
								array_unshift($tab_der_video[$admin->getId()], $video);
							}
						}
						$possede = true;
					}
				}
				if($possede){
				//echo 'yyyyyyy';
					if(isset($tab_der_video['total'])){
				//echo '2222222222222';
						array_unshift($tab_der_video['total'], $video);
					}
					apc_delete('list_derniers_ajout');
					apc_add('list_derniers_ajout', $tab_der_video);
				}
			}
			*/
	  
		  if($request->getParameter('type')=="episode"){
				  $video->getSaison()->setNbEpisodePossede(sizeof($video->getSaison()->getEpisodeSaison()));
				  $video->getSaison()->save();
		  }
			$exist = false;
			
			
			/////// Modifier tableau des dernier films //////////////
				$admins = SfGuardUserPeer::doSelect(new Criteria());
				foreach($admins as $admin){
					$crit=VideoPeer::getCritDerniersVideos($admin);
					$tab_video = VideoPeer::doSelect($crit);
					$tab_der_video[$admin->getId()] = $tab_video;
				}
				$crit=VideoPeer::getCritDerniersVideos();
				$tab_video = VideoPeer::doSelect($crit);
				$tab_der_video['total'] = $tab_video;
				
				apc_delete('list_derniers_ajout');
				apc_add('list_derniers_ajout', $tab_der_video);
			/////// Modifier tableau des dernier films //////////////
		}else{
			$exist = true;
			$notice = utf8_encode('Le '.$request->getParameter('type').' existe déjà ! Il a été ajouté à votre liste de '.$request->getParameter('type').'s');
			$vid_existe->addProprio($this->getUser()->getGuardUser());
			$vid_existe->save();
			$video = $vid_existe;
			/*
			if(apc_fetch('list_derniers_ajout')){
				$tab_der_video = apc_fetch('list_derniers_ajout');
				foreach($admins as $admin){
					if($admin->possede($video)){
						if(in_array($video, $tab_der_video[$admin->getId()])){
							unset($tab_der_video[array_search($video, $tab_der_video[$admin->getId()])]);
						}
						array_unshift($tab_der_video[$admin->getId()], $video);
					}
				}
				array_unshift($tab_der_video['total'], $video);
			}
			*/
			
			
			/////// Modifier tableau des dernier films //////////////
				$admins = SfGuardUserPeer::doSelect(new Criteria());
				foreach($admins as $admin){
					$crit=VideoPeer::getCritDerniersVideos($admin);
					$tab_video = VideoPeer::doSelect($crit);
					$tab_der_video[$admin->getId()] = $tab_video;
				}
				$crit=VideoPeer::getCritDerniersVideos();
				$tab_video = VideoPeer::doSelect($crit);
				$tab_der_video['total'] = $tab_video;
				
				apc_delete('list_derniers_ajout');
				apc_add('list_derniers_ajout', $tab_der_video);
			/////// Modifier tableau des dernier films //////////////
			
		}
	  //$video->setType($request->getParameter('type'));
	  //$video->save();
	  
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $video)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' Vous pouvez en ajouter un autre ci-dessous.');

        //$this->redirect('@video_new?type='.$request->getParameter('type'));
        $this->redirect('video/newAuto?type='.$request->getParameter('type'));
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);
		if($exist){
			$this->redirect('@video?type='.$request->getParameter('type'));
		}else{
			$this->redirect(array('sf_route' => 'video_edit', 'sf_subject' => $video, 'type'=>$request->getParameter('type')));
		}
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'Le '.$request->getParameter('type').' n\'a pas ete cree en raison de certaines erreurs.', false);
    }
  }
  
  
  
  
  public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@video?type='.$request->getParameter('type'));
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());

      $this->redirect('@video?type='.$request->getParameter('type'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    $this->setTemplate('index');
  }
  
  
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

	
    $this->getRoute()->getObject()->delete();
	
	
		/////// Modifier tableau des dernier films //////////////
			$admins = SfGuardUserPeer::doSelect(new Criteria());
			foreach($admins as $admin){
				$crit=VideoPeer::getCritDerniersVideos($admin);
				$tab_video = VideoPeer::doSelect($crit);
				$tab_der_video[$admin->getId()] = $tab_video;
			}
			$crit=VideoPeer::getCritDerniersVideos();
			$tab_video = VideoPeer::doSelect($crit);
			$tab_der_video['total'] = $tab_video;
			
			apc_delete('list_derniers_ajout');
			apc_add('list_derniers_ajout', $tab_der_video);
		/////// Modifier tableau des dernier films //////////////
	/*
	if(apc_fetch('list_derniers_ajout')){
		$tab_der_video = apc_fetch('list_derniers_ajout');
		$admins = SfGuardUserPeer::doSelect(new Criteria());
		foreach($admins as $admin){
			if($admin->possede($this->getRoute()->getObject())){
				if(isset($tab_der_video[$admin->getId()])){
					foreach($tab_der_video[$admin->getId()] as $key=>$v){
						if($v->getId()==$this->getRoute()->getObject()->getId() && $request->getParameter('type')!="episode"){
							unset($tab_der_video[$admin->getId()][$key]);
							break;
						}
						
						//else if($request->getParameter('type')=="episode" && $v->getSaison()->getId()==$this->getRoute()->getObject()->getSaison()->getId()){
							//$tab = $this->getRoute()->getObject()->getSaison()->getProprietaires();
							//if(){
								//unset($tab_der_video[$admin->getId()][$key]);
								//break;
							//}
						//}
						
					}
				}
			}
		}
		if(isset($tab_der_video['total'])){
			foreach($tab_der_video['total'] as $key=>$v){
				if($v->getId()==$this->getRoute()->getObject()->getId() && $request->getParameter('type')!="episode"){
					unset($tab_der_video['total'][$key]);
					break;
				}
			}
		}
		apc_delete('list_derniers_ajout');
		apc_add('list_derniers_ajout', $tab_der_video);
	}
	*/
	
	  if($request->getParameter('type')=="episode"){
			  $this->getRoute()->getObject()->getSaison()->setNbEpisodePossede(sizeof($this->getRoute()->getObject()->getSaison()->getEpisodeSaison()));
			  $this->getRoute()->getObject()->getSaison()->save();
	  }

    $this->getUser()->setFlash('notice', 'Le '.$request->getParameter('type').' a ete supprime avec succes.');

    $this->redirect('@video?type='.$request->getParameter('type'));
  }

  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'Vous devez au moins selectionner un '.$request->getParameter('type').'.');

      $this->redirect('@video?type='.$request->getParameter('type'));
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'Vous devez selectionner une action à executer sur les '.$request->getParameter('type').'s selectionnes.');

      $this->redirect('@video?type='.$request->getParameter('type'));
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('Vous devez créer un "%s" méthode pour l\'action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Video'));
    try
    {
      // validate ids
      $ids = $validator->clean($ids);

      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'Un probleme survient lors de la suppression des '.$request->getParameter('type').'s selectionnes -> certains '.$request->getParameter('type').'s n\'existent plus.');
    }

    $this->redirect('@video?type='.$request->getParameter('type'));
  }
  
  
  
  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = 0;
    foreach (VideoPeer::retrieveByPks($ids) as $object)
    {
      $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $object)));

      $object->delete();
      if ($object->isDeleted())
      {
		  if($request->getParameter('type')=="episode"){
				  $object->getSaison()->setNbEpisodePossede(sizeof($object->getSaison()->getEpisodeSaison()));
				  $object->getSaison()->save();
		  }
        $count++;
      }
    }

    if ($count >= count($ids))
    {
      $this->getUser()->setFlash('notice', 'Les '.$request->getParameter('type').'s selectionnes ont ete supprimes avec succes.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Un probleme survient lors de la suppression des '.$request->getParameter('type').'s selectionnes.');
    }
    $this->redirect('@video?type='.$request->getParameter('type'));
  }
  

  public function executeAjaxVerifExiste(sfWebRequest $request){

      $val=VideoPeer::clean($request->getParameter('value'));
		$c = new Criteria();
		if(strlen($val)<7){
			$c->add(VideoPeer::TITRE_CLEAN, $val);
		}else{
			$c->add(VideoPeer::TITRE_CLEAN, '%'.$val.'%', Criteria::LIKE);
		}
		$c->add(VideoPeer::TYPE, $request->getParameter('type'));
		$videos = VideoPeer::doSelect($c);
        $bool='false';
		$infos='';
		foreach($videos as $video){
                $bool='true';
                $infos.='/'.$video->getTitre().'/'.$video->getId();
        }

        return $this->renderText($bool.$infos);

  }
  
  public function executeAjaxRealSaison(sfWebRequest $request){
        $rep='false';
		if($request->getParameter('id')){
			$saison = SaisonPeer::retrieveByPk($request->getParameter('id'));
			if($saison->getRealisateur()->getId()!=0){
				$rep=$saison->getRealisateur()->getId();
			}
		}

        return $this->renderText($rep);

  }
  
  public function executeBatchAjouter_a_aurel(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
 
    $videos = VideoPeer::retrieveByPks($ids);

    foreach ($videos as $video)
    {
		$admin = sfGuardUserPeer::retrieveByPk(1);
		if(!$admin->possede($video)){
			//$video->addProprietairePierre();
			$videoPro= new Videoproprietaire();
			$videoPro->setVideo($video);
			$videoPro->setsfGuardUser($admin);
			$videoPro->save();
			$video->addVideoproprietaire($videoPro);
		}
    }
 
    $this->getUser()->setFlash('notice', 'Les '.$request->getParameter('type').'s selectionnes ont ete ajoutes a Aurel');
	$this->redirect('video');
	
  }
  
    
  public function executeBatchAjouter_a_pierre(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
 
    $videos = VideoPeer::retrieveByPks($ids);

    foreach ($videos as $video)
    {
		$admin = sfGuardUserPeer::retrieveByPk(2);
		if(!$admin->possede($video)){
			//$video->addProprietairePierre();
			$videoPro= new Videoproprietaire();
			$videoPro->setVideo($video);
			$videoPro->setsfGuardUser($admin);
			$videoPro->save();
			$video->addVideoproprietaire($videoPro);
		}
    }
 
    $this->getUser()->setFlash('notice', 'Les '.$request->getParameter('type').'s selectionnes ont ete ajoutes a Pierre');
	$this->redirect('video');
	
  }
  
  //Permet de mettre a jour l'index des acteurs pour la recherche
  public function executeBatchMaj(sfWebRequest $request)
  {
    $videos = VideoPeer::doSelect(new criteria());
    foreach ($videos as $video)
    {
		$video->updateLuceneIndex();
	}
    $this->getUser()->setFlash('notice', 'L index des '.$request->getParameter('type').'s a ete mis a jour');
	$this->redirect('video');
  }

}
