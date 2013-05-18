<?php
if($Spectacle->getImage()!=""){
    $image='spectacles/'.$Spectacle->getImage();
}else{
    $image='image_vide.jpeg';
}
?>
<img width="50" src="/uploads/<?php echo $image; ?>" />
