<?php

require_once dirname(__FILE__).'/../lib/saisonGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/saisonGeneratorHelper.class.php';

/**
 * saison actions.
 *
 * @package    sitedvd
 * @subpackage saison
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class saisonActions extends autoSaisonActions
{

  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->saison = $this->form->getObject();
	$c = new Criteria();
	$c->add(ActeurseriePeer::SAISON_ID, $this->saison->getId());
	$c->addAscendingOrderByColumn(ActeurseriePeer::ID);
	$a = ActeurseriePeer::doSelect($c);
	$acteur = '';
	foreach($a as $av){
		$acteur .= '/'.$av->getActeurId();
	}
	$this->acteur_ordre = $acteur;
	
	
	$s = SeriePeer::doSelect(new Criteria());
	$serie = '';
	foreach($s as $se){
		$serie .= '/'.$se->getId().'-'.$se->getRealisateurId();
		foreach($se->getSaisons() as $sa){
			if($this->saison->getNumero()!=$sa->getNumero() || $this->saison->getSerie()->getId()!=$se->getId() ){
				$serie .= '-'.$sa->getNumero();
			}
		}
	}
	$this->real_serie = $serie;
  }
  
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->saison = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->saison);
	$c = new Criteria();
	$c->add(ActeurseriePeer::SAISON_ID, $this->saison->getId());
	$c->addAscendingOrderByColumn(ActeurseriePeer::ID);
	$a = ActeurseriePeer::doSelect($c);
	$acteur = '';
	foreach($a as $av){
		$acteur .= '/'.$av->getActeurId();
	}
	$this->acteur_ordre = $acteur;
	
	$s = SeriePeer::doSelect(new Criteria());
	$serie = '';
	foreach($s as $se){
		$serie .= '/'.$se->getId().'-'.$se->getRealisateurId();
		foreach($se->getSaisons() as $sa){
			if($this->saison->getNumero()!=$sa->getNumero() || $this->saison->getSerie()->getId()!=$se->getId() ){
				$serie .= '-'.$sa->getNumero();
			}
		}
	}
	$this->real_serie = $serie;
  }
  
}
