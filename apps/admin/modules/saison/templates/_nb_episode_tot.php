<?php
if($saison->getnbEpisodeTot()==0){
    $tot='<span style="color:gray;"><i>en cours</i></span>';
}else{
    $tot='<span><b>'.$saison->getnbEpisodeTot().'</b></span>';
}
echo $tot;
?>
