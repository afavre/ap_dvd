<?php

/**
 * Motsclevideo filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseMotsclevideoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('motsclevideo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Motsclevideo';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'motscle_id' => 'ForeignKey',
      'video_id'   => 'ForeignKey',
    );
  }
}
