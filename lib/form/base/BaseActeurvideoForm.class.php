<?php

/**
 * Acteurvideo form base class.
 *
 * @method Acteurvideo getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseActeurvideoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'acteur_id'  => new sfWidgetFormInputHidden(),
      'video_id'   => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Acteurvideo', 'column' => 'id', 'required' => false)),
      'acteur_id'  => new sfValidatorPropelChoice(array('model' => 'Personne', 'column' => 'id', 'required' => false)),
      'video_id'   => new sfValidatorPropelChoice(array('model' => 'Video', 'column' => 'id', 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('acteurvideo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Acteurvideo';
  }


}
