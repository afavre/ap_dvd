<?php

/**
 * Motscleserie filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseMotscleserieFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('motscleserie_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Motscleserie';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'motscle_id' => 'ForeignKey',
      'saison_id'  => 'ForeignKey',
    );
  }
}
