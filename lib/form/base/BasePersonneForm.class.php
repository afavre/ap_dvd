<?php

/**
 * Personne form base class.
 *
 * @method Personne getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePersonneForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'nom'              => new sfWidgetFormInputText(),
      'prenom'           => new sfWidgetFormInputText(),
      'nom_prenom_clean' => new sfWidgetFormInputText(),
      'image'            => new sfWidgetFormInputText(),
      'date_naissance'   => new sfWidgetFormDate(),
      'date_deces'       => new sfWidgetFormDate(),
      'nb_visite'        => new sfWidgetFormInputText(),
      'nationalite_id'   => new sfWidgetFormPropelChoice(array('model' => 'Nationalite', 'add_empty' => true)),
      'acteurserie_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Saison')),
      'acteurvideo_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Video')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'Personne', 'column' => 'id', 'required' => false)),
      'nom'              => new sfValidatorString(array('max_length' => 255)),
      'prenom'           => new sfValidatorString(array('max_length' => 255)),
      'nom_prenom_clean' => new sfValidatorString(array('max_length' => 255)),
      'image'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_naissance'   => new sfValidatorDate(array('required' => false)),
      'date_deces'       => new sfValidatorDate(array('required' => false)),
      'nb_visite'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'nationalite_id'   => new sfValidatorPropelChoice(array('model' => 'Nationalite', 'column' => 'id', 'required' => false)),
      'acteurserie_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Saison', 'required' => false)),
      'acteurvideo_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Video', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Personne', 'column' => array('nom_prenom_clean')))
    );

    $this->widgetSchema->setNameFormat('personne[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Personne';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['acteurserie_list']))
    {
      $values = array();
      foreach ($this->object->getActeurseries() as $obj)
      {
        $values[] = $obj->getSaisonId();
      }

      $this->setDefault('acteurserie_list', $values);
    }

    if (isset($this->widgetSchema['acteurvideo_list']))
    {
      $values = array();
      foreach ($this->object->getActeurvideos() as $obj)
      {
        $values[] = $obj->getVideoId();
      }

      $this->setDefault('acteurvideo_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveActeurserieList($con);
    $this->saveActeurvideoList($con);
  }

  public function saveActeurserieList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['acteurserie_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ActeurseriePeer::ACTEUR_ID, $this->object->getPrimaryKey());
    ActeurseriePeer::doDelete($c, $con);

    $values = $this->getValue('acteurserie_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Acteurserie();
        $obj->setActeurId($this->object->getPrimaryKey());
        $obj->setSaisonId($value);
        $obj->save();
      }
    }
  }

  public function saveActeurvideoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['acteurvideo_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(ActeurvideoPeer::ACTEUR_ID, $this->object->getPrimaryKey());
    ActeurvideoPeer::doDelete($c, $con);

    $values = $this->getValue('acteurvideo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Acteurvideo();
        $obj->setActeurId($this->object->getPrimaryKey());
        $obj->setVideoId($value);
        $obj->save();
      }
    }
  }

}
