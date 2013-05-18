<?php

/**
 * Utilisateur form.
 *
 * @package    sitedvd
 * @subpackage form
 * @author     Your name here
 */
class UtilisateurForm extends BaseUtilisateurForm
{
  public function configure()
  {
    $this->widgetSchema['image'] = new sfWidgetFormInputFile(array(
   'label' => 'Image',
	));
   
   $this->validatorSchema['image'] = new sfValidatorFile(array(
   'required'   => false,
   'path'       => sfConfig::get('sf_upload_dir').'/utilisateurs',
   'mime_types' => 'web_images',
   ));

    $years = range(1900, 2010);
    $this->widgetSchema['date_naissance'] = new sfWidgetFormDate(array('years' => array_combine($years, $years))
      );
	//pour mettre la date dans l'ordre jj/mm/aaaa
	$this->widgetSchema['date_naissance']->setOption('format','%day%/%month%/%year%');
	
	
    $this->widgetSchema['pass'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['pass']->setOption('required', false);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['pass'];

    $this->widgetSchema->moveField('password_again', 'after', 'pass');

    $this->mergePostValidator(new sfValidatorSchemaCompare('pass', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));

   
   unset(
       $this['nb_visite'], $this['created_at'], $this['updated_at'],
           $this['serieproprietaire_list'], $this['filmproprietaire_list'], $this['nom_prenom_clean']
    );
  }
}
