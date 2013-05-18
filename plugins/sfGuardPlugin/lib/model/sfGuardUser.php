<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUser.php 7634 2008-02-27 18:01:40Z fabien $
 */
class sfGuardUser extends PluginsfGuardUser
{
  public function __toString()
  {
	if($this->getPrenom()!='' || $this->getNom()!=''){
		return sprintf('%s', $this->getPrenom().' '.$this->getNom());
	}else{
		return sprintf('%s', $this->getUsername());
	}
  }

  public function resizeImage(){

      $file = sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'admins'.DIRECTORY_SEPARATOR.$this->getImage() ;
      $img = new sfImage($file,'image/jpg') ;
      $img->resizeProp(160,213) ;
      $img->saveas($file);
      }

   public function save(PropelPDO $con = null)
  {
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
      if (file_exists(sfConfig::get('sf_upload_dir') . '/admin/'.$this->getImage())){
        @unlink(sfConfig::get('sf_upload_dir') . '/admin/'.$this->getImage());
      }
  }
  
  public function possede($film){
		$bool=false;
		foreach($film->getProprietaires() as $pro){
			if($pro->getId()==$this->getId()){
				$bool=true;
			}
		}
		return $bool;
  }
  
  public function possedeAllFilmSaga($saga){
		$bool=true;
		foreach($saga->getFilms() as $film){
			if(!$this->possede($film) && $bool){
				$bool=false;
			}
		}
		return $bool;
  }
  
  public function possedeSaison($saison){
		$bool=false;
		foreach($saison->getProprietaires() as $pro){
			if($pro->getId()==$this->getId()){
				$bool=true;
			}
		}
		return $bool;
  }
  
  public function possedeSpectacle($spectacle){
		$bool=false;
		foreach($spectacle->getProprietaires() as $pro){
			if($pro->getId()==$this->getId()){
				$bool=true;
			}
		}
		return $bool;
  }
  

}
