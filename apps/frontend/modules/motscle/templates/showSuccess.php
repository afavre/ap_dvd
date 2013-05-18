<?php slot('title') ?>
  <?php echo $motscle->getMot(); ?>
<?php end_slot(); ?>

<?php use_stylesheet('job.css') ?>
<?php use_helper('Text') ?>

<div class="post">
    <h1><?php echo $motscle->getMot() ?></h1>

    <div id="filmographie">
        <?php if(sizeof($motscle->getFilms())!=0){ ?>
                <table>
                    <tr>
					
                        
					
                     <?php foreach($motscle->getFilms() as $i => $film){ 
                        if($film->getImage()!=""){
							$imageF='films/'.$film->getImage();
						}else{
							$imageF='image_vide.jpeg';
						}
						?>
                        <td valign="top" width="70" class="center">
                            <a href="<?php echo url_for('film/show?id='.$film->getId()) ?>" width="100%">
                                 <img src="/uploads/<?php echo $imageF; ?>" width="50"/><br/>
                                 <b><?php echo $film->getTitre(); ?></b>
                            </a>
                        </td>
                     <?php } ?>
                    
                    </tr>
                </table>
        <?php }else{ ?>
                <div style="margin-left:10px;">Aucun</div>
        <?php } ?>
    </div>


</div>

