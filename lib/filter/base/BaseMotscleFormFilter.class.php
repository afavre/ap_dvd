<?php

/**
 * Motscle filter form base class.
 *
 * @package    dvdtheque
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseMotscleFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'mot'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mot_clean'         => new sfWidgetFormFilterInput(),
      'motsclevideo_list' => new sfWidgetFormPropelChoice(array('model' => 'Video', 'add_empty' => true)),
      'motscleserie_list' => new sfWidgetFormPropelChoice(array('model' => 'Saison', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'mot'               => new sfValidatorPass(array('required' => false)),
      'mot_clean'         => new sfValidatorPass(array('required' => false)),
      'motsclevideo_list' => new sfValidatorPropelChoice(array('model' => 'Video', 'required' => false)),
      'motscleserie_list' => new sfValidatorPropelChoice(array('model' => 'Saison', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('motscle_filters[%s]');

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

    $criteria->addJoin(MotsclevideoPeer::MOTSCLE_ID, MotsclePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(MotsclevideoPeer::VIDEO_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(MotsclevideoPeer::VIDEO_ID, $value));
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

    $criteria->addJoin(MotscleseriePeer::MOTSCLE_ID, MotsclePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(MotscleseriePeer::SAISON_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(MotscleseriePeer::SAISON_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Motscle';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'mot'               => 'Text',
      'mot_clean'         => 'Text',
      'motsclevideo_list' => 'ManyKey',
      'motscleserie_list' => 'ManyKey',
    );
  }
}
