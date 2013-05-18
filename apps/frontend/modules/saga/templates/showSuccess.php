
<?php use_stylesheet('film.css') ?>
<?php use_helper('Text') ?>

<?php
    if($saga->getImage()!=""){
        $images='videos/'.$saga->getImage();
    }else{
        $images='image_vide.jpeg';
    }
?>

<h1>
    <table width="100%">
        <tr>
            <td>
                <img src="/uploads/<?php echo $images; ?>" alt="<?php echo $saga->getTitre(); ?>" height="70">
            </td>
            <td align="center">
                Tous les Films de la saga <?php echo $saga->getTitre(); ?>
            </td>
        </tr>
    </table>
</h1>

<div id="list">

		<?php include_partial('video/listVideo', array('videos' => $saga->getFilms())) ?>
</div>