<?php
class TestForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'upload' => new sfWidgetFormInputSWFUpload()
    ));

    $this->setValidators(array(
      'upload' => new sfValidatorFile()
    ));
  }
}
?>