
<?php use_stylesheet('film.css') ?>
<?php use_helper('Text') ?>

<?php
    if($film->getImage()!=""){
        $imagef=$film->getImage();
    }else{
        $imagef='image_vide.jpeg';
    }
?>

<h2>
    <table width="100%">
        <tr>
            <td>
                <img src="/uploads/films/<?php echo $imagef; ?>" alt="<?php echo $film->getTitre(); ?>" height="70">
            </td>
            <td align="center">
                Tous les Acteurs de <?php echo $film->getTitre(); ?>
            </td>
        </tr>
    </table>
</h2>

<div id="list">
<?php foreach ($acteur_list as $i => $acteur){ ?>

<?php
    if($acteur->getImage()!=""){
        $image=$acteur->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
<a href="<?php echo url_for('acteur/show?id='.$acteur->getId()) ?>">
    <table cellpadding="1" cellspacing="1" border="0" class="sitetable" width="100%">

        <tr>
            <td colspan="3" class="lien" valign="top" style="padding-left:5px;">
                <h3><?php echo $acteur->getPrenom().' '.$acteur->getNom(); ?></h3>
            </td>
        </tr>
        <tr>
            <td valign="top" height="100%" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
                 <img src="/uploads/acteurs/<?php echo $image; ?>" alt="<?php echo $acteur->getNom(); ?>" height="100">
            </td>
            <td colspan="2" style="text-align: right; vertical-align: top; padding: 2px;">
            </td>
        </tr>
    </table>
</a>
<?php } ?>
</div>