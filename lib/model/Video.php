<?php


/**
 * Skeleton subclass for representing a row from the 'video' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Mon Aug 29 10:18:21 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Video extends BaseVideo {

	/**
	 * Initializes internal state of Video object.
	 * @see        parent::__construct()
	 */
	public function __construct(){
		// Make sure that parent constructor is always invoked, since that
		// is where any default values for this object are set.
		parent::__construct();
	}

	public function __toString(){
        return sprintf('%s', $this->getTitre());
    }

        public function getExtraitResume($lg_max=400){
            // on peut remplacer par une donn�e issue d'une base sql (ex: $chaine = $sql['texte'];)
            $chaine = $this->getResume();

            //On v�rifie si le texte est plus grand que le nombre de caract�res sp�cifi�s
            if (strlen($chaine) > $lg_max)

            //Si la r�ponse est non le script ne fait rien mais si c'est oui on continue...
            {
                $chaine = substr($chaine, 0, $lg_max);
                //on cherche l'espace le plus proche du maximum des caract�res autoris�s (ici 160)
                $last_space = strrpos($chaine, " ");
                //On ajoute ... � la suite de cet espace
                $chaine = substr($chaine, 0, $last_space);
            }

            return $chaine;
        }

        public function getResteResume($lg_max=400){
            // on peut remplacer par une donn�e issue d'une base sql (ex: $chaine = $sql['texte'];)
            $chaine = $this->getResume();

            //On v�rifie si le texte est plus grand que le nombre de caract�res sp�cifi�s
            if (strlen($chaine) > $lg_max){
                $chaine2 = substr($chaine, 0, $lg_max);
                //on cherche l'espace le plus proche du maximum des caract�res autoris�s (ici 160)
                $last_space = strrpos($chaine2, " ");
                //On ajoute ... � la suite de cet espace
                $chaine = substr($chaine, $last_space);
            }else{
                $chaine="";
            }

            return $chaine;
        }


        public function getCategories($nb=0){
            foreach($this->getCategorievideos() as $i=>$cat){
                if($i<$nb || $nb==0){
                    $categories[]=$cat->getCategorie();
                }
            }
            return $categories;
        }

        public function getActeurs($nb=0){
			$crit=new Criteria();
			$crit->addAscendingOrderByColumn(ActeurvideoPeer::ID);
			$acteurs = Array();
            foreach($this->getActeurvideos() as $i => $act){
                if($i<$nb || $nb==0){
                    $acteurs[]=$act->getActeur();
                }
            }
            return $acteurs;
        }
		
        public function getMotsCles(){
            foreach($this->getMotsclevideos() as $i => $mc){
                $motscles[]=$mc->getMotscle();
            }
            return $motscles;
        }
		
        public function getRealisateur(){
			return $this->getPersonne();
        }
		
		
		public function getProprietaires(){
			$proprios = Array();
			foreach($this->getVideoproprietaires() as $i => $admin){
                 $proprios[]=$admin->getsfGuardUser();
            }
            return $proprios;
		}
		
		public function getProprietairesId(){
			$proprios = Array();
			foreach($this->getVideoproprietaires() as $i => $admin){
                 $proprios[]=$admin->getsfGuardUser()->getId();
            }
            return $proprios;
		}
		
		public function getNoteAdmin(){
			$notes = Array();
			foreach($this->getNotevideoadmins() as $note){ 
                 $notes[$note->getUtilisateurId()]['note']=$note->getNote();
                 $notes[$note->getUtilisateurId()]['mess']=$note->getMessage();
            }
            return $notes;
		}
		
		public function getNoteMoyenne($pro){
			$noteSomme=0;
			$nb=0;
			foreach($this->getNotevideoadmins() as $note){
                 $noteSomme+=$note->getNote();
				 $nb++;
            }
			$moyenne = 0;
			if($nb!=0){
				$moyenne=$noteSomme/$nb;
			}
            return $moyenne;
		}
		

		public function afficheBandeAnnonce($width='100%', $height='100%'){
			if(substr($this->getBandeAnnonce(), 18, 10)=="cinemovies" || substr($this->getBandeAnnonce(), 11, 10)=="cinemovies"){
				echo '
				<object width="'.$width.'" height="'.$height.'" data="http://www.cinemovies.fr/player/export/cinemovies-player.swf" type="application/x-shockwave-flash">
				<param name="flashvars" value="config='.$this->getBandeAnnonce().'" />
				<param name="src" value="http://www.cinemovies.fr/player/export/cinemovies-player.swf" />
				<param name="allowfullscreen" value="true" />
				</object>
				';
			}else{
				echo '
				<iframe title="" width="'.$width.'" height="'.$height.'" src="'.$this->getBandeAnnonce().'" frameborder="0" allowfullscreen></iframe>
				';
			/*
				echo '
				<object width="'.$width.'" height="'.$height.'" standby="Chargement..." >
					<param name="movie" value="'.$this->getBandeAnnonce().'"></param>
					<param name="allowFullScreen" value="true"></param>
					<param name="allowScriptAccess" value="always"></param>
					<embed src="'.$this->getBandeAnnonce().'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowFullScreen="true" allowScriptAccess="always"/>
				</object>
				';
				*/
			}
		}
		

        public function resizeImage($temp=false){
			if(!$temp){
				$file = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'videos'.DIRECTORY_SEPARATOR.$this->getImage() ;
			}else{
				$file = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'videos'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.$this->getImage() ;
			}
          $img = new sfImage($file) ;
          $img->resizeProp(240,320) ;
			//160,213
          $img->saveas($file);
      } 

      public function save(PropelPDO $con = null){
            if (!$this->getImage()=="")
            {
              $this->resizeImage();
            }		
            if (is_null($con))
            {
                $con = Propel::getConnection(VideoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
            }

            $con->beginTransaction();
            try
            {
              $ret = parent::save($con);
              $this->updateLuceneIndex();
              $con->commit();
              return $ret;
            }
            catch (Exception $e)
            {
              $con->rollBack();
              throw $e;
            }

          }

    public function delete(PropelPDO $con = null)
	{
	  $index = VideoPeer::getLuceneIndex();
	  foreach ($index->find('pk:'.$this->getId()) as $hit)
	  {
		$index->delete($hit->id);
	  }
	 
	  return parent::delete($con);
	}
	
      public function postDelete(PropelPDO $con = null){
      // On supprime la photo si le fichier existe
          if (file_exists(sfConfig::get('sf_upload_dir') . '/videos/'.$this->getImage())){
            @unlink(sfConfig::get('sf_upload_dir') . '/videos/'.$this->getImage());
          }
      }

        public function updateLuceneIndex()
        {
          $index = VideoPeer::getLuceneIndex();

          // remove existing entries
          foreach ($index->find('pk:'.$this->getId()) as $hit)
          {
            $index->delete($hit->id);
          }
		  
          $doc = new Zend_Search_Lucene_Document();

          // store job primary key to identify it in the search results
          $doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getId()));

          // index job fields
          $doc->addField(Zend_Search_Lucene_Field::UnStored('titre', VideoPeer::clean($this->getTitre()), 'utf-8'));
		  $doc->addField(Zend_Search_Lucene_Field::UnStored('titre_officiel', VideoPeer::clean($this->setSousTitre()), 'utf-8'));
          $doc->addField(Zend_Search_Lucene_Field::UnStored('duree', $this->getDuree(), 'utf-8'));
          // add job to the index
          $index->addDocument($doc);
          $index->commit();
        }

        public function getActiveVideosCriteria()
        {
		  $crit=new Criteria();
	      $crit->add(VideoPeer::SAGA_ID,NULL);

          return VideoPeer::doSelect($crit);
        }
		
		public function addProprietaireAurel()
	    {
			$videoPro= new Videoproprietaire();
			$videoPro->setVideo($video);
			$videoPro->setUtilisateurId(1);
			$videoPro->save();
			$this->addVideoproprietaire($videoPro);
			
			return true;
	   }
	   
	   public function addProprietairePierre()
	    {
			$videoPro= new Videoproprietaire();
			$videoPro->setVideo($video);
			$videoPro->setUtilisateurId(1);
			$videoPro->save();
			$this->addVideoproprietaire($videoPro);
			
			return true;
	   }
	   
	   
	   public function setTitre($v){
			$clean=VideoPeer::clean($v.$this->getSousTitre().$this->getTitreOriginal());
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
	   
	   public function getDureeHeure(){
			$duree=$this->getDuree();
			$heures=floor($duree/60);
			$mins=$duree-($heures*60);
			if(strlen($mins)==1){
				$mins='0'.$mins;
			}
			return $heures.'h'.$mins;
	   }  
	   
	   
	   
///////////// EPISODE /////////////////////
	   public function getNumeroTop(){
			$num=$this->getNumero();
			if(strlen($num)==1){
				$num='0'.$num;
			}
			return $num;
	   }  
	   
		public function getNbEpisodes($pro){
			return VideoPeer::getNbEpisodesSaison($this->getSaison(),$pro);
		}
		
		public function getAfficheEpisodes($pro){
			$aff='';
			if(sizeof($this->getSaison()->getEpisodesPossede($pro))>1){
				$aff2='';
				$aff3='';
				$num=0;
				$cours=false;
				$parf=true;
				foreach($this->getSaison()->getEpisodesPossede($pro) as $ep){
					if($num==0){
						if($ep->getNumero()!=1){
							$aff .= $ep->getNumero();
							$parf=false;
						}else{
							$aff2 .= $ep->getNumero();
						}
						$num=$ep->getNumero();
					}else if($num+1==$ep->getNumero()){
						$num=$ep->getNumero();
						$cours=true;
					}else if($cours){
						if($parf){
							$aff .= $aff2.' -> '.$num;
						}else{
							$aff .= ' -> '.$num;
						}
						$aff .= ', '.$ep->getNumero();
						$num=$ep->getNumero();
						$cours=false;
						$parf=false;
					}else{
						if($parf){
							$aff .= $aff2.', '.$ep->getNumero();
						}else{
							$aff .= ', '.$ep->getNumero();
						}
						$num=$ep->getNumero();
						$parf=false;
					}
				}
				if($cours && !$parf){
					$aff .= ' -> '.$num;
					$cours=false;
				}else if($parf){
					$aff .= $num;
				}
			}else if(sizeof($this->getSaison()->getEpisodesPossede($pro))==1){
				$tab = $this->getSaison()->getEpisodesPossede($pro);
				$aff=$tab[0]->getNumero()." -> ".$tab[0]->getNumero();
			}else{
				$aff=0;
			}
			
			return $aff;
		}
		
public function uploadImageUrlTemp($url, $name='') {
	$repertoire = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'videos'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
	$er=0;
	$url_ary = Array();
	if(!preg_match('/^(http:\/\/)?([\w\-\.]+)\:?([0-9]*)\/(.*)$/', $url, $url_ary)){
		$er=1;
	}
	if(empty($url_ary[4])){
		$er=1;
	}
	if($er==1) {
		return false;
	}else{
		$maxsize = 100000000;
		if($name==''){
			$base_filename = substr($url_ary[4],strrpos($url_ary[4],"/")+1);
			
			$tab_name = explode(".",$base_filename);
			$name = $tab_name[0];
			$extension = $tab_name[1];
			$base_filename = sha1($name.rand(11111, 99999)).'.'.$extension;
		}else{
			$base_filename = $name;
		}
	
		$base_get = '/' . $url_ary[4];
		$port = ( !empty($url_ary[3]) ) ? $url_ary[3] : 80;

		if($base_filename==""){
			return false;
		}

		if (!($fsock = fsockopen($url_ary[2], $port, $errno, $errstr))){
			return false;
		}

		fputs($fsock, "GET $base_get HTTP/1.1\r\n");
		fputs($fsock, "Host: " . $url_ary[2] . "\r\n");
		fputs($fsock, "Accept-Language: fr\r\n");
		fputs($fsock, "Accept-Encoding: none\r\n");
		fputs($fsock, "User-Agent: PHP\r\n");
		fputs($fsock, "Connection: close\r\n\r\n");

		unset($data);
		while(!feof($fsock)){
			$data .= fread($fsock, $maxsize);
		}
		fclose($fsock);

		if (!preg_match('#Content-Length\: ([0-9]+)[^ /][\s]+#i', $data, $file_data1) || !preg_match('#Content-Type\: image/[x\-]*([a-z]+)[\s]+#i', $data, $file_data2)){
			return false;
		}

		$filesize = $file_data1[1]; 
		$filetype = $file_data2[1]; 

		if (!$error && $filesize > 0 && $filesize < $maxsize){
			$data = substr($data, strlen($data) - $filesize, $filesize);

			$filename = $repertoire.$base_filename;
			if(file_exists($filename) && $name==''){
				return false;
			}else{
				$fptr = fopen($filename, 'wb');
				$bytes_written = fwrite($fptr, $data, $filesize);
				fclose($fptr);
		
				if ($bytes_written != $filesize){
					unlink($tmp_filename);
					return false;
				}
				$this->setImage($base_filename);
				$this->resizeImage(true);
				return true;
			}
		}else{
			return false;
		}
	}
}


	public function addProprio($admin) {
		if(!$admin->possede($this)){
			//$video->addProprietairePierre();
			$videoPro= new Videoproprietaire();
			$videoPro->setVideo($this);
			$videoPro->setsfGuardUser($admin);
			$videoPro->save();
			$this->addVideoproprietaire($videoPro);
		}
	}



} // Video
