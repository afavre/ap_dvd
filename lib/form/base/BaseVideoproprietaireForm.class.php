<?php

/**
 * Videoproprietaire form base class.
 *
 * @method Videoproprietaire getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseVideoproprietaireForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'video_id'       => new sfWidgetFormInputHidden(),
      'utilisateur_id' => new sfWidgetFormInputHidden(),
      'note'           => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Videoproprietaire', 'column' => 'id', 'required' => false)),
      'video_id'       => new sfValidatorPropelChoice(array('model' => 'Video', 'column' => 'id', 'required' => false)),
      'utilisateur_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'note'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('videoproprietaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Videoproprietaire';
  }


}
