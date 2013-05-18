<?php
class AdminUtilisateurForm extends UtilisateurForm
{
  public function configure()
  {
    parent::configure();

    $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Image',
      'file_src'  => '/uploads/utilisateurs/'.$this->getObject()->getImage(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
    ));

    $this->validatorSchema['image_delete'] = new sfValidatorPass();
	
    $this->widgetSchema['pass'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['pass']->setOption('required', false);
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['pass'];

    $this->widgetSchema->moveField('password_again', 'after', 'pass');

    $this->mergePostValidator(new sfValidatorSchemaCompare('pass', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));

	
  }

  // ...
}