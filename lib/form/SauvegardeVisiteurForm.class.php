<?php

/**
 * SauvegardeVisiteur form.
 *
 * @package    dvdtheque
 * @subpackage form
 * @author     Your name here
 */
class SauvegardeVisiteurForm extends BaseSauvegardeVisiteurForm
{
  public function configure()
  {
       unset(
       $this['derniere_connection'], $this['proprio_id'], $this['adresse']
    );
  }
}
