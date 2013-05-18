<?php

/**
 * recherche actions.
 *
 * @package    dvdtheque
 * @subpackage recherche
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rechercheActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  
  
  
   public function preExecute()
  {
		UtilisateurPeer::preAll($this);
  }
  
  
  
  
  public function executeIndex(sfWebRequest $request)
  {
	
		$save='';
		if($this->getUser()->getAttribute('query')){
			$save=$this->getUser()->getAttribute('query');
		}
		$query = VideoPeer::clean($request->getParameter('query', $save, 'index'));
		$this->quer = $request->getParameter('query', $save, 'index');
		//$request->setParameter('query',);
		
		$this->getUser()->setAttribute('query', $this->quer);
		
		if(strlen($query)>1){
		//if(strlen($query)>=3){
			//$query = VideoPeer::clean($request->getParameter('query', 'video', 'index')).'*';
			$query = '%'.$query.'%';
			
			
			$pro=$this->getUser()->getAttribute("proprio");
			
			$this->forwardUnless($query, 'video', 'index');
			////////////////////////////////////////////////////////////////
			////////////////////////		VIDEOS		////////////////////
			////////////////////////////////////////////////////////////////
			
			/////////////// rechercher les videos sur leur titre ////////////
			$critFtitre = new Criteria();
			
			$critFtitre->add(VideoPeer::TITRE_CLEAN, $query, Criteria::LIKE);
			if($pro){
				$critFtitre->addJoin(VideoPeer::ID, VideoproprietairePeer::VIDEO_ID, Criteria::LEFT_JOIN);
				$critFtitre->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			
			$videosTitre = VideoPeer::doSelect($critFtitre);
			//$this->videos = VideoPeer::getForLuceneQuery($query);
			
			foreach($videosTitre as $videoT){
				$tabVideos[$videoT->getId()]++;
				$tab[$tabVideos[$videoT->getId()]][]=$videoT;
			}
			
			
			/////////////// rechercher les videos sur leurs mots-cle ////////////
			
			$critFmotscle = new Criteria();
			
			$critFmotscle->setDistinct();
			$critFmotscle->add(MotsclePeer::MOT_CLEAN, $query, Criteria::LIKE);
			$critFmotscle->addJoin(MotsclePeer::ID, MotsclevideoPeer::MOTSCLE_ID, Criteria::LEFT_JOIN);
			$critFmotscle->addJoin(MotsclevideoPeer::VIDEO_ID, VideoPeer::ID, Criteria::LEFT_JOIN);
			if($pro){
				$critFmotscle->addJoin(VideoPeer::ID, VideoproprietairePeer::VIDEO_ID, Criteria::LEFT_JOIN);
				$critFmotscle->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			$videosmotscle = VideoPeer::doSelect($critFmotscle);
			
			foreach($videosmotscle as $videoMC){
				$tabVideos[$videoMC->getId()]++;
				$tab[$tabVideos[$videoMC->getId()]][]=$videoMC;
				if($tabVideos[$videoMC->getId()]>1){
					unset($tab[$tabVideos[$videoMC->getId()]-1][array_search($videoMC, $tab[$tabVideos[$videoMC->getId()]-1])]);
				}
			}
			
			
			/////////////// rechercher les videos sur leurs categories ////////////
			
			$critFcategorie = new Criteria();
			
			$critFcategorie->setDistinct();
			$critFcategorie->add(CategoriePeer::NOM_CLEAN, $query, Criteria::LIKE);
			$critFcategorie->addJoin(CategoriePeer::ID, CategorievideoPeer::CATEGORIE_ID, Criteria::LEFT_JOIN);
			$critFcategorie->addJoin(CategorievideoPeer::VIDEO_ID, VideoPeer::ID, Criteria::LEFT_JOIN);
			if($pro){
				$critFcategorie->addJoin(VideoPeer::ID, VideoproprietairePeer::VIDEO_ID, Criteria::LEFT_JOIN);
				$critFcategorie->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			$videoscategorie = VideoPeer::doSelect($critFcategorie);
			
			foreach($videoscategorie as $videoC){
				$tabVideos[$videoC->getId()]++;
				$tab[$tabVideos[$videoC->getId()]][]=$videoC;
				if($tabVideos[$videoC->getId()]>1){
					unset($tab[$tabVideos[$videoC->getId()]-1][array_search($videoC, $tab[$tabVideos[$videoC->getId()]-1])]);
				}
			}
			
			
			/////////////// rechercher les videos sur leurs acteurs ////////////
			
			$critFacteur = new Criteria();
			
			$critFacteur->setDistinct();
			$critFacteur->add(PersonnePeer::NOM_PRENOM_CLEAN, $query, Criteria::LIKE);
			$critFacteur->addJoin(PersonnePeer::ID, ActeurvideoPeer::ACTEUR_ID, Criteria::LEFT_JOIN);
			$critFacteur->addJoin(ActeurvideoPeer::VIDEO_ID, VideoPeer::ID, Criteria::LEFT_JOIN);
			if($pro){
				$critFacteur->addJoin(VideoPeer::ID, VideoproprietairePeer::VIDEO_ID, Criteria::LEFT_JOIN);
				$critFacteur->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}
			$videosacteur = VideoPeer::doSelect($critFacteur);
			
			foreach($videosacteur as $videoA){
				$tabVideos[$videoA->getId()]++;
				$tab[$tabVideos[$videoA->getId()]][]=$videoA;
				if($tabVideos[$videoA->getId()]>1){
					unset($tab[$tabVideos[$videoA->getId()]-1][array_search($videoA, $tab[$tabVideos[$videoA->getId()]-1])]);
				}
			}
			
			
			/////////////// rechercher les videos sur leurs réalisateurs ////////////
			
			$critFrealisateur = new Criteria();
			
			$critFrealisateur->setDistinct();
			$critFrealisateur->add(PersonnePeer::NOM_PRENOM_CLEAN, $query, Criteria::LIKE);
			$critFrealisateur->addJoin(PersonnePeer::ID, VideoPeer::REALISATEUR_ID, Criteria::LEFT_JOIN);
			if($pro){
				$critFrealisateur->addJoin(VideoPeer::ID, VideoproprietairePeer::VIDEO_ID, Criteria::LEFT_JOIN);
				$critFrealisateur->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
				
				
			}
			$videosrealisateur = VideoPeer::doSelect($critFrealisateur);
			
			foreach($videosrealisateur as $videoR){
				$tabVideos[$videoR->getId()]++;
				$tab[$tabVideos[$videoR->getId()]][]=$videoR;
				if($tabVideos[$videoR->getId()]>1){
					unset($tab[$tabVideos[$videoR->getId()]-1][array_search($videoR, $tab[$tabVideos[$videoR->getId()]-1])]);
				}
			}
			
			//////////////// tous remettre dans l'ordre ////////////////////
			$tab=array_reverse($tab);
			foreach($tab as $nb => $videos){
				foreach($videos as $video){
					if($video->getId()){
						if($video->getType()=='film'){
							$tabFilmFinal[]=$video;
						}else if($video->getType()=='spectacle'){
							$tabSpectacleFinal[]=$video;
						}
					}
				}
			}
			$this->films=$tabFilmFinal;
			$this->spectacles=$tabSpectacleFinal;
			
			
			
			
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
				$critA->addJoin(PersonnePeer::ID, ActeurvideoPeer::ACTEUR_ID, Criteria::LEFT_JOIN);
				$critA->addJoin(ActeurvideoPeer::VIDEO_ID, VideoproprietairePeer::VIDEO_ID, Criteria::LEFT_JOIN);
				$critA->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
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
				$critR->addJoin(PersonnePeer::ID, VideoPeer::REALISATEUR_ID, Criteria::LEFT_JOIN);
				$critR->addJoin(VideoPeer::ID, VideoproprietairePeer::VIDEO_ID, Criteria::LEFT_JOIN);
				$critR->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
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
            $this->renderText('<h2>Resultat pour les Videos</h2>');
            if ($query=='' || !$this->videos){
                $this->renderText('<div class="rouge centre"><i>Aucun Video n\'a été trouvé</i></div>');
            }else{
                $this->renderPartial('video/listVideo', array('videos' => $this->videos));
            }

        }
		*/

  }
  
  public function executeAvance(sfWebRequest $request)
  {
		$qualite = $request->getParameter('qualite', 'recherche', 'index');
		$duree = $request->getParameter('duree', 'recherche', 'index');
		$version = $request->getParameter('version', 'recherche', 'index');
		$annee = $request->getParameter('annee', 'recherche', 'index');
		$acteurs = $request->getParameter('acteurs', 'recherche', 'index');
		$categorie = $request->getParameter('categorie', 'recherche', 'index');

		$crit_qua= new Criteria();
		if (strlen($qualite)>0){
			$crit_qua->addJoin(VideoPeer::QUALITE_ID, QualitePeer::ID);
			$crit_qua->add(QualitePeer::ID, $qualite, Criteria::EQUAL);
		}
		if (strlen($version)>0){
			$crit_qua->addJoin(VideoPeer::VERSION_ID,VersionPeer::ID);
			$crit_qua->add(VersionPeer::ID, $version, Criteria::EQUAL);
		}
		if (strlen($categorie)>0){
			$crit_qua->addJoin(VideoPeer::ID,CategorieVideoPeer::VIDEO_ID);
			$crit_qua->add(CategorieVideoPeer::CATEGORIE_ID, $categorie, Criteria::EQUAL);
		}
		if (strlen($duree)>0){
			$crit_qua->add(VideoPeer::DUREE, $duree, Criteria::LESS_THAN);
		}
		if (strlen($annee)>0){
			$crit_qua->add(VideoPeer::ANNEE_SORTIE, $annee, Criteria::EQUAL);
		}
		if (sizeof($acteurs)>0){
			$crit_qua->addJoin(VideoPeer::ID,ActeurVideoPeer::VIDEO_ID, Criteria::INNER_JOIN);

			//foreach($acteurs as $act){
				$c = $crit_qua->getNewCriterion(ActeurVideoPeer::ACTEUR_ID,3);
				$c->addOR($crit_qua->getNewCriterion(ActeurVideoPeer::ACTEUR_ID,1));
				$crit_qua->add(ActeurVideoPeer::ACTEUR_ID, $c, Criteria::IN);
				
				$this->c=$c;
				$crit_qua->add($c);

			//} 
		}	
		$crit_qua->setDistinct();
		$this->resultat = VideoPeer::doSelect($crit_qua);
		
   }
 
  
   
  
}
