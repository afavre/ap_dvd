<?php

/**
 * Categorie form base class.
 *
 * @method Categorie getObject() Returns the current form's model object
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCategorieForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'nom'                 => new sfWidgetFormInputText(),
      'nom_clean'           => new sfWidgetFormInputText(),
      'categorievideo_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Video')),
      'categorieserie_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Serie')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'Categorie', 'column' => 'id', 'required' => false)),
      'nom'                 => new sfValidatorString(array('max_length' => 255)),
      'nom_clean'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'categorievideo_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Video', 'required' => false)),
      'categorieserie_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Serie', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Categorie', 'column' => array('nom')))
    );

    $this->widgetSchema->setNameFormat('categorie[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Categorie';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['categorievideo_list']))
    {
      $values = array();
      foreach ($this->object->getCategorievideos() as $obj)
      {
        $values[] = $obj->getVideoId();
      }

      $this->setDefault('categorievideo_list', $values);
    }

    if (isset($this->widgetSchema['categorieserie_list']))
    {
      $values = array();
      foreach ($this->object->getCategorieseries() as $obj)
      {
        $values[] = $obj->getSerieId();
      }

      $this->setDefault('categorieserie_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveCategorievideoList($con);
    $this->saveCategorieserieList($con);
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
    $c->add(CategorievideoPeer::CATEGORIE_ID, $this->object->getPrimaryKey());
    CategorievideoPeer::doDelete($c, $con);

    $values = $this->getValue('categorievideo_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Categorievideo();
        $obj->setCategorieId($this->object->getPrimaryKey());
        $obj->setVideoId($value);
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
    $c->add(CategorieseriePeer::CATEGORIE_ID, $this->object->getPrimaryKey());
    CategorieseriePeer::doDelete($c, $con);

    $values = $this->getValue('categorieserie_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new Categorieserie();
        $obj->setCategorieId($this->object->getPrimaryKey());
        $obj->setSerieId($value);
        $obj->save();
      }
    }
  }

}
