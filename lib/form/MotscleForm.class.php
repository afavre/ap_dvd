<?php

/**
 * Motscle form.
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
class MotscleForm extends BaseMotscleForm
{
  public function configure()
  {
       unset(
       $this['motscleserie_list'], $this['motsclevideo_list'], $this['motsclespectacle_list'], $this['mot_clean']
    );
  }
}
