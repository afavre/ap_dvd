<?php

/**
 * Commentaireacteur form base class.
 *
 * @method Commentaireacteur getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCommentaireacteurForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'acteur_id'      => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => false)),
      'utilisateur_id' => new sfWidgetFormPropelChoice(array('model' => 'Utilisateur', 'add_empty' => false)),
      'message'        => new sfWidgetFormTextarea(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Commentaireacteur', 'column' => 'id', 'required' => false)),
      'acteur_id'      => new sfValidatorPropelChoice(array('model' => 'Personne', 'column' => 'id')),
      'utilisateur_id' => new sfValidatorPropelChoice(array('model' => 'Utilisateur', 'column' => 'id')),
      'message'        => new sfValidatorString(),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commentaireacteur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commentaireacteur';
  }


}
