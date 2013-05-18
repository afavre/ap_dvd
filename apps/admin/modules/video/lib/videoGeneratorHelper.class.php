<?php

/**
 * video module helper.
 *
 * @package    dvdtheque
 * @subpackage video
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class videoGeneratorHelper extends BaseVideoGeneratorHelper
{
  public function linkToNew($params)
  {
    return '<li class="sf_admin_action_new">'.link_to(__($params['label'], array(), 'sf_admin'), '@'.$this->getUrlForAction('new').'?type='.$params['type']).'</li>';
  }
  /*
  public function linkToEdit($object, $params)
  {
    return '<span class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('edit'), $object).'</span>';
  }
  */
  
  public function linkToEdit($object, $params)
  {
    return '<li class="sf_admin_action_edit"><a href="'.url_for('video/edit?id='.$object->getId().'&type='.$params['type']).'" >'.__($params['label'], array(), 'sf_admin').'</a></span>';
  }

  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }
 
    return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'), url_for('video/delete?id='.$object->getId().'&type='.$params['type']), array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</span>';
  }

  
  public function getUrlForAction($action)
  {
    return 'list' == $action ? 'video' : 'video_'.$action;
  }
  
}
