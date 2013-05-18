<?php

/**
 * Categorieserie form base class.
 *
 * @method Categorieserie getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCategorieserieForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'categorie_id' => new sfWidgetFormInputHidden(),
      'serie_id'     => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'Categorieserie', 'column' => 'id', 'required' => false)),
      'categorie_id' => new sfValidatorPropelChoice(array('model' => 'Categorie', 'column' => 'id', 'required' => false)),
      'serie_id'     => new sfValidatorPropelChoice(array('model' => 'Serie', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categorieserie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Categorieserie';
  }


}
