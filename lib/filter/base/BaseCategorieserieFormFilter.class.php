<?php

/**
 * Categorieserie filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseCategorieserieFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('categorieserie_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Categorieserie';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'categorie_id' => 'ForeignKey',
      'serie_id'     => 'ForeignKey',
    );
  }
}
