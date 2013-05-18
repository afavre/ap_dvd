<?php

/**
 * Personne filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePersonneFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'prenom'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom_prenom_clean' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'image'            => new sfWidgetFormFilterInput(),
      'date_naissance'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_deces'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'nb_visite'        => new sfWidgetFormFilterInput(),
      'nationalite_id'   => new sfWidgetFormPropelChoice(array('model' => 'Nationalite', 'add_empty' => true)),
      'acteurserie_list' => new sfWidgetFormPropelChoice(array('model' => 'Saison', 'add_empty' => true)),
      'acteurvideo_list' => new sfWidgetFormPropelChoice(array('model' => 'Video', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nom'              => new sfValidatorPass(array('required' => false)),
      'prenom'           => new sfValidatorPass(array('required' => false)),
      'nom_prenom_clean' => new sfValidatorPass(array('required' => false)),
      'image'            => new sfValidatorPass(array('required' => false)),
      'date_naissance'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'date_deces'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'nb_visite'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nationalite_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Nationalite', 'column' => 'id')),
      'acteurserie_list' => new sfValidatorPropelChoice(array('model' => 'Saison', 'required' => false)),
      'acteurvideo_list' => new sfValidatorPropelChoice(array('model' => 'Video', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('personne_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addActeurserieListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ActeurseriePeer::ACTEUR_ID, PersonnePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ActeurseriePeer::SAISON_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ActeurseriePeer::SAISON_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addActeurvideoListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(ActeurvideoPeer::ACTEUR_ID, PersonnePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ActeurvideoPeer::VIDEO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ActeurvideoPeer::VIDEO_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Personne';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'nom'              => 'Text',
      'prenom'           => 'Text',
      'nom_prenom_clean' => 'Text',
      'image'            => 'Text',
      'date_naissance'   => 'Date',
      'date_deces'       => 'Date',
      'nb_visite'        => 'Number',
      'nationalite_id'   => 'ForeignKey',
      'acteurserie_list' => 'ManyKey',
      'acteurvideo_list' => 'ManyKey',
    );
  }
}
