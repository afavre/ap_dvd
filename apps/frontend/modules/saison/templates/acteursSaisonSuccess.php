
<?php use_stylesheet('film.css') ?>
<?php use_helper('Text') ?>

<?php
    if($saison->getImage()!=""){
        $imagef='saisons/'.$saison->getImage();
    }else{
        $imagef='image_vide.jpeg';
    }
?>

<h1>
    <table width="100%">
        <tr>
            <td>
                <img src="/uploads/<?php echo $imagef; ?>" alt="<?php echo $saison->getTitre(); ?>" height="70">
            </td>
            <td align="center">
                <?php echo $saison;
					if($saison->getSousTitre()){
						echo '<span id="titreFilmS"><i> - '.$saison->getSousTitre().'</i></span>';
					}
					if($saison->getTitreOriginal()){
						echo '<span id="titreFilmO"><i> ( '.$saison->getTitreOriginal().' )</i></span>';
					}
				?>
            </td>
        </tr>
    </table>
</h1>

<div id="list">
<?php foreach ($acteur_list as $i => $acteur){ ?>

<?php
    if($acteur->getImage()!=""){
        $image='personnes/'.$acteur->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
<a href="<?php echo url_for('personne/show?id='.$acteur->getId()) ?>">
    <table class="bloc_info center_bloc"  cellpadding="1" cellspacing="1" border="0" class="sitetable" width="95%">

        <tr>
            <td colspan="3" class="lien" valign="top" style="padding-left:5px;">
                <h3><?php echo $acteur->getPrenom().' '.$acteur->getNom(); ?></h3>
            </td>
        </tr>
        <tr>
            <td valign="top" height="100%" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
                 <img src="/uploads/<?php echo $image; ?>" alt="<?php echo $acteur->getNom(); ?>" height="100">
            </td>
            <td colspan="2" style="text-align: right; vertical-align: top; padding: 2px;">
            </td>
        </tr>
    </table>
</a>
<?php } ?>
</div>