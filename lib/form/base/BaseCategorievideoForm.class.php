<?php

/**
 * Categorievideo form base class.
 *
 * @method Categorievideo getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCategorievideoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'categorie_id' => new sfWidgetFormInputHidden(),
      'video_id'     => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'Categorievideo', 'column' => 'id', 'required' => false)),
      'categorie_id' => new sfValidatorPropelChoice(array('model' => 'Categorie', 'column' => 'id', 'required' => false)),
      'video_id'     => new sfValidatorPropelChoice(array('model' => 'Video', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categorievideo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Categorievideo';
  }


}
