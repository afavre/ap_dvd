<?php

/**
 * Video filter form.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
class VideoFormFilter extends BaseVideoFormFilter
{
	public function configure(){
		if((isset($_REQUEST['type']) && !$_REQUEST['type']) || !isset($_REQUEST['type'])){
			$type='film';
		}else{
			$type = $_REQUEST['type'];
		}
			
		$this->widgetSchema['created_at']->setOption('label','Ajouté');
		$this->widgetSchema['created_at']->setOption('template','Entre %from_date%<br /> Et %to_date%');
		$this->widgetSchema['updated_at']->setOption('label','Modifié');
		$this->widgetSchema['updated_at']->setOption('template','Entre %from_date%<br /> Et %to_date%');
		
		$this->widgetSchema['updated_at']->setOption('empty_label','Aucune date de modifiation');
		$this->widgetSchema['created_at']->setOption('empty_label','Aucune date de creation');
		$this->widgetSchema['sous_titre']->setOption('empty_label','Aucun sous-titre');
		$this->widgetSchema['titre_original']->setOption('empty_label','Aucun titre original');
		$this->widgetSchema['annee_sortie']->setOption('empty_label','Aucune annee de sortie');
		$this->widgetSchema['duree']->setOption('empty_label','Aucune duree');
		
		
		$c = new Criteria();
		$c->add(VideoPeer::TYPE, $type);
		$c->addJoin(PersonnePeer::ID, VideoPeer::REALISATEUR_ID, Criteria::LEFT_JOIN);
		$this->widgetSchema['realisateur_id']->setOption('criteria',$c);
		
		
		if($type=="film"){
			
			$c = new Criteria();
			$c->add(VideoPeer::TYPE, $type);
			$c->addJoin(VideoPeer::ID, ActeurvideoPeer::VIDEO_ID, Criteria::LEFT_JOIN);
			$c->addJoin(ActeurvideoPeer::ACTEUR_ID, PersonnePeer::ID, Criteria::LEFT_JOIN);
			$this->widgetSchema['acteurvideo_list']->setOption('criteria',$c);
			
			$c = new Criteria();
			$c->add(VideoPeer::TYPE, $type);
			$c->addJoin(VideoPeer::ID, CategorievideoPeer::VIDEO_ID, Criteria::LEFT_JOIN);
			$c->addJoin(CategorievideoPeer::CATEGORIE_ID, CategoriePeer::ID, Criteria::LEFT_JOIN);
			$this->widgetSchema['categorievideo_list']->setOption('criteria',$c);
			
			unset(
			   $this['nb_visite'], $this['is_public'], $this['image'], $this['bande_annonce'], $this['resume'], $this['avertissement'], $this['titre_clean'],$this['saison_id'], $this['numero'], $this['motsclevideo_list']
			);
		}else if($type=="spectacle"){
			$this->widgetSchema['bande_annonce']->setOption('label','Extrait');
			$this->widgetSchema['realisateur_id']->setOption('label','Auteur');
			unset(
			   $this['nb_visite'], $this['is_public'], $this['image'], $this['bande_annonce'], $this['resume'], $this['avertissement'], $this['titre_clean'],$this['saison_id'], $this['numero'], $this['version_id'], $this['saga_id'], $this['acteurvideo_list'], $this['motsclevideo_list'], $this['categorievideo_list']
			);
		}else if($type=="episode"){
			unset(
			   $this['nb_visite'], $this['is_public'], $this['image'], $this['bande_annonce'], $this['titre_clean'], $this['saga_id'], $this['acteurvideo_list'], $this['resume'], $this['avertissement'], $this['sous_titre'], $this['titre_original'], $this['bande_annonce'], $this['annee_sortie'], $this['duree'], $this['motsclevideo_list'], $this['categorievideo_list']
			);
		}
	}
}
