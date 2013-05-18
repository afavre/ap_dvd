<?php

/**
 * Nationalite filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseNationaliteFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'pays' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'pays' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nationalite_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nationalite';
  }

  public function getFields()
  {
    return array(
      'id'   => 'Number',
      'pays' => 'Text',
    );
  }
}
