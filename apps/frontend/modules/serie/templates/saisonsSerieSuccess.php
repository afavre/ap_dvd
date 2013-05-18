
<?php use_stylesheet('film.css') ?>
<?php use_helper('Text') ?>

<?php
    if($serie->getImage()!=""){
        $imagef='series/'.$serie->getImage();
    }else{
        $imagef='image_vide.jpeg';
    }
?>

<h1>
    <table width="100%">
        <tr>
            <td>
                <img src="/uploads/<?php echo $imagef; ?>" alt="<?php echo $serie->getTitre(); ?>" height="70">
            </td>
            <td align="center">
                Toutes les Saisons de la Serie <?php echo $serie->getTitre(); ?>
            </td>
        </tr>
    </table>
</h1>

<div id="list">
	<?php include_partial('serie/listSaisonSerie', array('series' => $saison_list)) ?>
</div>