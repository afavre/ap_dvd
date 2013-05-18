<?php
class AdminVideoForm extends VideoForm
{
  public function configure()
  {
    parent::configure();
	
	if((isset($_REQUEST['type']) && !$_REQUEST['type']) || !isset($_REQUEST['type'])){
		if($this->getObject()->getType()){
			$type=$this->getObject()->getType();
		}else{
			$type='film';
		}
	}else{
		$type = $_REQUEST['type'];
	}
		
		$this->widgetSchema['realisateur_id']=new sfWidgetFormPropelChoicePlus(array(
		  'multiple' => false,
		  'model' => 'Personne',
		  'template'  => '%input%<div><a class="iframe" href="" onclick="$(this).attr(\'href\',$(\'#liennewpersonne\').html());" >Nouveau Realisateur</a></div>',
		));
		$this->widgetSchema['realisateur_id']->setOption('order_by',array('Nom','ASC'));
		$this->widgetSchema['version_id']=new sfWidgetFormPropelChoicePlus(array(
		  'multiple' => false,
		  'model' => 'version',
		  'template'  => '%input%<div><a class="iframe1100_400" href="" onclick="$(this).attr(\'href\',$(\'#liennewversion\').html());" >Nouvelle Version</a></div>',
		));
		$this->widgetSchema['qualite_id']=new sfWidgetFormPropelChoicePlus(array(
		  'multiple' => false,
		  'model' => 'qualite',
		  'template'  => '%input%<div><a class="iframe1100_500" href="" onclick="$(this).attr(\'href\',$(\'#liennewqualite\').html());" >Nouvelle Qualite</a></div>',
		));
		
		$this->widgetSchema['version_id']->setOption('order_by',array('Nom','ASC'));
		$this->widgetSchema['qualite_id']->setOption('order_by',array('Id','ASC'));
		
		$this->widgetSchema['videoproprietaire_list']=new sfWidgetFormPropelChoicePlus(array(
		  'multiple' => true,
		  'label' => 'Propri&eacute;taire(s)',
		  'model' => 'sfGuardUser',
		  'template'  => '%input%<div><a class="iframe" href="" onclick="$(this).attr(\'href\',$(\'#liennewproprietaire\').html());" >Nouveau Proprietaire (Administrateur)</a></div>',
		));
		
		$this->widgetSchema['videoproprietaire_list']->setOption('order_by',array('Username','ASC'));
		$this->widgetSchema['videoproprietaire_list']->setAttribute('class','multiselect');
		
		if(isset($_REQUEST['c'])){
			$this->widgetSchema['bande_annonce'] = new sfWidgetFormInputTextPlus(array(
				  'template'  => '<span id="input_ba">%input%</span><br/>
						<div class="clear">&nbsp;</div>
						<div id="list_bande_annonce">
						</div>
						<div class="clear">&nbsp;</div>
						<script>
							afficheList_bande_annonce();
							changeTextBA($("#input_ba").find("input"));
						</script>',
			));
			$this->widgetSchema['bande_annonce']->setAttribute('size','70');
			$this->widgetSchema['bande_annonce']->setAttribute('onKeyUp','changeTextBA(this);return false;');
		}
		
   if($type=="film"){
		
		if(isset($_REQUEST['c']) && (sizeof($this->getObject()->getActeurs())>0 && $this->isNew())){
			$template = '
			<div class="list_photo" id="list_ajout_acteur">
				<ul>
			';
			foreach($this->getObject()->getActeurs() as $acteur){
				if($acteur->getImage()!=""){
					$imageA='personnes/'.$acteur->getImage();
				}else{
					$imageA='image_vide.jpeg';
				}
				$template .= '
				<li>
					<img class="thumb" src="/uploads/'.$imageA.'" width="50"/><br/>
					<span class="nom_prenom">
						<b>'.$acteur->getPrenom().' '.$acteur->getNom().'</b>
					</span>
				</li>
				';
			}
			$template .= '
				</ul>
			</div>
			';
			$this->widgetSchema['acteurvideo_list']=new sfWidgetFormPropelChoicePlus(array(
			  'multiple' => true,
			  'label' => 'Acteur(s)',
			  'model' => 'Personne',
			  'template'  => '<div>'.$template.'</div>',
			));
			$this->widgetSchema['acteurvideo_list']->setOption('order_by',array('Nom','ASC'));
		}
		if(isset($_REQUEST['c'])){
			if(sizeof($this->getObject()->getMotsCles())>0){
				$template = '';
				foreach($this->getObject()->getMotsCles() as $motcle){
					$template .= ' - '.$motcle->getMot().'<br/>';
				}
				$this->widgetSchema['motsclevideo_list']->setAttribute('class',''); 
				$this->widgetSchema['motsclevideo_list']->setOption('template','<div class="invisible">%input%</div><div>'.$template.'</div>');
			}else{
				unset(
					$this['motsclevideo_list']
				);
			}
			if(sizeof($this->getObject()->getCategories())>0){
				$template = '';
				foreach($this->getObject()->getCategories() as $categorie){
					$template .= ' - '.$categorie->getNom().'<br/>';
				}
				$this->widgetSchema['categorievideo_list']->setAttribute('class',''); 
				$this->widgetSchema['categorievideo_list']->setOption('template','<div class="invisible">%input%</div><div>'.$template.'</div>');
			}else{
				unset(
					$this['categorievideo_list']
				);
			}
			if(sizeof($this->getObject()->getProprietaires())>0){
				$template = '';
				foreach($this->getObject()->getProprietaires() as $proprio){
					$template .= ' - '.$proprio->getUsername().'<br/>';
				}
				$this->widgetSchema['videoproprietaire_list']->setAttribute('class',''); 
				$this->widgetSchema['videoproprietaire_list']->setOption('template','<div class="invisible">%input%</div><div>'.$template.'</div>');
			}else{
				unset(
					$this['videoproprietaire_list']
				);
			}
		}
	}else if($type=="spectacle"){
		$this->widgetSchema['bande_annonce']->setOption('label','Extrait');
		$this->widgetSchema['titre']->setAttribute('onKeyUp','verifExisteFilm(this);return false;');
		$this->widgetSchema['realisateur_id']->setOption('label','Auteur');
		if(isset($_REQUEST['c'])){
			unset(
				$this['motsclevideo_list']
			);
		}
	}else if($type=="episode"){
		$this->widgetSchema['saison_id'] = new sfWidgetFormPropelChoice(array('model' => 'Saison', 'add_empty' => true));
		$c = new Criteria();
		$c->addJoin(SaisonPeer::SERIE_ID, SeriePeer::ID, Criteria::LEFT_JOIN);
		$subSelect = "saison.nb_episode_tot>saison.nb_episode_possede ";
		$c->add(SaisonPeer::ID, $subSelect, Criteria::CUSTOM);
		$c->addAscendingOrderByColumn(SeriePeer::TITRE);
		$c->addAscendingOrderByColumn(SaisonPeer::NUMERO);
		$this->widgetSchema['saison_id']->setOption('criteria',$c);
		$this->widgetSchema['saison_id']->setAttribute('onChange','RealSaison(this);return false;');
			echo $this->widgetSchema['saison_id']->getAttribute('value');
		for($i=1;$i<=25;$i++){
			$numero[$i]=$i;
		}
		$this->widgetSchema['numero']=new sfWidgetFormSelect(array(
		  'choices' => $numero,
		));
   }
   
	if(isset($_REQUEST['c']) && ($this->getObject()->getImage() && $this->isNew())){
	
		$this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
			'label'     => 'Image',
			'file_src'  => '/uploads/videos/temp/'.$this->getObject()->getImage(),
			'is_image'  => true,
			'template'     => '
				<div id="vue_img">
					<div id="vue_img_loader">
						<div id="img_choix">
							%file%
						</div>
						<div class="clear">&nbsp;</div>
					</div>
					<div class="clear">&nbsp;</div>
				</div>
				<div id="galerie">
				</div>
				<div class="clear">&nbsp;</div>
				<input type="hidden" name="imgurl" value="'.$this->getObject()->getImage().'" />
				<script>
					afficheGalerie();
				</script>
			',
		),
		array(
		  'width'     => '240',
		  'class'     => 'thumb',
		));
	}else{
		$this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
		  'label'        => 'Image',
		  'file_src'     => '/uploads/videos/'.$this->getObject()->getImage(),
		  'is_image'     => true,
		  'edit_mode'    => !$this->isNew(),
		  'delete_label' => "Supprimer l'image actuelle",
		  'template'     => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
		),
		array(
		  'class'     => 'thumb',
		));
		$this->validatorSchema['image_delete'] = new sfValidatorPass();
	}
	$this->widgetSchema['titre']->addOption('order_by','titre');

  }
 
  // ...
}