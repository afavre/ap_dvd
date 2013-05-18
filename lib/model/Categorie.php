<?php


/**
 * Skeleton subclass for representing a row from the 'categorie' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 12/04/10 09:58:08
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Categorie extends BaseCategorie {
  public function __toString()
  {
    return sprintf('%s', $this->getNom());
  }
  
  public function save(PropelPDO $con = null){
			
		if (is_null($con))
		{
			$con = Propel::getConnection(CategoriePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
  $index = CategoriePeer::getLuceneIndex();
 
  foreach ($index->find('pk:'.$this->getId()) as $hit)
  {
    $index->delete($hit->id);
  }
 
  return parent::delete($con);
}
	
    public function getAllFilms($pro,$nb=0){
		$u=0;
		foreach($this->getCategorievideos() as $i => $film){
				if($pro){
					if($pro->possede($film->getVideo())){
						if($u<$nb || $nb==0){
							$films[]=$film->getVideo();
							$u++;
						}
					}
				}else{
					if($u<$nb || $nb==0){
						$films[]=$film->getVideo();
						$u++;
					}
				}
		}
		return $films;
    }
	
	public function getVideos($pro,$nb=0){
		$films1 = $this->getAllFilms($pro, $nb);
		$crit=new Criteria();

		$films = VideoPeer::doSelect($crit);

		foreach($films as $i => $film){
				$films2[]=$film->getId();
		}
		foreach($films1 as $i => $film){
			if(in_array($film->getId(),$films2)){
				$films3[]=$film;
			}
		}
		return $films3;
    }
	
	public function getFilms($pro,$nb=0){
		$films1 = $this->getAllFilms($pro, $nb);
		$crit=new Criteria();
		$crit->add(VideoPeer::TYPE,'film');

		$films = VideoPeer::doSelect($crit);

		foreach($films as $i => $film){
				$films2[]=$film->getId();
		}
		foreach($films1 as $i => $film){
			if(in_array($film->getId(),$films2)){
				$films3[]=$film;
			}
		}
		return $films3;
    }
	
	public function getSpectacles($pro,$nb=0){
		$films1 = $this->getAllFilms($pro);
		$crit=new Criteria();
		$crit->add(VideoPeer::TYPE,'spectacle');

		$films = VideoPeer::doSelect($crit);
		$films3 = Array();
		$films2 = Array();
		foreach($films as $i => $film){
				$films2[]=$film->getId();
		}
		foreach($films1 as $i => $film){
			if(in_array($film->getId(),$films2)){
				$films3[]=$film;
			}
		}
		return $films3;
    }
	
	 public function updateLuceneIndex()
	{
	  $index = CategoriePeer::getLuceneIndex();
	 
	  // remove existing entries
	  foreach ($index->find('pk:'.$this->getId()) as $hit)
	  {
		$index->delete($hit->id);
	  }
	 
	  $doc = new Zend_Search_Lucene_Document();
	 
	  // store job primary key to identify it in the search results
	  $doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getId()));
	 
	  // index job fields
	  $doc->addField(Zend_Search_Lucene_Field::UnStored('nom', VideoPeer::clean($this->getNom()), 'utf-8'));
	  

	 
	  // add job to the index
	  $index->addDocument($doc);
	  $index->commit();
	}
	
	
	
	public function setNom($v){
		$clean=VideoPeer::clean($v);
		$this->setNomClean($clean);
		return parent::setNom($v);
	}
	
  
} // Categorie
