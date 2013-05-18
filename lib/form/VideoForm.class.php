<?php

/**
 * Video form.
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
class VideoForm extends BaseVideoForm
{
  public function configure()
  {
	$frontend=false;
	if((isset($_REQUEST['type']) && !$_REQUEST['type']) || !isset($_REQUEST['type'])){
		if($this->getObject()->getType()){
			$type=$this->getObject()->getType();
		}else{
			$type='film';
		}
	}else{
		$type = $_REQUEST['type'];
	}
	
	
	
	$formatter = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema()); 
    $this->widgetSchema->addFormFormatter('div', $formatter);
    $this->widgetSchema->setFormFormatterName('div');
	
	$this->widgetSchema['titre'] = new sfWidgetFormInputTextPlus(array(
		  'template'  => '%input%<span id="veriftitre"><img id="loader_verif" src="/images/loader.gif" style="display: none" height="12" />
		<img id="valide" src="/images/valide.png" style="display: none" height="12" /><img id="invalide" src="/images/invalide.png" style="display: none" height="12" /><span style="margin-left:5px;" id="textlientitre"></span></span><br />',
	));
	$this->widgetSchema['titre']->setAttribute('size','60');
	//FRONTEND
	$this->widgetSchema['titre']->setAttribute('size','46');
	$this->widgetSchema['version_id']->setAttribute('style','width:80px;');
	$this->widgetSchema['qualite_id']->setAttribute('style','width:65px;');
	//
	$this->widgetSchema['sous_titre']->setAttribute('size','60');
	$this->widgetSchema['titre_original']->setAttribute('size','60');
	$this->widgetSchema['bande_annonce']->setAttribute('size','70');

	
	
	//FRONTEND
	$this->widgetSchema['realisateur_id'] = new sfWidgetFormInputHidden();
	//

		$this->widgetSchema['version_id']->setOption('order_by',array('Nom','ASC'));
		$this->setDefault('version_id', 1);
		
		$this->widgetSchema['qualite_id']->setOption('order_by',array('Id','ASC'));
	
	
	$this->widgetSchema['videoproprietaire_list']->setOption('order_by',array('Username','ASC'));
	
	$this->widgetSchema['motsclevideo_list']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => true,
	  'label' => 'Mot(s) cle(s)',
	  'model' => 'motscle',
      'template'  => '%input%<div><a class="iframe1100_500" href="" onclick="$(this).attr(\'href\',$(\'#liennewmotscle\').html());" >Nouveau Mot-cle</a></div>',
	));
	$this->widgetSchema['motsclevideo_list']->setOption('order_by',array('Mot','ASC'));
	
	
	$this->widgetSchema['categorievideo_list']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => true,
	  'label' => 'Cat&eacute;gorie(s)',
	  'model' => 'Categorie',
      'template'  => '%input%<div><a class="iframe1100_400" href="" onclick="$(this).attr(\'href\',$(\'#liennewcategorie\').html());">Nouvelle Categorie</a></div>',
	));
	$this->widgetSchema['categorievideo_list']->setOption('order_by',array('Nom','ASC'));
	
	$this->widgetSchema['videoproprietaire_list']->setAttribute('class','multiselect');
	$this->widgetSchema['motsclevideo_list']->setAttribute('class','multiselect');
	$this->widgetSchema['categorievideo_list']->setAttribute('class','multiselect'); 
	
	$this->widgetSchema['resume']->setAttribute('cols','60'); 
	$this->widgetSchema['resume']->setAttribute('rows','8');
	
	$this->widgetSchema['avertissement']->setAttribute('cols','60'); 
	$this->widgetSchema['avertissement']->setAttribute('rows','4');
	
		$this->widgetSchema['image'] = new sfWidgetFormInputFile(array(
	   'label' => 'Image',
		));
	
	$this->validatorSchema['image'] = new sfValidatorFile(array(
		'required'   => false,
		'path'       => sfConfig::get('sf_upload_dir').'/videos',
		'mime_types' => 'web_images',
	));
	
	$this->validatorSchema['type']=new sfValidatorChoice(array(
	  'choices' => array('film','spectacle','episode'),
    ));
	$this->widgetSchema['type']->setAttribute('value', $type);
   if($type=="film"){
		$this->widgetSchema['titre']->setAttribute('onKeyUp','verifExisteFilm(this);return false;');
		$this->widgetSchema['saga_id']=new sfWidgetFormPropelChoicePlus(array(
		  'multiple' => false,
		  'model' => 'saga',
		  'template'  => '%input%<div><a class="iframe1100_500" href="" onclick="$(this).attr(\'href\',$(\'#liennewsaga\').html());">Nouvelle Saga</a></div>',
		  'add_empty' => true,
		));
		$this->widgetSchema['saga_id']->setOption('order_by',array('Titre','ASC'));
		$this->widgetSchema['acteurvideo_list']=new sfWidgetFormPropelChoicePlus(array(
			  'multiple' => true,
			  'label' => 'Acteur(s)',
			  'model' => 'Personne',
			  'template'  => '%input%<div><a class="iframe" href="" onclick="$(this).attr(\'href\',$(\'#liennewpersonne\').html());" >Nouvel Acteur</a></div>',
		));
		$this->widgetSchema['acteurvideo_list']->setOption('order_by',array('Nom','ASC'));
		$this->widgetSchema['acteurvideo_list']->setAttribute('class','multiselect');
	   unset(
		   $this['is_public'], $this['nb_visite'], $this['created_at'], $this['updated_at'], $this['titre_clean'], $this['saison_id'], $this['numero']
		);
   }else if($type=="spectacle"){
		$this->widgetSchema['titre']->setAttribute('onKeyUp','verifExisteFilm(this);return false;');
		$this->widgetSchema['bande_annonce']->setOption('label','Extrait');
		$this->widgetSchema['realisateur_id']->setOption('label','Auteur');
	   unset(
		   $this['is_public'], $this['nb_visite'], $this['created_at'], $this['updated_at'], $this['titre_clean'], $this['saison_id'], $this['numero'], $this['version_id'], $this['saga_id'], $this['acteurvideo_list']
		);
   }else if($type=="episode"){
		//FRONTEND
		$this->widgetSchema['saison_id'] = new sfWidgetFormInputHidden();
		$this->widgetSchema['numero'] = new sfWidgetFormInputHidden();
		//
	   unset(
		   $this['is_public'], $this['nb_visite'], $this['nb_visite'], $this['created_at'], $this['updated_at'], $this['titre_clean'], $this['saga_id'], $this['acteurvideo_list'], $this['resume'], $this['avertissement'], $this['sous_titre'], $this['titre_original'], $this['bande_annonce'], $this['annee_sortie'], $this['duree'], $this['motsclevideo_list'], $this['categorievideo_list']
		);
   }
  }
  
  
  
  
  public function saveVideoproprietaireList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['videoproprietaire_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(VideoproprietairePeer::VIDEO_ID, $this->object->getPrimaryKey());
    $videoProprios = VideoproprietairePeer::doSelect($c, $con);
	foreach($videoProprios as $vp){
		$tab[$vp->getUtilisateurId()] = $vp->getCreatedAt();
	}
    VideoproprietairePeer::doDelete($c, $con);
	
    $values = $this->getValue('videoproprietaire_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Videoproprietaire();
        $obj->setVideoId($this->object->getPrimaryKey());
        $obj->setUtilisateurId($value);
		if($tab[$value]){
			$obj->setCreatedAt($tab[$value]);
		}
        $obj->save();
      }
    }
  }
  
  
  public function saveActeurvideoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['acteurvideo_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ActeurvideoPeer::VIDEO_ID, $this->object->getPrimaryKey());
	
    ActeurvideoPeer::doDelete($c, $con);

    $values = $_REQUEST['acteur_ordre'];
	$valuesTab = split('[/]', $values);
	$taille=sizeof($valuesTab)-1;
	
    $values2 = $this->getValue('videoproprietaire_list');
	//echo sizeof($values2).' '.$taille.' '.$values;
    if (is_array($valuesTab))
    {
      foreach ($valuesTab as $value)
      {
		if($value){
			$obj = new Acteurvideo();
			$obj->setVideoId($this->object->getPrimaryKey());
			$obj->setActeurId($value);
			$obj->save();
		}
      }
    }
  }
  
}
