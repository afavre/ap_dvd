<?php

/**
 * Serie form base class.
 *
 * @method Serie getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSerieForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'realisateur_id'         => new sfWidgetFormPropelChoice(array('model' => 'Personne', 'add_empty' => false)),
      'titre'                  => new sfWidgetFormInputText(),
      'sous_titre'             => new sfWidgetFormInputText(),
      'titre_original'         => new sfWidgetFormInputText(),
      'titre_clean'            => new sfWidgetFormInputText(),
      'bande_annonce'          => new sfWidgetFormInputText(),
      'image'                  => new sfWidgetFormInputText(),
      'resume'                 => new sfWidgetFormTextarea(),
      'annee_diffusion'        => new sfWidgetFormInputText(),
      'format_duree'           => new sfWidgetFormInputText(),
      'is_public'              => new sfWidgetFormInputCheckbox(),
      'nb_visite'              => new sfWidgetFormInputText(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'serieproprietaire_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
      'categorieserie_list'    => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Categorie')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorPropelChoice(array('model' => 'Serie', 'column' => 'id', 'required' => false)),
      'realisateur_id'         => new sfValidatorPropelChoice(array('model' => 'Personne', 'column' => 'id')),
      'titre'                  => new sfValidatorString(array('max_length' => 255)),
      'sous_titre'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'titre_original'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'titre_clean'            => new sfValidatorString(array('max_length' => 255)),
      'bande_annonce'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'image'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'resume'                 => new sfValidatorString(array('required' => false)),
      'annee_diffusion'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'format_duree'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'is_public'              => new sfValidatorBoolean(),
      'nb_visite'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'created_at'             => new sfValidatorDateTime(array('required' => false)),
      'updated_at'             => new sfValidatorDateTime(array('required' => false)),
      'serieproprietaire_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
      'categorieserie_list'    => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Categorie', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('serie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Serie';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['serieproprietaire_list']))
    {
      $values = array();
      foreach ($this->object->getSerieproprietaires() as $obj)
      {
        $values[] = $obj->getUtilisateurId();
      }

      $this->setDefault('serieproprietaire_list', $values);
    }

    if (isset($this->widgetSchema['categorieserie_list']))
    {
      $values = array();
      foreach ($this->object->getCategorieseries() as $obj)
      {
        $values[] = $obj->getCategorieId();
      }

      $this->setDefault('categorieserie_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveSerieproprietaireList($con);
    $this->saveCategorieserieList($con);
  }

  public function saveSerieproprietaireList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['serieproprietaire_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(SerieproprietairePeer::SERIE_ID, $this->object->getPrimaryKey());
    SerieproprietairePeer::doDelete($c, $con);

    $values = $this->getValue('serieproprietaire_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Serieproprietaire();
        $obj->setSerieId($this->object->getPrimaryKey());
        $obj->setUtilisateurId($value);
        $obj->save();
      }
    }
  }

  public function saveCategorieserieList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['categorieserie_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(CategorieseriePeer::SERIE_ID, $this->object->getPrimaryKey());
    CategorieseriePeer::doDelete($c, $con);

    $values = $this->getValue('categorieserie_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Categorieserie();
        $obj->setSerieId($this->object->getPrimaryKey());
        $obj->setCategorieId($value);
        $obj->save();
      }
    }
  }

}
