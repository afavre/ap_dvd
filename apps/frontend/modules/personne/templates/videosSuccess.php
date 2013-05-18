
<?php use_stylesheet('film.css') ?>
<?php use_helper('Text') ?>

<?php
    if($personne->getImage()!=""){
        $imagea='personnes/'.$personne->getImage();
    }else{
        $imagea='image_vide.jpeg';
    }
?>

<h1>
    <table width="100%">
        <tr>
            <td>
				<a href="<?php echo url_for('personne/show?id='.$personne->getId()) ?>">
					<img src="/uploads/<?php echo $imagea; ?>" alt="<?php echo $personne->getPrenom(). ' '.$personne->getNom(); ?>" height="70">
				</a>
			</td>
            <td align="center">
				<?php
					if($v=='realisateur'){
						echo 'Tous les Films r&eacute;alis&eacute par </br>'.$personne->getPrenom(). ' '.$personne->getNom();
					}else if($v=='acteur'){
						echo 'Tous les Films jou&eacute; par </br>'.$personne->getPrenom(). ' '.$personne->getNom();
					}else if($v=='realisateur_serie'){
						echo 'Tous les Series r&eacute;alis&eacute par </br>'.$personne->getPrenom(). ' '.$personne->getNom();
					}else if($v=='acteur_serie'){
						echo 'Tous les Series jou&eacute; par </br>'.$personne->getPrenom(). ' '.$personne->getNom();
					}else if($v=='auteur'){
						echo 'Tous les Sp&eacute;ctacle de </br>'.$personne->getPrenom(). ' '.$personne->getNom();
					}
				?>
            </td>
        </tr>
    </table>
</h1>

<div id="list">
	<?php 
	if($v=='realisateur_serie' || $v=='acteur_serie'){
		include_partial('serie/listSaisonSerie', array('series' => $video_list));
	}else{
		include_partial('video/listVideo', array('videos' => $video_list));
	}
	?>
</div>