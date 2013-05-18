<?php

/**
 * AnotherModel form base class.
 *
 * @method AnotherModel getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAnotherModelForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id' => new sfValidatorPropelChoice(array('model' => 'AnotherModel', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('another_model[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AnotherModel';
  }


}
