<?php

/**
 * Video form base class.
 *
 * @method Video getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseVideoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'type'                   => new sfWidgetFormInputHidden(),
      'saison_id'              => new sfWidgetFormPropelChoice(array('model' => 'Saison', 'add_empty' => true)),
      'numero'                 => new sfWidgetFormInputText(),
      'saga_id'                => new sfWidgetFormPropelChoice(array('model' => 'Saga', 'add_empty' => true)),
      'realisateur_id'         => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => false)),
      'titre'                  => new sfWidgetFormInputText(),
      'sous_titre'             => new sfWidgetFormInputText(),
      'titre_original'         => new sfWidgetFormInputText(),
      'titre_clean'            => new sfWidgetFormInputText(),
      'avertissement'          => new sfWidgetFormTextarea(),
      'resume'                 => new sfWidgetFormTextarea(),
      'image'                  => new sfWidgetFormInputText(),
      'bande_annonce'          => new sfWidgetFormInputText(),
      'annee_sortie'           => new sfWidgetFormInputText(),
      'duree'                  => new sfWidgetFormInputText(),
      'qualite_id'             => new sfWidgetFormPropelChoice(array('model' => 'Qualite', 'add_empty' => false)),
      'version_id'             => new sfWidgetFormPropelChoice(array('model' => 'Version', 'add_empty' => true)),
      'nb_visite'              => new sfWidgetFormInputText(),
      'is_public'              => new sfWidgetFormInputCheckbox(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'motsclevideo_list'      => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Motscle')),
      'acteurvideo_list'       => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Personne')),
      'videoproprietaire_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'categorievideo_list'    => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Categorie')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'Video', 'column' => 'id', 'required' => false)),
      'type'                   => new sfValidatorPropelChoice(array('model' => 'Video', 'column' => 'type', 'required' => false)),
      'saison_id'              => new sfValidatorPropelChoice(array('model' => 'Saison', 'column' => 'id', 'required' => false)),
      'numero'                 => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'saga_id'                => new sfValidatorPropelChoice(array('model' => 'Saga', 'column' => 'id', 'required' => false)),
      'realisateur_id'         => new sfValidatorPropelChoice(array('model' => 'Personne', 'column' => 'id')),
      'titre'                  => new sfValidatorString(array('max_length' => 255)),
      'sous_titre'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'titre_original'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'titre_clean'            => new sfValidatorString(array('max_length' => 255)),
      'avertissement'          => new sfValidatorString(array('required' => false)),
      'resume'                 => new sfValidatorString(array('required' => false)),
      'image'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'bande_annonce'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'annee_sortie'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'duree'                  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'qualite_id'             => new sfValidatorPropelChoice(array('model' => 'Qualite', 'column' => 'id')),
      'version_id'             => new sfValidatorPropelChoice(array('model' => 'Version', 'column' => 'id', 'required' => false)),
      'nb_visite'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'is_public'              => new sfValidatorBoolean(),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'motsclevideo_list'      => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Motscle', 'required' => false)),
      'acteurvideo_list'       => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Personne', 'required' => false)),
      'videoproprietaire_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'categorievideo_list'    => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Categorie', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('video[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Video';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['motsclevideo_list']))
    {
      $values = array();
      foreach ($this->object->getMotsclevideos() as $obj)
      {
        $values[] = $obj->getMotscleId();
      }

      $this->setDefault('motsclevideo_list', $values);
    }

    if (isset($this->widgetSchema['acteurvideo_list']))
    {
      $values = array();
      foreach ($this->object->getActeurvideos() as $obj)
      {
        $values[] = $obj->getActeurId();
      }

      $this->setDefault('acteurvideo_list', $values);
    }

    if (isset($this->widgetSchema['videoproprietaire_list']))
    {
      $values = array();
      foreach ($this->object->getVideoproprietaires() as $obj)
      {
        $values[] = $obj->getUtilisateurId();
      }

      $this->setDefault('videoproprietaire_list', $values);
    }

    if (isset($this->widgetSchema['categorievideo_list']))
    {
      $values = array();
      foreach ($this->object->getCategorievideos() as $obj)
      {
        $values[] = $obj->getCategorieId();
      }

      $this->setDefault('categorievideo_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveMotsclevideoList($con);
    $this->saveActeurvideoList($con);
    $this->saveVideoproprietaireList($con);
    $this->saveCategorievideoList($con);
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
    $c->add(MotsclevideoPeer::VIDEO_ID, $this->object->getPrimaryKey());
    MotsclevideoPeer::doDelete($c, $con);

    $values = $this->getValue('motsclevideo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Motsclevideo();
        $obj->setVideoId($this->object->getPrimaryKey());
        $obj->setMotscleId($value);
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
    $c->add(ActeurvideoPeer::VIDEO_ID, $this->object->getPrimaryKey());
    ActeurvideoPeer::doDelete($c, $con);

    $values = $this->getValue('acteurvideo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Acteurvideo();
        $obj->setVideoId($this->object->getPrimaryKey());
        $obj->setActeurId($value);
        $obj->save();
      }
    }
  }

  public function saveVideoproprietaireList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['videoproprietaire_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(VideoproprietairePeer::VIDEO_ID, $this->object->getPrimaryKey());
    VideoproprietairePeer::doDelete($c, $con);

    $values = $this->getValue('videoproprietaire_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Videoproprietaire();
        $obj->setVideoId($this->object->getPrimaryKey());
        $obj->setUtilisateurId($value);
        $obj->save();
      }
    }
  }

  public function saveCategorievideoList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['categorievideo_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(CategorievideoPeer::VIDEO_ID, $this->object->getPrimaryKey());
    CategorievideoPeer::doDelete($c, $con);

    $values = $this->getValue('categorievideo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Categorievideo();
        $obj->setVideoId($this->object->getPrimaryKey());
        $obj->setCategorieId($value);
        $obj->save();
      }
    }
  }

}
