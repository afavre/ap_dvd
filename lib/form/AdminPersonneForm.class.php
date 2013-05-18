<?php

/**
 * AdminPersonne form.
 *
 * @package    sitedvd
 * @subpackage form
 * @author     Your name here
 */

class AdminPersonneForm extends PersonneForm
{
  public function configure()
  {
    parent::configure();

    $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Image',
      'file_src'  => '/uploads/personnes/'.$this->getObject()->getImage(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
	  'delete_label' => 'supprimer l\'image en cours',
      'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
    ));
        $this->widgetSchema['nom']->addOption('order_by','nom');
    $this->validatorSchema['image_delete'] = new sfValidatorPass();
  }

}
