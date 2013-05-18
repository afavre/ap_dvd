<?php

/**
 * Serie filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSerieFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'realisateur_id'         => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => true)),
      'titre'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sous_titre'             => new sfWidgetFormFilterInput(),
      'titre_original'         => new sfWidgetFormFilterInput(),
      'titre_clean'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'bande_annonce'          => new sfWidgetFormFilterInput(),
      'image'                  => new sfWidgetFormFilterInput(),
      'resume'                 => new sfWidgetFormFilterInput(),
      'annee_diffusion'        => new sfWidgetFormFilterInput(),
      'format_duree'           => new sfWidgetFormFilterInput(),
      'is_public'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'nb_visite'              => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'serieproprietaire_list' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'categorieserie_list'    => new sfWidgetFormPropelChoice(array('model' => 'Categorie', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'realisateur_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Personne', 'column' => 'id')),
      'titre'                  => new sfValidatorPass(array('required' => false)),
      'sous_titre'             => new sfValidatorPass(array('required' => false)),
      'titre_original'         => new sfValidatorPass(array('required' => false)),
      'titre_clean'            => new sfValidatorPass(array('required' => false)),
      'bande_annonce'          => new sfValidatorPass(array('required' => false)),
      'image'                  => new sfValidatorPass(array('required' => false)),
      'resume'                 => new sfValidatorPass(array('required' => false)),
      'annee_diffusion'        => new sfValidatorPass(array('required' => false)),
      'format_duree'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_public'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'nb_visite'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'serieproprietaire_list' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'categorieserie_list'    => new sfValidatorPropelChoice(array('model' => 'Categorie', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('serie_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addSerieproprietaireListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(SerieproprietairePeer::SERIE_ID, SeriePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(SerieproprietairePeer::UTILISATEUR_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(SerieproprietairePeer::UTILISATEUR_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addCategorieserieListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(CategorieseriePeer::SERIE_ID, SeriePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(CategorieseriePeer::CATEGORIE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(CategorieseriePeer::CATEGORIE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Serie';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'realisateur_id'         => 'ForeignKey',
      'titre'                  => 'Text',
      'sous_titre'             => 'Text',
      'titre_original'         => 'Text',
      'titre_clean'            => 'Text',
      'bande_annonce'          => 'Text',
      'image'                  => 'Text',
      'resume'                 => 'Text',
      'annee_diffusion'        => 'Text',
      'format_duree'           => 'Number',
      'is_public'              => 'Boolean',
      'nb_visite'              => 'Number',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'serieproprietaire_list' => 'ManyKey',
      'categorieserie_list'    => 'ManyKey',
    );
  }
}
