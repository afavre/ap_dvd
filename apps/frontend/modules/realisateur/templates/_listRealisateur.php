<?php foreach ($realisateurs as $i => $realisateur){ ?>
<?php
    if($realisateur->getImage()!=""){
        $image='realisateurs/'.$realisateur->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
<a href="<?php echo url_for('realisateur/show?id='.$realisateur->getId()) ?>">
    <table cellpadding="1" cellspacing="1" border="0" class="sitetable" width="100%">

        <tr>
            <td colspan="3" class="lien" valign="top" style="padding-left:5px;">
                <b><?php echo $realisateur->getPrenom().' '.$realisateur->getNom(); ?></b>
            </td>
        </tr>
        <tr>
            <td valign="top" height="100%" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
                  <img src="/uploads/<?php echo $image; ?>" alt="<?php echo $realisateur->getNom(); ?>" height="100">
            </td>
            <td colspan="2" style="text-align: right; vertical-align: top; padding: 2px;">
            </td>
        </tr>
    </table>
</a>
<?php } ?>
