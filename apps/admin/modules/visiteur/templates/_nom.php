<?php
if($SauvegardeVisiteur->getNom()=='inconnu' || $SauvegardeVisiteur->getNom()==''){
	echo '<span style="color:gray"><i>inconnu</i></span>';
}else{
	echo '<span style="color:black"><b>'.$SauvegardeVisiteur->getNom().'</b></span>';
}
?>
