<?php

/**
 * Noteserie filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseNoteserieFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'saison_id'      => new sfWidgetFormPropelChoice(array('model' => 'Saison', 'add_empty' => true)),
      'utilisateur_id' => new sfWidgetFormPropelChoice(array('model' => 'Utilisateur', 'add_empty' => true)),
      'note'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'message'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'saison_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Saison', 'column' => 'id')),
      'utilisateur_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Utilisateur', 'column' => 'id')),
      'note'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'message'        => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('noteserie_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Noteserie';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'saison_id'      => 'ForeignKey',
      'utilisateur_id' => 'ForeignKey',
      'note'           => 'Number',
      'message'        => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
