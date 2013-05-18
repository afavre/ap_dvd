<?php
class AdminSaisonForm extends SaisonForm
{
  public function configure()
  {
    parent::configure();
 
    $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Image',
      'file_src'  => '/uploads/saisons/'.$this->getObject()->getImage(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
    ));
 	$this->widgetSchema['numero']->addOption('order_by','numero');
    $this->validatorSchema['image_delete'] = new sfValidatorPass();
  }
 
  // ...
}