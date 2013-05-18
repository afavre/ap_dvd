<?php

/**
 * Version form base class.
 *
 * @method Version getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseVersionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'  => new sfWidgetFormInputHidden(),
      'nom' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'  => new sfValidatorPropelChoice(array('model' => 'Version', 'column' => 'id', 'required' => false)),
      'nom' => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Version', 'column' => array('nom')))
    );

    $this->widgetSchema->setNameFormat('version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Version';
  }


}
