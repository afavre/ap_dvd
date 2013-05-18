<?php

/**
 * Noteserie form base class.
 *
 * @method Noteserie getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNoteserieForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'saison_id'      => new sfWidgetFormPropelChoice(array('model' => 'Saison', 'add_empty' => false)),
      'utilisateur_id' => new sfWidgetFormPropelChoice(array('model' => 'Utilisateur', 'add_empty' => false)),
      'note'           => new sfWidgetFormInputText(),
      'message'        => new sfWidgetFormTextarea(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Noteserie', 'column' => 'id', 'required' => false)),
      'saison_id'      => new sfValidatorPropelChoice(array('model' => 'Saison', 'column' => 'id')),
      'utilisateur_id' => new sfValidatorPropelChoice(array('model' => 'Utilisateur', 'column' => 'id')),
      'note'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'message'        => new sfValidatorString(),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('noteserie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Noteserie';
  }


}
