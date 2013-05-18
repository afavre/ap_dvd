

<?php

$first=true;
foreach($Spectacle->getProprietaires() as $admin){
	if(!$first){
		echo '<br/>';
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
?>
