<?php


/**
 * Skeleton subclass for representing a row from the 'utilisateur' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * 12/04/10 09:58:06
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Utilisateur extends BaseUtilisateur {
  public function __toString()
  {
    return sprintf('%s', $this->getPrenom().' '.$this->getNom());
  }

  public function resizeImage(){

      $file = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.'uploads/utilisateurs'.DIRECTORY_SEPARATOR.$this->getImage() ;
      $img = new sfImage($file,'image/jpg') ;
      $img->resize(160,213) ;
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
      if (file_exists(sfConfig::get('sf_upload_dir') . '/utilisateurs/'.$this->getImage())){
        @unlink(sfConfig::get('sf_upload_dir') . '/utilisateurs/'.$this->getImage());
      }
  }
} // Utilisateur
