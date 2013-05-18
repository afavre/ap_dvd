<?php

/**
 * Categorie filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseCategorieFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom_clean'           => new sfWidgetFormFilterInput(),
      'categorievideo_list' => new sfWidgetFormPropelChoice(array('model' => 'Video', 'add_empty' => true)),
      'categorieserie_list' => new sfWidgetFormPropelChoice(array('model' => 'Serie', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nom'                 => new sfValidatorPass(array('required' => false)),
      'nom_clean'           => new sfValidatorPass(array('required' => false)),
      'categorievideo_list' => new sfValidatorPropelChoice(array('model' => 'Video', 'required' => false)),
      'categorieserie_list' => new sfValidatorPropelChoice(array('model' => 'Serie', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categorie_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
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

    $criteria->addJoin(CategorievideoPeer::CATEGORIE_ID, CategoriePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(CategorievideoPeer::VIDEO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(CategorievideoPeer::VIDEO_ID, $value));
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

    $criteria->addJoin(CategorieseriePeer::CATEGORIE_ID, CategoriePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(CategorieseriePeer::SERIE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(CategorieseriePeer::SERIE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Categorie';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'nom'                 => 'Text',
      'nom_clean'           => 'Text',
      'categorievideo_list' => 'ManyKey',
      'categorieserie_list' => 'ManyKey',
    );
  }
}
