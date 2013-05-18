<?php


/**
 * Skeleton subclass for representing a row from the 'saison' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 12/04/10 09:58:05
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Saison extends BaseSaison {

	/**
	 * Initializes internal state of Saison object.
	 * @see        parent::__construct()
	 */
	public function __construct()
	{
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}
  public function __toString()
  {
    return sprintf('%s', $this->getSerie()->getTitre().' - Saison '.$this->getNumero());
  }



	public function resizeImage(){
      $file = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'saisons'.DIRECTORY_SEPARATOR.$this->getImage() ;
	  
      $img = new sfImage($file) ;
      $img->resizeProp(240,320);//class ajout� dans sfImage pour redimensioner l'image proportionelement
	  //160,213
      $img->saveas($file);
      }

 public function save(PropelPDO $con = null) {
    if ($this->getImage()=="")
    {
      return parent::save($con);

    }
    else
       $this->resizeImage();

    return parent::save($con);
  }

      public function postDelete(PropelPDO $con = null){
  // On supprime la photo si le fichier existe
      if (file_exists(sfConfig::get('sf_upload_dir') . '/saisons/'.$this->getImage())){
        @unlink(sfConfig::get('sf_upload_dir') . '/saisons/'.$this->getImage());
      }
  }
  
    public function getEpisodes(){
            $crit=new Criteria();
            $crit->add(VideoPeer::TYPE,'episode');
            $crit->add(VideoPeer::SAISON_ID,$this->getId());
            $crit->addAscendingOrderByColumn(VideoPeer::NUMERO);

            return VideoPeer::doSelect($crit);
    }
	
    public function getEpisodesPossede($pro){
            $crit=new Criteria();
            $crit->add(VideoPeer::TYPE,'episode');
            $crit->add(VideoPeer::SAISON_ID,$this->getId());
			if($pro){
				$crit->addJoin(VideoproprietairePeer::VIDEO_ID,VideoPeer::ID, Criteria::LEFT_JOIN);
				$crit->add(VideoproprietairePeer::UTILISATEUR_ID, $pro->getId());
			}else{
				$subSelect = "video.id in (select video_id from videoproprietaire) ";
				$crit->add(VideoPeer::ID, $subSelect, Criteria::CUSTOM);
			}
            $crit->addAscendingOrderByColumn(VideoPeer::NUMERO);

            return VideoPeer::doSelect($crit);
    }
	
    public function getEpisodesOrdre(){
            $list = $this->getEpisodes();
			foreach($list as $e){
				$tab[$e->getNumero()] = $e;
			}
			

            return $tab;
    }
	
    public function getMaxEpisodes(){
	
            $crit=new Criteria();
            $crit->add(VideoPeer::TYPE,'episode');
            $crit->add(VideoPeer::SAISON_ID,$this->getId());
            $crit->addDescendingOrderByColumn(VideoPeer::NUMERO);
			$crit->setLimit(1);
			$res = VideoPeer::doSelect($crit);
			

            return $res[0];
    }
	
    public function getMaxEpisodesTot(){
			$max = $this->getMaxEpisodes();
			if($max){
				$numEp=$max->getNumero();
			}else{
				$numEp=0;
			}
            return max($this->getNbEpisodeTot(),$numEp);
    }
  
  public function getEpisodeSaison(){
            foreach($this->getEpisodes() as $i => $ep){
				$episodes[]=$ep;
            }
            return $episodes;
    }
  
  
        public function getRealisateur(){
			return $this->getPersonne();
        }
		
		
		public function getNoteAdmin(){
			foreach($this->getNoteserieadmins() as $note){ 
                 $notes[$note->getUtilisateurId()]['note']=$note->getNote();
                 $notes[$note->getUtilisateurId()]['mess']=$note->getMessage();
            }
            return $notes;
		}
		
		
        public function getCategories($nb=0){
            return $this->getSerie()->getCategories($nb);
        }
		
        public function getFormatDuree(){
            return $this->getSerie()->getFormatDuree();
        }
		
		
        public function getActeurs($nb=0){
			$acteurs = Array();
			$crit=new Criteria();
			$crit->addAscendingOrderByColumn(ActeurseriePeer::ID);
            foreach($this->getActeurseries() as $i => $act){
                if($i<$nb || $nb==0){
                    $acteurs[]=$act->getPersonne();
                }
            }
            return $acteurs;
        }
		
		
	  public function getProprietaires()
	  {
		$fini = false;
		$proprios=Array();
		foreach($this->getEpisodes() as $i => $ep){
			if(!$fini){
				foreach($ep->getProprietaires() as $j => $admin){
					if(!in_array($admin,$proprios)){
						$proprios[]=$admin;
						if(sizeof($proprios)==sizeof(sfGuardUserPeer::getProprio())){
							break;
						}
					}
				}
			}
			
		}
		return $proprios;
	  }
		
		
	   public function setTitre($v){
			$clean=VideoPeer::clean($v.$this->setSousTitre().$this->getTitreOriginal());
			$this->setTitreClean($clean);
			return parent::setTitre($v);
	   }
	   
	   
	   public function setSousTitre($v){
			$clean=VideoPeer::clean($this->getTitre().$v.$this->getTitreOriginal());
			$this->setTitreClean($clean);
			return parent::setSousTitre($v);
	   }
	   
	   public function setTitreOriginal($v){
			$clean=VideoPeer::clean($this->getTitre().$this->getSousTitre().$v);
			$this->setTitreClean($clean);
			return parent::setTitreOriginal($v);
	   }
	   
	   
	   public function getChiffreTop($num){
			if(strlen($num)==1){
				$num='0'.$num;
			}
			return $num;
	   }  
	   
	   

} // Saison
