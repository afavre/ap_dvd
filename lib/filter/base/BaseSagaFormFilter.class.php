<?php

/**
 * Saga filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSagaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'titre' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'titre' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('saga_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Saga';
  }

  public function getFields()
  {
    return array(
      'id'    => 'Number',
      'titre' => 'Text',
    );
  }
}
