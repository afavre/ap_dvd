<?php

require_once dirname(__FILE__).'/../lib/filmGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/filmGeneratorHelper.class.php';

/**
 * film actions.
 *
 * @package    sitedvd
 * @subpackage film
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class filmActions extends autoFilmActions{

  public function executeNewAuto(sfWebRequest $request)
  {
    $this->form = new FilmAutoForm();
  }

  public function executeAjaxVerifExiste(sfWebRequest $request){

      $val=FilmPeer::clean($request->getParameter('value'));
      $films = FilmPeer::getForLuceneQuery($val);
        $bool='false';
	foreach($films as $film){
                $bool='true';
                $infos.='/'.$film->getTitre().'/'.$film->getId();
        }

        return $this->renderText($bool.$infos);

  }
  
  public function executeBatchAjouter_a_aurel(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
 
    $films = FilmPeer::retrieveByPks($ids);

    foreach ($films as $film)
    {
		$admin = sfGuardUserPeer::retrieveByPk(1);
		if(!$admin->possede($film)){
			//$film->addProprietairePierre();
			$filmPro= new Filmproprietaire();
			$filmPro->setFilm($film);
			$filmPro->setsfGuardUser($admin);
			$filmPro->save();
			$film->addFilmproprietaire($filmPro);
		}
    }
 
    $this->getUser()->setFlash('notice', 'Les films séléctionnés ont été ajoutés a Aurel');
	$this->redirect('film');
	
  }
  
    
  public function executeBatchAjouter_a_pierre(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
 
    $films = FilmPeer::retrieveByPks($ids);

    foreach ($films as $film)
    {
		$admin = sfGuardUserPeer::retrieveByPk(2);
		if(!$admin->possede($film)){
			//$film->addProprietairePierre();
			$filmPro= new Filmproprietaire();
			$filmPro->setFilm($film);
			$filmPro->setsfGuardUser($admin);
			$filmPro->save();
			$film->addFilmproprietaire($filmPro);
		}
    }
 
    $this->getUser()->setFlash('notice', 'Les films séléctionnés ont été ajoutés a Pierre');
	$this->redirect('film');
	
  }
  
  //Permet de mettre a jour l'index des acteurs pour la recherche
  public function executeBatchMaj(sfWebRequest $request)
  {
    $films = FilmPeer::doSelect(new criteria());
    foreach ($films as $film)
    {
		$film->updateLuceneIndex();
	}
    $this->getUser()->setFlash('notice', 'L index des films à été mis a jour');
	$this->redirect('film');
  }
}
