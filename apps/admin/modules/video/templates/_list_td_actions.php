<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($video, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Modifier', 'type' => $sf_request->getParameter('type'),)) ?>
    <?php echo $helper->linkToDelete($video, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Supprimer', 'type' => $sf_request->getParameter('type'),)) ?>
  </ul>
</td>
