<?php

/**
 * Video filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseVideoFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'saison_id'              => new sfWidgetFormPropelChoice(array('model' => 'Saison', 'add_empty' => true)),
      'numero'                 => new sfWidgetFormFilterInput(),
      'saga_id'                => new sfWidgetFormPropelChoice(array('model' => 'Saga', 'add_empty' => true)),
      'realisateur_id'         => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => true)),
      'titre'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sous_titre'             => new sfWidgetFormFilterInput(),
      'titre_original'         => new sfWidgetFormFilterInput(),
      'titre_clean'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'avertissement'          => new sfWidgetFormFilterInput(),
      'resume'                 => new sfWidgetFormFilterInput(),
      'image'                  => new sfWidgetFormFilterInput(),
      'bande_annonce'          => new sfWidgetFormFilterInput(),
      'annee_sortie'           => new sfWidgetFormFilterInput(),
      'duree'                  => new sfWidgetFormFilterInput(),
      'qualite_id'             => new sfWidgetFormPropelChoice(array('model' => 'Qualite', 'add_empty' => true)),
      'version_id'             => new sfWidgetFormPropelChoice(array('model' => 'Version', 'add_empty' => true)),
      'nb_visite'              => new sfWidgetFormFilterInput(),
      'is_public'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'motsclevideo_list'      => new sfWidgetFormPropelChoice(array('model' => 'Motscle', 'add_empty' => true)),
      'acteurvideo_list'       => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => true)),
      'videoproprietaire_list' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'categorievideo_list'    => new sfWidgetFormPropelChoice(array('model' => 'Categorie', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'saison_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Saison', 'column' => 'id')),
      'numero'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'saga_id'                => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Saga', 'column' => 'id')),
      'realisateur_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Personne', 'column' => 'id')),
      'titre'                  => new sfValidatorPass(array('required' => false)),
      'sous_titre'             => new sfValidatorPass(array('required' => false)),
      'titre_original'         => new sfValidatorPass(array('required' => false)),
      'titre_clean'            => new sfValidatorPass(array('required' => false)),
      'avertissement'          => new sfValidatorPass(array('required' => false)),
      'resume'                 => new sfValidatorPass(array('required' => false)),
      'image'                  => new sfValidatorPass(array('required' => false)),
      'bande_annonce'          => new sfValidatorPass(array('required' => false)),
      'annee_sortie'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'duree'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'qualite_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Qualite', 'column' => 'id')),
      'version_id'             => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Version', 'column' => 'id')),
      'nb_visite'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_public'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'motsclevideo_list'      => new sfValidatorPropelChoice(array('model' => 'Motscle', 'required' => false)),
      'acteurvideo_list'       => new sfValidatorPropelChoice(array('model' => 'Personne', 'required' => false)),
      'videoproprietaire_list' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'categorievideo_list'    => new sfValidatorPropelChoice(array('model' => 'Categorie', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('video_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addMotsclevideoListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(MotsclevideoPeer::VIDEO_ID, VideoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(MotsclevideoPeer::MOTSCLE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(MotsclevideoPeer::MOTSCLE_ID, $value));
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

    $criteria->addJoin(ActeurvideoPeer::VIDEO_ID, VideoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ActeurvideoPeer::ACTEUR_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ActeurvideoPeer::ACTEUR_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addVideoproprietaireListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(VideoproprietairePeer::VIDEO_ID, VideoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(VideoproprietairePeer::UTILISATEUR_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(VideoproprietairePeer::UTILISATEUR_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addCategorievideoListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(CategorievideoPeer::VIDEO_ID, VideoPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(CategorievideoPeer::CATEGORIE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(CategorievideoPeer::CATEGORIE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Video';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'type'                   => 'Text',
      'saison_id'              => 'ForeignKey',
      'numero'                 => 'Number',
      'saga_id'                => 'ForeignKey',
      'realisateur_id'         => 'ForeignKey',
      'titre'                  => 'Text',
      'sous_titre'             => 'Text',
      'titre_original'         => 'Text',
      'titre_clean'            => 'Text',
      'avertissement'          => 'Text',
      'resume'                 => 'Text',
      'image'                  => 'Text',
      'bande_annonce'          => 'Text',
      'annee_sortie'           => 'Number',
      'duree'                  => 'Number',
      'qualite_id'             => 'ForeignKey',
      'version_id'             => 'ForeignKey',
      'nb_visite'              => 'Number',
      'is_public'              => 'Boolean',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'motsclevideo_list'      => 'ManyKey',
      'acteurvideo_list'       => 'ManyKey',
      'videoproprietaire_list' => 'ManyKey',
      'categorievideo_list'    => 'ManyKey',
    );
  }
}
