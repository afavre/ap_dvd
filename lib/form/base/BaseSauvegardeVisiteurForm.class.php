<?php

/**
 * SauvegardeVisiteur form base class.
 *
 * @method SauvegardeVisiteur getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSauvegardeVisiteurForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'nom'                 => new sfWidgetFormInputText(),
      'adresse'             => new sfWidgetFormInputText(),
      'derniere_connection' => new sfWidgetFormDateTime(),
      'proprio_id'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'SauvegardeVisiteur', 'column' => 'id', 'required' => false)),
      'nom'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse'             => new sfValidatorString(array('max_length' => 15)),
      'derniere_connection' => new sfValidatorDateTime(array('required' => false)),
      'proprio_id'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'SauvegardeVisiteur', 'column' => array('adresse')))
    );

    $this->widgetSchema->setNameFormat('sauvegarde_visiteur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SauvegardeVisiteur';
  }


}
