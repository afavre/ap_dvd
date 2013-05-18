<?php

/**
 * film actions.
 *
 * @package    sitedvd
 * @subpackage film
 * @author     Your name here
 */
class filmActions extends sfActions
{

  public function preExecute()
  {
  
		UtilisateurPeer::preAll($this);
  }

  public function executeSearch(sfWebRequest $request)
  {
		$save='';
		if($this->getUser()->getAttribute('query')){
			$save=$this->getUser()->getAttribute('query');
		}
		$query = FilmPeer::clean($request->getParameter('query', $save, 'index'));
		$this->quer = $request->getParameter('query', $save, 'index');
		//$request->setParameter('query',);
		
		$this->getUser()->setAttribute('query', $this->quer);
		
		if(strlen($query)>1){
		//if(strlen($query)>=3){
			//$query = FilmPeer::clean($request->getParameter('query', 'film', 'index')).'*';
			$query = '%'.$query.'%';
			
			
			$pro=$this->getUser()->getAttribute("proprio");
			
			$this->forwardUnless($query, 'film', 'index');
			////////////////////////////////////////////////////////////////
			////////////////////////		FILMS		////////////////////
			////////////////////////////////////////////////////////////////
			
			/////////////// rechercher les films sur leur titre ////////////
			$critFtitre = new Criteria();
			
			$critFtitre->add(FilmPeer::TITRE_CLEAN, $query, Criteria::LIKE);
			if($pro){
				$critFtitre->addJoin(FilmPeer::ID, FilmproprietairePeer::FILM_ID, Criteria::LEFT_JOIN);
				$critFtitre->add(FilmproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			
			$filmsTitre = FilmPeer::doSelect($critFtitre);
			//$this->films = FilmPeer::getForLuceneQuery($query);
			
			foreach($filmsTitre as $filmT){
				$tabFilms[$filmT->getId()]++;
				$tab[$tabFilms[$filmT->getId()]][]=$filmT;
			}
			
			
			/////////////// rechercher les films sur leurs mots-cle ////////////
			
			$critFmotscle = new Criteria();
			
			$critFmotscle->setDistinct();
			$critFmotscle->add(MotsclePeer::MOT_CLEAN, $query, Criteria::LIKE);
			$critFmotscle->addJoin(MotsclePeer::ID, MotsclefilmPeer::MOTSCLE_ID, Criteria::LEFT_JOIN);
			$critFmotscle->addJoin(MotsclefilmPeer::FILM_ID, FilmPeer::ID, Criteria::LEFT_JOIN);
			if($pro){
				$critFmotscle->addJoin(FilmPeer::ID, FilmproprietairePeer::FILM_ID, Criteria::LEFT_JOIN);
				$critFmotscle->add(FilmproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			$filmsmotscle = FilmPeer::doSelect($critFmotscle);
			
			foreach($filmsmotscle as $filmMC){
				$tabFilms[$filmMC->getId()]++;
				$tab[$tabFilms[$filmMC->getId()]][]=$filmMC;
				if($tabFilms[$filmMC->getId()]>1){
					unset($tab[$tabFilms[$filmMC->getId()]-1][array_search($filmMC, $tab[$tabFilms[$filmMC->getId()]-1])]);
				}
			}
			
			
			/////////////// rechercher les films sur leurs categories ////////////
			
			$critFcategorie = new Criteria();
			
			$critFcategorie->setDistinct();
			$critFcategorie->add(CategoriePeer::NOM_CLEAN, $query, Criteria::LIKE);
			$critFcategorie->addJoin(CategoriePeer::ID, CategoriefilmPeer::CATEGORIE_ID, Criteria::LEFT_JOIN);
			$critFcategorie->addJoin(CategoriefilmPeer::FILM_ID, FilmPeer::ID, Criteria::LEFT_JOIN);
			if($pro){
				$critFcategorie->addJoin(FilmPeer::ID, FilmproprietairePeer::FILM_ID, Criteria::LEFT_JOIN);
				$critFcategorie->add(FilmproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			$filmscategorie = FilmPeer::doSelect($critFcategorie);
			
			foreach($filmscategorie as $filmC){
				$tabFilms[$filmC->getId()]++;
				$tab[$tabFilms[$filmC->getId()]][]=$filmC;
				if($tabFilms[$filmC->getId()]>1){
					unset($tab[$tabFilms[$filmC->getId()]-1][array_search($filmC, $tab[$tabFilms[$filmC->getId()]-1])]);
				}
			}
			
			
			/////////////// rechercher les films sur leurs acteurs ////////////
			
			$critFacteur = new Criteria();
			
			$critFacteur->setDistinct();
			$critFacteur->add(PersonnePeer::NOM_PRENOM_CLEAN, $query, Criteria::LIKE);
			$critFacteur->addJoin(PersonnePeer::ID, ActeurfilmPeer::ACTEUR_ID, Criteria::LEFT_JOIN);
			$critFacteur->addJoin(ActeurfilmPeer::FILM_ID, FilmPeer::ID, Criteria::LEFT_JOIN);
			if($pro){
				$critFacteur->addJoin(FilmPeer::ID, FilmproprietairePeer::FILM_ID, Criteria::LEFT_JOIN);
				$critFacteur->add(FilmproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			$filmsacteur = FilmPeer::doSelect($critFacteur);
			
			foreach($filmsacteur as $filmA){
				$tabFilms[$filmA->getId()]++;
				$tab[$tabFilms[$filmA->getId()]][]=$filmA;
				if($tabFilms[$filmA->getId()]>1){
					unset($tab[$tabFilms[$filmA->getId()]-1][array_search($filmA, $tab[$tabFilms[$filmA->getId()]-1])]);
				}
			}
			
			
			/////////////// rechercher les films sur leurs réalisateurs ////////////
			
			$critFrealisateur = new Criteria();
			
			$critFrealisateur->setDistinct();
			$critFrealisateur->add(PersonnePeer::NOM_PRENOM_CLEAN, $query, Criteria::LIKE);
			$critFrealisateur->addJoin(PersonnePeer::ID, FilmPeer::REALISATEUR_ID, Criteria::LEFT_JOIN);
			if($pro){
				$critFrealisateur->addJoin(FilmPeer::ID, FilmproprietairePeer::FILM_ID, Criteria::LEFT_JOIN);
				$critFrealisateur->add(FilmproprietairePeer::UTILISATEUR_ID, $pro->getId());
				
				
			}
			$filmsrealisateur = FilmPeer::doSelect($critFrealisateur);
			
			foreach($filmsrealisateur as $filmR){
				$tabFilms[$filmR->getId()]++;
				$tab[$tabFilms[$filmR->getId()]][]=$filmR;
				if($tabFilms[$filmR->getId()]>1){
					unset($tab[$tabFilms[$filmR->getId()]-1][array_search($filmR, $tab[$tabFilms[$filmR->getId()]-1])]);
				}
			}
			
			//////////////// tous remettre dans l'ordre ////////////////////
			$tab=array_reverse($tab);
			foreach($tab as $nb => $films){
				foreach($films as $film){
					if($film->getId()){
						$tabFilmFinal[]=$film;
					}
				}
			}
			$this->films=$tabFilmFinal;
			
			
			
			////////////////////////////////////////////////////////////////
			////////////////////////		SERIES		////////////////////
			////////////////////////////////////////////////////////////////

			$this->series = SeriePeer::doSelect(new Criteria());	
			$this->series = SeriePeer::getForLuceneQuery($query);
			
			
			////////////////////////////////////////////////////////////////
			////////////////////////		ACTEURS		////////////////////
			////////////////////////////////////////////////////////////////

			/*
			$this->acteurs = ActeurPeer::doSelect(new Criteria());
			$this->acteurs = ActeurPeer::getForLuceneQuery($query);
			*/
			$critA = new Criteria();
			$critA->setDistinct();
			$critA->add(PersonnePeer::NOM_PRENOM_CLEAN, $query, Criteria::LIKE);
			if($pro){
				$critA->addJoin(PersonnePeer::ID, ActeurfilmPeer::ACTEUR_ID, Criteria::LEFT_JOIN);
				$critA->addJoin(ActeurfilmPeer::FILM_ID, FilmproprietairePeer::FILM_ID, Criteria::LEFT_JOIN);
				$critA->add(FilmproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			$acteurs = PersonnePeer::doSelect($critA);
			
			
			foreach($acteurs as $A){
				$tabPers[$A->getId()]++;
				$tabP[$tabPers[$A->getId()]][]=$A;
			}
			
			////////////////////////////////////////////////////////////////
			////////////////////		REALISATEURS		////////////////
			////////////////////////////////////////////////////////////////
			
			/*
			$this->realisateurs = RealisateurPeer::doSelect(new Criteria());
			$this->realisateurs = RealisateurPeer::getForLuceneQuery($query);
			*/
			
			$critR = new Criteria();
			$critR->setDistinct();
			$critR->add(PersonnePeer::NOM_PRENOM_CLEAN, $query, Criteria::LIKE);
			if($pro){
				$critR->addJoin(PersonnePeer::ID, FilmPeer::REALISATEUR_ID, Criteria::LEFT_JOIN);
				$critR->addJoin(FilmPeer::ID, FilmproprietairePeer::FILM_ID, Criteria::LEFT_JOIN);
				$critR->add(FilmproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			$realisateur = PersonnePeer::doSelect($critR);
			
			
			foreach($realisateur as $R){
				$tabPers[$R->getId()]++;
				$tabP[$tabPers[$R->getId()]][]=$R;
				if($tabPers[$R->getId()]>1){
					unset($tabP[$tabPers[$R->getId()]-1][array_search($R, $tabP[$tabPers[$R->getId()]-1])]);
				}
			}
			
			foreach($tabP as $nb => $pers){
				foreach($pers as $p){
					$tabPersFinal[]=$p;
				}
			}
			$this->personnes=$tabPersFinal;
			
			

		//}
		}
		/*
        if ($request->isXmlHttpRequest()){
            $this->renderText('<h2>Resultat pour les Films</h2>');
            if ($query=='' || !$this->films){
                $this->renderText('<div class="rouge centre"><i>Aucun Film n\'a été trouvé</i></div>');
            }else{
                $this->renderPartial('film/listFilm', array('films' => $this->films));
            }

        }
		*/

  }

  

  public function executeAjaxDerFilm(sfWebRequest $request)
  {
        $crit=new Criteria();
        $crit->addDescendingOrderByColumn(FilmPeer::CREATED_AT);
        $crit->setLimit(6);
        $der = FilmPeer::doSelect($crit);
        $derfilms = FilmPeer::doSelect($crit);
		$tab=$request->getParameter('tab');
		$tabs=explode("/", $tab);
		if(sizeof($tabs)>=sizeof($derfilms)){
			$fin=1;
		}else{
			foreach($tabs as $i){
				unset($derfilms[$i]);
			}
		}
		$indice = array_rand($derfilms);
        return $this->renderText($derfilms[$indice]->getImage().','.$indice.','.$derfilms[$indice]->getId().','.$fin.','.$derfilms[$indice]->getTitre());

  }



  public function executeIndex(sfWebRequest $request)
  {
  
  /*
    $reals=RealisateurPeer::doSelect(new Criteria());
	$mess='';
	foreach($reals as $real){
		$acteurs=ActeurPeer::doSelect(new Criteria());
		$exist=false;
		$a=null;
		foreach($acteurs as $acteur){
			if($real->getNomPrenomClean()==$acteur->getNomPrenomClean()){
				$exist=true;
				$a=$acteur;
			}
		}
		if(!$exist){
			$act = new Acteur();
			$act->setNom($real->getNom());
			$act->setPrenom($real->getPrenom());
			$act->setNomPrenomClean($real->getNomPrenomClean());
			$act->setImage($real->getImage());
			$act->setDateNaissance($real->getDateNaissance());
			$act->setDateDeces($real->getDateDeces());
			$act->setNationalite($real->getNationalite());
			echo 'INSERT: '.$act->getNom().' '.$act->getPrenom().'</br>';
			$act->save();
			$mess .= 'update film set realisateur_id='.$act->getId().' where realisateur_id='.$real->getId().'</br>';
		}else{
			echo 'NO INSERT: '.$real->getNom().' '.$real->getPrenom().'</br>';
			$mess .= 'update film set realisateur_id='.$a->getId().' where realisateur_id='.$real->getId().'</br>';
		}
	}
	echo $mess;
  exit;
  */
  
	
  
	$lettre=$request->getParameter('le');
	$this->lettre=$request->getParameter('le');
	/*
    $c1= new Criteria();
    $c1->add(FilmPeer::TITRE, $lettre.'%', Criteria::LIKE);
    //$c1->add(FilmPeer::SAGA_ID,NULL);
	
    $c2= new Criteria();
    $c2->add(FilmPeer::TITRE, $lettre.'%', Criteria::LIKE);
    $c2->add(FilmPeer::SAGA_ID,NULL, Criteria::NOT_EQUAL);
	// $c2->addGroupByColumn(FilmPeer::SAGA_ID);
	
	//$c2->addJoin($c1);
	
    $c= new Criteria();
	$c->add($c2);
	$c->addAscendingOrderByColumn(FilmPeer::TITRE);
	*/
	$pro=$this->getUser()->getAttribute("proprio");
	
	$c = new Criteria();
	
	$sel='';
	if($pro){
		$sel='and film.id IN (select film_id from filmproprietaire where utilisateur_id='.$pro->getId().')';
	}
	if($lettre=='autre'){
		$subSelect = "((film.saga_id is NULL and film.titre not REGEXP '^[a-z]') or film.id IN (select id from film where saga_id is not NULL and film.titre not REGEXP '^[a-z]' group by saga_id)) ".$sel." order by titre";
	}else if($lettre!=''){
		$subSelect = "((film.saga_id is NULL and film.titre LIKE '".$lettre."%') or film.id IN (select id from film where saga_id is not NULL ".$sel." and film.titre LIKE '".$lettre."%' group by saga_id)) ".$sel." order by titre";
	}else{
		$subSelect = "((film.saga_id is NULL) or film.id IN (select id from film where saga_id is not NULL group by saga_id)) ".$sel." order by titre";
	}
	$c->addOr(FilmPeer::ID, $subSelect, Criteria::CUSTOM);

	
	$this->pager = new sfPropelPager(
    'Film',sfConfig::get('app_nb_affichage')
    );
	$this->pager->setCriteria($c);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();




  }

  public function executeFilmsActeur(sfWebRequest $request)
  {
        $this->acteur = PersonnePeer::retrieveByPk($request->getParameter('id'));
        
		$pro=$this->getUser()->getAttribute("proprio");
        $this->film_list=$this->acteur->getFilmsActeur($pro);

        $this->saga_list=$this->acteur->getSagas();
  }
  
  
  public function executeFilmsRealisateur(sfWebRequest $request)
  {
        $this->realisateur = PersonnePeer::retrieveByPk($request->getParameter('id'));
        
		$pro=$this->getUser()->getAttribute("proprio");
        $this->film_list=$this->realisateur->getFilmsRealisateur($pro);

        $this->saga_list=$this->realisateur->getSagas();
  }
  
  public function executeNouveautes(sfWebRequest $request)
  {
		$lettre=$request->getParameter('le');
		$this->lettre=$request->getParameter('le');
		
		$pro=$this->getUser()->getAttribute("proprio");
		$crit = new Criteria();
        $crit = FilmPeer::getCritDerniersFilms($pro,20);
        
		$this->pager = new sfPropelPager(
		'Film',sfConfig::get('app_nb_affichage')
		);
		$this->pager->setCriteria($crit);
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();
  }
  
    public function executeMeilleurnote(sfWebRequest $request)
  {
		$lettre=$request->getParameter('le');
		$this->lettre=$request->getParameter('le');
		
		$pro=$this->getUser()->getAttribute("proprio");
		$crit = new Criteria();
        $crit = FilmPeer::getCritMeilleursNotes($pro,20);
        
		$this->pager = new sfPropelPager(
		'Film',sfConfig::get('app_nb_affichage')
		);
		$this->pager->setCriteria($crit);
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->film = FilmPeer::retrieveByPk($request->getParameter('id'));
    $this->admins = SfGuardUserPeer::doSelect(new Criteria());
    $this->forward404Unless($this->film);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new FilmForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new FilmForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($film = FilmPeer::retrieveByPk($request->getParameter('id')), sprintf('Object film n\'existe pas (%s).', $request->getParameter('id')));
    $this->form = new FilmForm($film);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'));
    $this->forward404Unless($film = FilmPeer::retrieveByPk($request->getParameter('id')), sprintf('Object film n\'existe pas (%s).', $request->getParameter('id')));
    $this->form = new FilmForm($film);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($film = FilmPeer::retrieveByPk($request->getParameter('id')), sprintf('Object film n\'existe pas (%s).', $request->getParameter('id')));
    $film->delete();

    $this->redirect('film/index');
  }
  
  public function executeAjoutProprio(sfWebRequest $request)
  {
  
	if($request->getParameter('id')){
		$film = FilmPeer::retrieveByPk($request->getParameter('id'));
		if(!$this->getUser()->getAttribute("login")->possede($film)){
			$filmPro= new Filmproprietaire();
			$filmPro->setFilm($film);
			$filmPro->setsfGuardUser($this->getUser()->getAttribute("login"));
			$filmPro->save();
			$film->addFilmproprietaire($filmPro);
		}
	}else if($request->getParameter('ids')){
		$saga = SagaPeer::retrieveByPk($request->getParameter('ids'));
		foreach($saga->getFilms() as $film){
			if(!$this->getUser()->getAttribute("login")->possede($film)){
				$filmPro= new Filmproprietaire();
				$filmPro->setFilm($film);
				$filmPro->setsfGuardUser($this->getUser()->getAttribute("login"));
				$filmPro->save();
				$film->addFilmproprietaire($filmPro);
			}
		}
	}
	

	$this->redirect($_SERVER['HTTP_REFERER']);
  }
  
  public function executeSupprProprio(sfWebRequest $request)
  {
	if($request->getParameter('id')){
		$film = FilmPeer::retrieveByPk($request->getParameter('id'));
		if($this->getUser()->getAttribute("login")->possede($film)){
			$filmPro= new Filmproprietaire();
			$filmPro->setFilm($film);
			$filmPro->setsfGuardUser($this->getUser()->getAttribute("login"));
			$filmPro->delete();
		}
	}else if($request->getParameter('ids')){
		$saga = SagaPeer::retrieveByPk($request->getParameter('ids'));
		foreach($saga->getFilms() as $film){
			if($this->getUser()->getAttribute("login")->possede($film)){
				$filmPro= new Filmproprietaire();
				$filmPro->setFilm($film);
				$filmPro->setsfGuardUser($this->getUser()->getAttribute("login"));
				$filmPro->delete();
			}
		}
	}
	
	$this->redirect($_SERVER['HTTP_REFERER']);
  }
  
  
    public function executeNoteFilmAdmin(sfWebRequest $request)
  {
  
	if($request->getParameter('id') && $request->getParameter('note')){
		$this->film = FilmPeer::retrieveByPk($request->getParameter('id'));
		$this->user = SfGuardUserPeer::retrieveByPk($this->getUser()->getAttribute("login"));
		$this->note=$request->getParameter('note');
		$this->setLayout(false);
	}
	
	
  }

	public function executeAjouterNoteFilmAdmin(sfWebRequest $request)
  {
  
	if($request->getParameter('id')){
		$film = FilmPeer::retrieveByPk($request->getParameter('id'));
		$c= new Criteria();
		$c->add(NotefilmadminPeer::FILM_ID, $request->getParameter('id'));
		$c->add(NotefilmadminPeer::UTILISATEUR_ID, $this->getUser()->getAttribute("login")->getId());
        $verif = NotefilmadminPeer::doSelect($c);
		if(sizeof($verif)==0){
			$note= new Notefilmadmin();
			$note->setFilm($film);
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
	//$this->redirect('film/show?id='.$request->getParameter('id'));
	
  }
  
  
  public function executeFiltrerFilm(sfWebRequest $request)
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
      $film = $form->save();

      $this->redirect('film/edit?id='.$film->getId());
    }
  }

}
