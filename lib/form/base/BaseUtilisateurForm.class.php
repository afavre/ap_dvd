<?php

/**
 * Utilisateur form base class.
 *
 * @method Utilisateur getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUtilisateurForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'nom'              => new sfWidgetFormInputText(),
      'prenom'           => new sfWidgetFormInputText(),
      'nom_prenom_clean' => new sfWidgetFormInputText(),
      'image'            => new sfWidgetFormInputText(),
      'login'            => new sfWidgetFormInputText(),
      'pass'             => new sfWidgetFormInputText(),
      'date_naissance'   => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Utilisateur', 'column' => 'id', 'required' => false)),
      'nom'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'prenom'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'nom_prenom_clean' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'image'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'login'            => new sfValidatorString(array('max_length' => 255)),
      'pass'             => new sfValidatorString(array('max_length' => 255)),
      'date_naissance'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('utilisateur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Utilisateur';
  }


}
