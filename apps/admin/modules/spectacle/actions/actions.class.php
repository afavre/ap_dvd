<?php

require_once dirname(__FILE__).'/../lib/spectacleGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/spectacleGeneratorHelper.class.php';

/**
 * spectacle actions.
 *
 * @package    dvdtheque
 * @subpackage spectacle
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class spectacleActions extends autoSpectacleActions
{
  public function executeAjaxVerifExiste(sfWebRequest $request){

      $val=FilmPeer::clean($request->getParameter('value'));
      $spectacles = SpectaclePeer::getForLuceneQuery($val);
        $bool='false';
	foreach($spectacles as $spectacle){
                $bool='true';
                $infos.='/'.$spectacle->getTitre().'/'.$spectacle->getId();
        }

        return $this->renderText($bool.$infos);

  } 
  
  public function executeBatchAjouter_a_aurel(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
 
    $films = SpectaclePeer::retrieveByPks($ids);

    foreach ($spectacles as $spectacle)
    {
		$admin = sfGuardUserPeer::retrieveByPk(1);
		if(!$admin->possede($spectacle)){
			//$spectacle->addProprietairePierre();
			$spectaclePro= new Spectacleproprietaire();
			$spectaclePro->setSpectacle($spectacle);
			$spectaclePro->setsfGuardUser($admin);
			$spectaclePro->save();
			$spectacle->addSpectacleproprietaire($spectaclePro);
		}
    }
 
    $this->getUser()->setFlash('notice', 'Les spectacles séléctionnés ont été ajoutés a Aurel');
	$this->redirect('spectacle');
	
  }
  
    
  public function executeBatchAjouter_a_pierre(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
 
    $spectacles = FilmPeer::retrieveByPks($ids);

    foreach ($spectacles as $spectacle)
    {
		$admin = sfGuardUserPeer::retrieveByPk(2);
		if(!$admin->possede($spectacle)){
			//$spectacle->addProprietairePierre();
			$spectaclePro= new Spectacleproprietaire();
			$spectaclePro->setSpectacle($spectacle);
			$spectaclePro->setsfGuardUser($admin);
			$spectaclePro->save();
			$spectacle->addFilmproprietaire($spectaclePro);
		}
    }
 
    $this->getUser()->setFlash('notice', 'Les spectacles séléctionnés ont été ajoutés a Pierre');
	$this->redirect('spectacle');
	
  }
  
  //Permet de mettre a jour l'index des acteurs pour la recherche
  public function executeBatchMaj(sfWebRequest $request)
  {
    $spectacles = SpectaclePeer::doSelect(new criteria());
    foreach ($spectacles as $spectacle)
    {
		$spectacle->updateLuceneIndex();
	}
    $this->getUser()->setFlash('notice', 'L index des spectacles à été mis a jour');
	$this->redirect('spectacle');
  }
}
