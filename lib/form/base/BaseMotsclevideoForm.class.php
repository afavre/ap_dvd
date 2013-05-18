<?php

/**
 * Motsclevideo form base class.
 *
 * @method Motsclevideo getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMotsclevideoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'motscle_id' => new sfWidgetFormInputHidden(),
      'video_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Motsclevideo', 'column' => 'id', 'required' => false)),
      'motscle_id' => new sfValidatorPropelChoice(array('model' => 'Motscle', 'column' => 'id', 'required' => false)),
      'video_id'   => new sfValidatorPropelChoice(array('model' => 'Video', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('motsclevideo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Motsclevideo';
  }


}
