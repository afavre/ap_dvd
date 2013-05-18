<?php

/**
 * Personne form.
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
class PersonneForm extends BasePersonneForm
{
 public function configure()
  {
  $this->widgetSchema['image'] = new sfWidgetFormInputFile(array(
   'label' => 'Image',
        ));

   $this->validatorSchema['image'] = new sfValidatorFile(array(
   'required'   => false,
   'path'       => sfConfig::get('sf_upload_dir').'/personnes',
   'mime_types' => 'web_images',
   ));
   $years = range(1880, 2010);
   $years2 = range(1960, 2011);
   $this->widgetSchema['date_naissance'] = new sfWidgetFormDate(array('years' => array_combine($years, $years)));
   $this->widgetSchema['date_deces'] = new sfWidgetFormDate(array('years' => array_combine($years2, $years2)));

        $this->widgetSchema['nationalite_id']->setOption('order_by',array('Pays','ASC'));
 //pour mettre la date dans l'ordre jj/mm/aaaa
        $this->widgetSchema['date_naissance']->setOption('format','%day%/%month%/%year%');
        $this->widgetSchema['date_deces']->setOption('format','%day%/%month%/%year%');


   unset(
       $this['nb_visite'], $this['created_at'], $this['updated_at']
           ,$this['acteurserie_list'], $this['acteurvideo_list'], $this['nom_prenom_clean']

    );
  }
}

