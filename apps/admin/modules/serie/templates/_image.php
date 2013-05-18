<?php
if($serie->getImage()!=""){
    $image='series/'.$serie->getImage();
}else{
    $image='image_vide.jpeg';
}
?>
<img width="50" src="/uploads/<?php echo $image; ?>" />
