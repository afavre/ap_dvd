<?php

/**
 * SauvegardeVisiteur filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSauvegardeVisiteurFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'                 => new sfWidgetFormFilterInput(),
      'adresse'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'derniere_connection' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'proprio_id'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'nom'                 => new sfValidatorPass(array('required' => false)),
      'adresse'             => new sfValidatorPass(array('required' => false)),
      'derniere_connection' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'proprio_id'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('sauvegarde_visiteur_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SauvegardeVisiteur';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'nom'                 => 'Text',
      'adresse'             => 'Text',
      'derniere_connection' => 'Date',
      'proprio_id'          => 'Number',
    );
  }
}
