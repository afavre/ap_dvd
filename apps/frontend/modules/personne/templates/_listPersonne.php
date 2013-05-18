<?php foreach ($personnes as $i => $personne){ ?>


<?php
    if($personne->getImage()!=""){
        $image='personnes/'.$personne->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
<a href="<?php echo url_for('personne/show?id='.$personne->getId()) ?>">
    <table class="bloc_info center_bloc" cellpadding="1" cellspacing="1" border="0" class="sitetable" width="95%">

        <tr>
            <td colspan="3" class="lien" valign="top" style="padding-left:5px;">
                <h4><?php echo $personne->getPrenom().' '.$personne->getNom(); ?></h4>
            </td>
        </tr>
        <tr>
            <td valign="top" height="100%" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
                  <img class="thumb" src="/uploads/<?php echo $image; ?>" alt="<?php echo $personne->getNom(); ?>" height="100">
            </td>
            <td colspan="2" style="text-align: right; vertical-align: top; padding: 2px;">
            </td>
        </tr>
    </table>
</a>
<?php } ?>