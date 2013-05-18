<?php

/**
 * Version filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseVersionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'nom' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('version_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Version';
  }

  public function getFields()
  {
    return array(
      'id'  => 'Number',
      'nom' => 'Text',
    );
  }
}
