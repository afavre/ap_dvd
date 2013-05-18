<?php foreach ($sagas as $i => $saga){ ?>
<?php
    if($saga->getImage()!=""){
        $image='films/'.$saga->getImage();
    }else{
        $image='image_vide.jpeg';
    }
?>
<a href="<?php echo url_for('saga/show?id='.$saga->getId()) ?>">
    <table cellpadding="1" cellspacing="1" border="0" class="sitetable" width="100%">

        <tr>
            <td colspan="2" class="lien" valign="top" style="padding-left:5px;">
                <h3><?php echo $saga->getTitre() ?></h3>
            </td>
            <td align="right">
              <b><span class="qualite"> <?php if(sizeof($saga->getFilms())==3){ echo 'Trilogie'; }else{ echo 'Saga'; } ?></span></b>
            </td>
        </tr>
        <tr>
        <tr>
            <td valign="top" height="100%" ROWSPAN="2" style="padding-right:5px;padding-left:5px;padding-bottom:5px;">
                <img src="/uploads/<?php echo $image; ?>" alt="<?php echo $saga->getTitre(); ?>" height="100">
            </td>
            <td COLSPAN=2>
                <p>
                    <font face="Arial"><?php echo $saga->getExtraitResume(); if(strlen($saga->getResume())>160){ echo"..."; } ?></font>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="bottom" style="padding-bottom:5px;">
                <?php foreach($saga->getActeurs() as $i => $acteur){ ?><?php if($acteur->getImage()!=""){ $imageA='acteurs/'.$acteur->getImage(); }else{ $imageA='image_vide.jpeg'; } ?><img style="padding-right:3px;" src="/uploads/<?php echo $imageA; ?>" width="30"/><?php } ?>
            </td>

            <td colspan="2" valign="bottom" align="right">

            </td>
        </tr>
    </table>
</a>
  <?php } ?>
