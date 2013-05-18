<?php

/**
 * Categorievideo filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseCategorievideoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('categorievideo_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Categorievideo';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'categorie_id' => 'ForeignKey',
      'video_id'     => 'ForeignKey',
    );
  }
}
