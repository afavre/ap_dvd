<?php
class FilmAutoForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'titre'   => new sfWidgetFormInputText(array(), array('size' => '50')),
    ));
 
  }
}
?>