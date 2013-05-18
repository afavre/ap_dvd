

<?php
	
if($SauvegardeVisiteur->getProprioId()==0){
	$first=true;
	foreach(sfGuardUserPeer::getProprio() as $admin){
		if(!$first){
			echo ' et ';
		}else{
			$first=false;
		}
		if($admin->getId()==1){
			$color='639b45';
		}else if($admin->getId()==2){
			$color='6b49fb';
		}
		echo '<span style="text-align:center;color:#'.$color.'"><b>'.$admin.'</b></span>';
	}
}else{
	if($SauvegardeVisiteur->getProprioId()==1){
		$color='639b45';
	}else if($SauvegardeVisiteur->getProprioId()==2){
		$color='6b49fb';
	}
    $admin = sfGuardUserPeer::retrieveByPk($SauvegardeVisiteur->getProprioId());
	echo '<span style="text-align:center;color:#'.$color.'"><b>'.$admin.'</b></span>';
}

?>
