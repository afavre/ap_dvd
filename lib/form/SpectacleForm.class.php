<?php

/**
 * Spectacle form.
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
class SpectacleForm extends BaseSpectacleForm
{
  public function configure()
  {
    $this->widgetSchema['image'] = new sfWidgetFormInputFile(array(
   'label' => 'Image',
	));
	
	$formatter = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema()); 
    $this->widgetSchema->addFormFormatter('div', $formatter);
    $this->widgetSchema->setFormFormatterName('div');
	$this->widgetSchema['titre'] = new sfWidgetFormInputTextPlus(array(
      'template'  => '%input%<span id="veriftitre"><img id="loader" src="/images/loader.gif" style="display: none" height="12" />
<img id="valide" src="/images/valide.png" style="display: none" height="12" /><img id="invalide" src="/images/invalide.png" style="display: none" height="12" /><span style="margin-left:5px;" id="textlientitre"></span></span><br />',
    ));
	$this->widgetSchema['titre']->setAttribute('size','60');
	$this->widgetSchema['titre_officiel']->setAttribute('size','60');
	$this->widgetSchema['extrait']->setAttribute('size','70');

	$this->widgetSchema['auteur_id']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => false,
	  'model' => 'Personne',
      'template'  => '%input%<div><a class="iframe" href="" onclick="$(this).attr(\'href\',$(\'#liennewauteur\').html());" >Nouvel Auteur</a></div>',
	));
	$this->widgetSchema['auteur_id']->setOption('order_by',array('Nom','ASC'));
	
	
	$this->widgetSchema['qualite_id']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => false,
	  'model' => 'qualite',
      'template'  => '%input%<div><a class="iframe1100_500" href="" onclick="$(this).attr(\'href\',$(\'#liennewqualite\').html());" >Nouvelle Qualite</a></div>',
	));
	$this->widgetSchema['qualite_id']->setOption('order_by',array('Nom','ASC'));
	
	$this->widgetSchema['spectacleproprietaire_list']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => true,
	  'label' => 'Propri&eacute;taire(s)',
	  'model' => 'sfGuardUser',
      'template'  => '%input%<div><a class="iframe" href="" onclick="$(this).attr(\'href\',$(\'#liennewproprietaire\').html());" >Nouveau Proprietaire (Administrateur)</a></div>',
	));
	$this->widgetSchema['spectacleproprietaire_list']->setOption('order_by',array('Username','ASC'));
	
	$this->widgetSchema['motsclespectacle_list']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => true,
	  'label' => 'Mot(s) cle(s)',
	  'model' => 'motscle',
      'template'  => '%input%<div><a class="iframe1100_400" href="" onclick="$(this).attr(\'href\',$(\'#liennewmotscle\').html());" >Nouveau Mot-cle</a></div>',
	));
	$this->widgetSchema['motsclespectacle_list']->setOption('order_by',array('Mot','ASC'));
	
	
	$this->widgetSchema['categoriespectacle_list']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => true,
	  'label' => 'Cat&eacute;gorie(s)',
	  'model' => 'Categorie',
      'template'  => '%input%<div><a class="iframe1100_400" href="" onclick="$(this).attr(\'href\',$(\'#liennewcategorie\').html());">Nouvelle Categorie</a></div>',
	));
	$this->widgetSchema['categoriespectacle_list']->setOption('order_by',array('Nom','ASC'));
	
	
	
	
	//$this->widgetSchema['titre']->setAttribute('onKeyUp','verifExisteFilm(this)');
	$this->widgetSchema['spectacleproprietaire_list']->setAttribute('class','multiselect');
	$this->widgetSchema['motsclespectacle_list']->setAttribute('class','multiselect');
	$this->widgetSchema['categoriespectacle_list']->setAttribute('class','multiselect'); 
	
	$this->widgetSchema['resume']->setAttribute('cols','60'); 
	$this->widgetSchema['resume']->setAttribute('rows','8');
	
	$this->widgetSchema['avertissement']->setAttribute('cols','60'); 
	$this->widgetSchema['avertissement']->setAttribute('rows','4');
	
	
  
   $this->validatorSchema['image'] = new sfValidatorFile(array(
   'required'   => false,
   'path'       => sfConfig::get('sf_upload_dir').'/spectacles',
   'mime_types' => 'web_images',
   ));

   
   unset(
       $this['nb_visite'], $this['created_at'], $this['updated_at'], $this['titre_clean']
    );
  }
}
