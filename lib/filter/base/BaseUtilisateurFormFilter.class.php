<?php

/**
 * Utilisateur filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUtilisateurFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'              => new sfWidgetFormFilterInput(),
      'prenom'           => new sfWidgetFormFilterInput(),
      'nom_prenom_clean' => new sfWidgetFormFilterInput(),
      'image'            => new sfWidgetFormFilterInput(),
      'login'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pass'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_naissance'   => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'nom'              => new sfValidatorPass(array('required' => false)),
      'prenom'           => new sfValidatorPass(array('required' => false)),
      'nom_prenom_clean' => new sfValidatorPass(array('required' => false)),
      'image'            => new sfValidatorPass(array('required' => false)),
      'login'            => new sfValidatorPass(array('required' => false)),
      'pass'             => new sfValidatorPass(array('required' => false)),
      'date_naissance'   => new sfValidatorPass(array('required' => false)),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('utilisateur_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Utilisateur';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'nom'              => 'Text',
      'prenom'           => 'Text',
      'nom_prenom_clean' => 'Text',
      'image'            => 'Text',
      'login'            => 'Text',
      'pass'             => 'Text',
      'date_naissance'   => 'Text',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
