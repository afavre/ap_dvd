<?php

/**
 * Motscleserie form base class.
 *
 * @method Motscleserie getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMotscleserieForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'motscle_id' => new sfWidgetFormInputHidden(),
      'saison_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Motscleserie', 'column' => 'id', 'required' => false)),
      'motscle_id' => new sfValidatorPropelChoice(array('model' => 'Motscle', 'column' => 'id', 'required' => false)),
      'saison_id'  => new sfValidatorPropelChoice(array('model' => 'Saison', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('motscleserie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Motscleserie';
  }


}
