<?php

/**
 * Acteurserie form base class.
 *
 * @method Acteurserie getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseActeurserieForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'acteur_id'  => new sfWidgetFormInputHidden(),
      'saison_id'  => new sfWidgetFormInputHidden(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Acteurserie', 'column' => 'id', 'required' => false)),
      'acteur_id'  => new sfValidatorPropelChoice(array('model' => 'Personne', 'column' => 'id', 'required' => false)),
      'saison_id'  => new sfValidatorPropelChoice(array('model' => 'Saison', 'column' => 'id', 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('acteurserie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Acteurserie';
  }


}
