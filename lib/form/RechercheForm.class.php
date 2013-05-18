<?php
class RechercheForm extends BaseForm
{
  public function configure()
  {
    $this->widgetSchema['version']->setAttribute('class','multiselect');
	$this->widgetSchema['qualite']->setAttribute('class','multiselect');
  }
}