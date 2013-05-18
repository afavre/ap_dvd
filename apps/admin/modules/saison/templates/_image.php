<?php
if($saison->getImage()!=""){
    $image='saisons/'.$saison->getImage();
}else{
    $image='image_vide.jpeg';
}
?>
<img width="50" src="/uploads/<?php echo $image; ?>" />
