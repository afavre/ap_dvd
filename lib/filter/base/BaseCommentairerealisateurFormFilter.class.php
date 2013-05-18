<?php

/**
 * Commentairerealisateur filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseCommentairerealisateurFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'realisateur_id' => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => true)),
      'utilisateur_id' => new sfWidgetFormPropelChoice(array('model' => 'Utilisateur', 'add_empty' => true)),
      'message'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'realisateur_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Personne', 'column' => 'id')),
      'utilisateur_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Utilisateur', 'column' => 'id')),
      'message'        => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('commentairerealisateur_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commentairerealisateur';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'realisateur_id' => 'ForeignKey',
      'utilisateur_id' => 'ForeignKey',
      'message'        => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
