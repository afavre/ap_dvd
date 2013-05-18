<?php

/**
 * Saison filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseSaisonFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'serie_id'            => new sfWidgetFormPropelChoice(array('model' => 'Serie', 'add_empty' => true)),
      'numero'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'realisateur_id'      => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => true)),
      'titre'               => new sfWidgetFormFilterInput(),
      'sous_titre'          => new sfWidgetFormFilterInput(),
      'titre_original'      => new sfWidgetFormFilterInput(),
      'titre_clean'         => new sfWidgetFormFilterInput(),
      'nb_episode_tot'      => new sfWidgetFormFilterInput(),
      'nb_episode_possede'  => new sfWidgetFormFilterInput(),
      'version_generale_id' => new sfWidgetFormPropelChoice(array('model' => 'Version', 'add_empty' => true)),
      'bande_annonce'       => new sfWidgetFormFilterInput(),
      'resume'              => new sfWidgetFormFilterInput(),
      'image'               => new sfWidgetFormFilterInput(),
      'annee_diffusion'     => new sfWidgetFormFilterInput(),
      'is_public'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'nb_visite'           => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'acteurserie_list'    => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => true)),
      'motscleserie_list'   => new sfWidgetFormPropelChoice(array('model' => 'Motscle', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'serie_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Serie', 'column' => 'id')),
      'numero'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'realisateur_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Personne', 'column' => 'id')),
      'titre'               => new sfValidatorPass(array('required' => false)),
      'sous_titre'          => new sfValidatorPass(array('required' => false)),
      'titre_original'      => new sfValidatorPass(array('required' => false)),
      'titre_clean'         => new sfValidatorPass(array('required' => false)),
      'nb_episode_tot'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nb_episode_possede'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'version_generale_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Version', 'column' => 'id')),
      'bande_annonce'       => new sfValidatorPass(array('required' => false)),
      'resume'              => new sfValidatorPass(array('required' => false)),
      'image'               => new sfValidatorPass(array('required' => false)),
      'annee_diffusion'     => new sfValidatorPass(array('required' => false)),
      'is_public'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'nb_visite'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'acteurserie_list'    => new sfValidatorPropelChoice(array('model' => 'Personne', 'required' => false)),
      'motscleserie_list'   => new sfValidatorPropelChoice(array('model' => 'Motscle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('saison_filters[%s]');

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

    $criteria->addJoin(ActeurseriePeer::SAISON_ID, SaisonPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(ActeurseriePeer::ACTEUR_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(ActeurseriePeer::ACTEUR_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function addMotscleserieListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(MotscleseriePeer::SAISON_ID, SaisonPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(MotscleseriePeer::MOTSCLE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(MotscleseriePeer::MOTSCLE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Saison';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'serie_id'            => 'ForeignKey',
      'numero'              => 'Number',
      'realisateur_id'      => 'ForeignKey',
      'titre'               => 'Text',
      'sous_titre'          => 'Text',
      'titre_original'      => 'Text',
      'titre_clean'         => 'Text',
      'nb_episode_tot'      => 'Number',
      'nb_episode_possede'  => 'Number',
      'version_generale_id' => 'ForeignKey',
      'bande_annonce'       => 'Text',
      'resume'              => 'Text',
      'image'               => 'Text',
      'annee_diffusion'     => 'Text',
      'is_public'           => 'Boolean',
      'nb_visite'           => 'Number',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'acteurserie_list'    => 'ManyKey',
      'motscleserie_list'   => 'ManyKey',
    );
  }
}
