<?php

/**
 * nouveautes actions.
 *
 * @package    dvdtheque
 * @subpackage nouveautes
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class nouveautesActions extends sfActions
{
  public function preExecute()
  {
  
		UtilisateurPeer::preAll($this);
  }
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
	
		$lettre=$request->getParameter('le');
		$this->lettre=$request->getParameter('le');
		
		$pro=$this->getUser()->getAttribute("proprio");
		//$crit = new Criteria();
        $videos = VideoPeer::getDerniersVideos($pro, 150);
		$page_act = 1;
		if($request->getParameter('page')){
			$page_act = $request->getParameter('page');
		}
		$this->pager = VideoPeer::getPager($videos, $page_act, sfConfig::get('app_nb_affichage'));
		
		
		/*
		$this->pager = new sfPropelPager(
		'Video',sfConfig::get('app_nb_affichage')
		);
		
		$crit->SetDistinct();
		$this->pager->setCriteria($crit);
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();
		*/
  }
}
