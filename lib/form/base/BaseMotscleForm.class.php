<?php

/**
 * Motscle form base class.
 *
 * @method Motscle getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMotscleForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'mot'               => new sfWidgetFormInputText(),
      'mot_clean'         => new sfWidgetFormInputText(),
      'motsclevideo_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Video')),
      'motscleserie_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Saison')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'Motscle', 'column' => 'id', 'required' => false)),
      'mot'               => new sfValidatorString(array('max_length' => 255)),
      'mot_clean'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'motsclevideo_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Video', 'required' => false)),
      'motscleserie_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Saison', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Motscle', 'column' => array('mot')))
    );

    $this->widgetSchema->setNameFormat('motscle[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Motscle';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['motsclevideo_list']))
    {
      $values = array();
      foreach ($this->object->getMotsclevideos() as $obj)
      {
        $values[] = $obj->getVideoId();
      }

      $this->setDefault('motsclevideo_list', $values);
    }

    if (isset($this->widgetSchema['motscleserie_list']))
    {
      $values = array();
      foreach ($this->object->getMotscleseries() as $obj)
      {
        $values[] = $obj->getSaisonId();
      }

      $this->setDefault('motscleserie_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveMotsclevideoList($con);
    $this->saveMotscleserieList($con);
  }

  public function saveMotsclevideoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['motsclevideo_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(MotsclevideoPeer::MOTSCLE_ID, $this->object->getPrimaryKey());
    MotsclevideoPeer::doDelete($c, $con);

    $values = $this->getValue('motsclevideo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Motsclevideo();
        $obj->setMotscleId($this->object->getPrimaryKey());
        $obj->setVideoId($value);
        $obj->save();
      }
    }
  }

  public function saveMotscleserieList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['motscleserie_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(MotscleseriePeer::MOTSCLE_ID, $this->object->getPrimaryKey());
    MotscleseriePeer::doDelete($c, $con);

    $values = $this->getValue('motscleserie_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Motscleserie();
        $obj->setMotscleId($this->object->getPrimaryKey());
        $obj->setSaisonId($value);
        $obj->save();
      }
    }
  }

}
