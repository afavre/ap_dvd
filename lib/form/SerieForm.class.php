<?php

/**
 * Serie form.
 *
 * @package    sitedvd
 * @subpackage form
 * @author     Your name here
 */
class SerieForm extends BaseSerieForm
{
  public function configure()
  {
    $this->widgetSchema['image'] = new sfWidgetFormInputFile(array(
   'label' => 'Image',
	));
   
   $this->validatorSchema['image'] = new sfValidatorFile(array(
   'required'   => false,
   'path'       => sfConfig::get('sf_upload_dir').'/series',
   'mime_types' => 'web_images',
   ));
	$this->widgetSchema['bande_annonce']->setAttribute('size','70');
	
	$this->widgetSchema['titre']->setAttribute('size','60');
	$this->widgetSchema['sous_titre']->setAttribute('size','60');
	$this->widgetSchema['titre_original']->setAttribute('size','60');
   
	$this->widgetSchema['resume']->setAttribute('cols','60'); 
	$this->widgetSchema['resume']->setAttribute('rows','8');
   
	$this->widgetSchema['categorieserie_list']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => true,
	  'label' => 'Cat&eacute;gorie(s)',
	  'model' => 'Categorie',
      'template'  => '%input%<div><a class="iframe1100_400" href="" onclick="$(this).attr(\'href\',$(\'#liennewcategorie\').html());">Nouvelle Categorie</a></div>',
	));
   
	$this->widgetSchema['categorieserie_list']->setAttribute('class','multiselect');

	
	$this->widgetSchema['realisateur_id']=new sfWidgetFormPropelChoicePlus(array(
	  'multiple' => false,
	  'model' => 'Personne',
      'template'  => '%input%<div><a class="iframe" href="" onclick="$(this).attr(\'href\',$(\'#liennewpersonne\').html());" >Nouveau Realisateur</a></div>',
	));
		$this->widgetSchema['realisateur_id']->setOption('order_by',array('Nom','ASC'));
   
   unset(
       $this['nb_visite'], $this['created_at'], $this['updated_at'], $this['titre_clean'], $this['serieproprietaire_list']
    );
  }
}
