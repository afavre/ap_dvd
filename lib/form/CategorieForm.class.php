<?php

/**
 * Categorie form.
 *
 * @package    sitedvd
 * @subpackage form
 * @author     Your name here
 */
class CategorieForm extends BaseCategorieForm
{
  public function configure()
  {
    unset(
       $this['categorieserie_list'], $this['categorievideo_list'], $this['categoriespectacle_list'], $this['nom_clean']
	);
  }
}
