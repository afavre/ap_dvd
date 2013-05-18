<?php
if($film->getImage()!=""){
    $image='films/'.$film->getImage();
}else{
    $image='image_vide.jpeg';
}
?>
<img width="50" src="/uploads/<?php echo $image; ?>" />
