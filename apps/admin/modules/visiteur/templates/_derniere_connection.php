<?php
if(date("d/m/Y",strtotime($SauvegardeVisiteur->getDerniereConnection()))==date("d/m/Y")){
	echo '<b>Aujourd\'hui</b></br>';
}else{
	echo 'le <b>'.date("d / m / Y ",strtotime($SauvegardeVisiteur->getDerniereConnection())).'</b></br>';
}
echo '&agrave; <b>'.date("H : i : s",strtotime($SauvegardeVisiteur->getDerniereConnection())).'</b>';
?>