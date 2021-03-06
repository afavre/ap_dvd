<?php

/**
 * Acteurserie filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseActeurserieFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('acteurserie_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Acteurserie';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'acteur_id'  => 'ForeignKey',
      'saison_id'  => 'ForeignKey',
      'created_at' => 'Date',
    );
  }
}
