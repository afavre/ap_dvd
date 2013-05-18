<?php

/**
 * Saison form base class.
 *
 * @method Saison getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSaisonForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'serie_id'            => new sfWidgetFormPropelChoice(array('model' => 'Serie', 'add_empty' => false)),
      'numero'              => new sfWidgetFormInputText(),
      'realisateur_id'      => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => false)),
      'titre'               => new sfWidgetFormInputText(),
      'sous_titre'          => new sfWidgetFormInputText(),
      'titre_original'      => new sfWidgetFormInputText(),
      'titre_clean'         => new sfWidgetFormInputText(),
      'nb_episode_tot'      => new sfWidgetFormInputText(),
      'nb_episode_possede'  => new sfWidgetFormInputText(),
      'version_generale_id' => new sfWidgetFormPropelChoice(array('model' => 'Version', 'add_empty' => true)),
      'bande_annonce'       => new sfWidgetFormInputText(),
      'resume'              => new sfWidgetFormTextarea(),
      'image'               => new sfWidgetFormInputText(),
      'annee_diffusion'     => new sfWidgetFormInputText(),
      'is_public'           => new sfWidgetFormInputCheckbox(),
      'nb_visite'           => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'acteurserie_list'    => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Personne')),
      'motscleserie_list'   => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Motscle')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'Saison', 'column' => 'id', 'required' => false)),
      'serie_id'            => new sfValidatorPropelChoice(array('model' => 'Serie', 'column' => 'id')),
      'numero'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'realisateur_id'      => new sfValidatorPropelChoice(array('model' => 'Personne', 'column' => 'id')),
      'titre'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sous_titre'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'titre_original'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'titre_clean'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'nb_episode_tot'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'nb_episode_possede'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'version_generale_id' => new sfValidatorPropelChoice(array('model' => 'Version', 'column' => 'id', 'required' => false)),
      'bande_annonce'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'resume'              => new sfValidatorString(array('required' => false)),
      'image'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'annee_diffusion'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_public'           => new sfValidatorBoolean(),
      'nb_visite'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'acteurserie_list'    => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Personne', 'required' => false)),
      'motscleserie_list'   => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Motscle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('saison[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Saison';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['acteurserie_list']))
    {
      $values = array();
      foreach ($this->object->getActeurseries() as $obj)
      {
        $values[] = $obj->getActeurId();
      }

      $this->setDefault('acteurserie_list', $values);
    }

    if (isset($this->widgetSchema['motscleserie_list']))
    {
      $values = array();
      foreach ($this->object->getMotscleseries() as $obj)
      {
        $values[] = $obj->getMotscleId();
      }

      $this->setDefault('motscleserie_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveActeurserieList($con);
    $this->saveMotscleserieList($con);
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
    $c->add(ActeurseriePeer::SAISON_ID, $this->object->getPrimaryKey());
    ActeurseriePeer::doDelete($c, $con);

    $values = $this->getValue('acteurserie_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Acteurserie();
        $obj->setSaisonId($this->object->getPrimaryKey());
        $obj->setActeurId($value);
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
    $c->add(MotscleseriePeer::SAISON_ID, $this->object->getPrimaryKey());
    MotscleseriePeer::doDelete($c, $con);

    $values = $this->getValue('motscleserie_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Motscleserie();
        $obj->setSaisonId($this->object->getPrimaryKey());
        $obj->setMotscleId($value);
        $obj->save();
      }
    }
  }

}
