<?php

/**
 * Model form base class.
 *
 * @method Model getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseModelForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id' => new sfValidatorPropelChoice(array('model' => 'Model', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('model[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Model';
  }


}
