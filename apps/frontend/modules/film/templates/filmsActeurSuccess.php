
<?php use_stylesheet('film.css') ?>
<?php use_helper('Text') ?>

<?php
    if($acteur->getImage()!=""){
        $imagea='personnes/'.$acteur->getImage();
    }else{
        $imagea='image_vide.jpeg';
    }
?>

<h2>
    <table width="100%">
        <tr>
            <td>
                <img src="/uploads/<?php echo $imagea; ?>" alt="<?php echo $acteur->getPrenom(). ' '.$acteur->getNom(); ?>" height="70">
            </td>
            <td align="center">
                Tous les Films jou&eacute; par </br><?php echo $acteur->getPrenom(). ' '.$acteur->getNom(); ?>
            </td>
        </tr>
    </table>
</h2>

<div id="list">
<?php foreach ($film_list as $i => $film){ ?>

<?php
    if($film->getImage()!=""){
        $image='films/'.$film->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
<a href="<?php echo url_for('film/show?id='.$film->getId()) ?>">
    <table cellpadding="1" cellspacing="1" border="0" class="sitetable" width="100%">

        <tr>
            <td colspan="3" class="lien" valign="top" style="padding-left:5px;">
                <h3><?php echo $film->getTitre() ?></h3><?php if($film->getTitreOfficiel()!=''){ echo ' - <i><b>'.$film->getTitreOfficiel().'</b></i>'; } ?>
            </td>
            <td align="right">
                <b><span class="qualite"><?php echo $film->getQualite(); ?></span></b>
            </td>
        </tr>
        <tr>
            <td valign="top" height="100%" ROWSPAN="2" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
                <img src="/uploads/<?php echo $image; ?>" alt="<?php echo $film->getTitre(); ?>" height="100">
            </td>
            <td COLSPAN=2>
                <p>
                    <font face="Arial"><?php echo $film->getExtraitResume()."..."; ?></font>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="bottom" style="padding-bottom:5px;">
                <?php foreach($film->getActeurs() as $i => $acteur){ ?><?php if($film->getImage()!=""){ $imageA='acteurs/'.$acteur->getImage(); }else{ $imageA='image_vide.jpeg'; } ?><img style="padding-right:3px;" src="/uploads/<?php echo $imageA; ?>" width="30"/><?php } ?>
            </td>

            <td colspan="2" valign="bottom" align="right">
                <?php echo $film->getVersion(); ?>
            </td>
        </tr>
    </table>
</a>
<?php } ?>
</div>