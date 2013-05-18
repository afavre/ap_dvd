<?php 
if($sf_request->getParameter('type')=='film' || $sf_request->getParameter('type')==''){
	echo '<li class="sf_admin_action_new"><a href="'.url_for('video/newAuto?type=film').'">Nouveau</a></li>';
}else{
	echo $helper->linkToNew(array(  'params' =>   array(  ),  'class_suffix' => 'new',  'label' => 'Nouveau',  'type' => $sf_request->getParameter('type')));
}
?>
