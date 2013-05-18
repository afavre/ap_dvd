<?php

/**
 * Saison form.
 *
 * @package    sitedvd
 * @subpackage form
 * @author     Your name here
 */
class SaisonForm extends BaseSaisonForm
{
  public function configure()
  {
    $this->widgetSchema['image'] = new sfWidgetFormInputFile(array(
   'label' => 'Image',
	));
   
   $this->validatorSchema['image'] = new sfValidatorFile(array(
   'required'   => false,
   'path'       => sfConfig::get('sf_upload_dir').'/saisons',
   'mime_types' => 'web_images',
   ));
   
   
    $formatter = new sfWidgetFormSchemaFormatterDiv($this->getWidgetSchema()); 
    $this->widgetSchema->addFormFormatter('div', $formatter);
    $this->widgetSchema->setFormFormatterName('div');
	$this->widgetSchema['titre'] = new sfWidgetFormInputTextPlus(array(
      'template'  => '%input%<span id="veriftitre"><img id="loader" src="/images/loader.gif" style="display: none" height="12" />
<img id="valide" src="/images/valide.png" style="display: none" height="12" /><img id="invalide" src="/images/invalide.png" style="display: none" height="12" /><span style="margin-left:5px;" id="textlientitre"></span></span><br />',
    ));
	$this->widgetSchema['titre']->setAttribute('size','60');
	$this->widgetSchema['sous_titre']->setAttribute('size','60');
	$this->widgetSchema['titre_original']->setAttribute('size','60');
	$this->widgetSchema['bande_annonce']->setAttribute('size','70');

	$this->widgetSchema['realisateur_id']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => false,
	  'model' => 'Personne',
      'template'  => '%input%<div><a class="iframe" href="" onclick="$(this).attr(\'href\',$(\'#liennewpersonne\').html());" >Nouveau Realisateur</a></div>',
	));
	$this->widgetSchema['realisateur_id']->setOption('order_by',array('Nom','ASC'));
	
	for($i=1;$i<=10;$i++){
		$numero[$i]=$i;
	}
	$this->widgetSchema['numero']=new sfWidgetFormSelect(array(
	  'choices' => $numero,
    ));
	
	$nbep[0]='en cours';
	for($i=1;$i<=30;$i++){
		$nbep[$i]=$i;
	}
	$this->widgetSchema['nb_episode_tot']=new sfWidgetFormSelect(array(
	  'choices' => $nbep,
	  'label' => "Nb d'&eacute;pisodes total",
    ));
	
	
	$this->widgetSchema['serie_id']->setAttribute('onChange','RealSerie(this);return false;');
	
		$this->widgetSchema['serie_id']->setOption('order_by',array('Titre','ASC'));
	
	
		$this->widgetSchema['acteurserie_list']=new sfWidgetFormPropelChoicePlus(array(
		  'multiple' => true,
		  'label' => 'Acteur(s)',
		  'model' => 'Personne',
		  'template'  => '%input%<div><a class="iframe" href="" onclick="$(this).attr(\'href\',$(\'#liennewpersonne\').html());" >Nouvel Acteur</a></div>',
		));
		$this->widgetSchema['acteurserie_list']->setOption('order_by',array('Nom','ASC'));
		$this->widgetSchema['acteurserie_list']->setAttribute('class','multiselect');
	
	
	
	$this->widgetSchema['resume']->setAttribute('cols','60'); 
	$this->widgetSchema['resume']->setAttribute('rows','8');
	
   

   
   unset(
       $this['nb_visite'], $this['created_at'], $this['updated_at'], $this['titre_clean'], $this['categorieserie_list'], $this['motscleserie_list'], $this['categorieserie_list'], $this['nb_episode_possede']
    );
  }
  
  
  public function saveActeurserieList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['acteurserie_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ActeurseriePeer::SAISON_ID, $this->object->getPrimaryKey());
	
    ActeurseriePeer::doDelete($c, $con);

    $values = $_REQUEST['acteur_ordre'];
	$valuesTab = split('[/]', $values);
	$taille=sizeof($valuesTab)-1;
	
    $values2 = $this->getValue('serieproprietaire_list');
	//echo sizeof($values2).' '.$taille.' '.$values;
    if (is_array($valuesTab))
    {
      foreach ($valuesTab as $value)
      {
		if($value){
			$obj = new Acteurserie();
			$obj->setSaisonId($this->object->getPrimaryKey());
			$obj->setActeurId($value);
			$obj->save();
		}
      }
    }
  }
  
}
