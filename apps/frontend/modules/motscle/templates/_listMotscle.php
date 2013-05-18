
<?php foreach ($motscles as $i => $motscle){ ?>

<a href="<?php echo url_for('motscle/show?id='.$motscle->getId()) ?>">
    <table cellpadding="1" cellspacing="1" border="0" class="sitetable" width="100%">

        <tr>
            <td colspan="3" class="lien" valign="top" style="padding-left:5px;">
                <h4><?php echo $motscle->getMot() ?></h4>
            </td>
           
        </tr>
       
    </table>
</a>
<?php } ?>

