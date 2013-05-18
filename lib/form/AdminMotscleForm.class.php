<?php
class AdminMotscleForm extends MotscleForm
{
  public function configure()
  {
    parent::configure();
 
    $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Image',
      'file_src'  => '/uploads/series/'.$this->getObject()->getImage(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
    ));
 	$this->widgetSchema['titre']->addOption('order_by','titre');
    $this->validatorSchema['image_delete'] = new sfValidatorPass();
  }
 
  // ...
}