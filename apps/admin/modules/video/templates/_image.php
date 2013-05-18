<?php
if($video->getType()=="episode"){
	if($video->getSaison()->getSerie()->getImage()!=""){
		$image='series/'.$video->getSaison()->getSerie()->getImage();
	}else{
		$image='image_vide.jpeg';
	}
}else{
	if($video->getImage()!=""){
		$image='videos/'.$video->getImage();
	}else{
		$image='image_vide.jpeg';
	}
}
?>
<img width="50" src="/uploads/<?php echo $image; ?>" />
