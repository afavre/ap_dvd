<?php

/**
 * Serieproprietaire form base class.
 *
 * @method Serieproprietaire getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSerieproprietaireForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'serie_id'       => new sfWidgetFormInputHidden(),
      'utilisateur_id' => new sfWidgetFormInputHidden(),
      'note'           => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Serieproprietaire', 'column' => 'id', 'required' => false)),
      'serie_id'       => new sfValidatorPropelChoice(array('model' => 'Serie', 'column' => 'id', 'required' => false)),
      'utilisateur_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'note'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('serieproprietaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Serieproprietaire';
  }


}
