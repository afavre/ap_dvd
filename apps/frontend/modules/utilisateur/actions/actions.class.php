<?php

/**
 * utilisateur actions.
 *
 * @package    dvdtheque
 * @subpackage utilisateur
 * @author     Your name here
 */
class utilisateurActions extends sfActions
{




  public function preExecute()
  {
		UtilisateurPeer::preAll($this);
  }
  




  public function executeIndex(sfWebRequest $request)
  {
    $this->Utilisateurs = UtilisateurPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->Utilisateur = UtilisateurPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->Utilisateur);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new UtilisateurForm();
	$this->setLayout(false);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

	echo '<script>
			  parent.location = parent.location;
			</script>';
    $this->form = new UtilisateurForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
	
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($Utilisateur = UtilisateurPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Utilisateur does not exist (%s).', $request->getParameter('id')));
    $this->form = new UtilisateurForm($Utilisateur);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Utilisateur = UtilisateurPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Utilisateur does not exist (%s).', $request->getParameter('id')));
    $this->form = new UtilisateurForm($Utilisateur);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Utilisateur = UtilisateurPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Utilisateur does not exist (%s).', $request->getParameter('id')));
    $Utilisateur->delete();

    $this->redirect('utilisateur/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Utilisateur = $form->save();

      $this->redirect('utilisateur/edit?id='.$Utilisateur->getId());
    }
  }
  
  public function executeConnection(sfWebRequest $request)
  {
		if ($this->hasRequestParameter("login")){
			$c = new Criteria();
			$c2 = new Criteria();
			$login = $this->getRequestParameter('login');
			// sauvegarde une variable en session
			$c->add(UtilisateurPeer::LOGIN,$this->getRequestParameter("login"));
			$c->add(UtilisateurPeer::PASS,$this->getRequestParameter("pass"));
			$user=UtilisateurPeer::doSelect($c);
			$c2->add(sfGuardUserPeer::USERNAME,$this->getRequestParameter("login"));
			$admin=sfGuardUserPeer::doSelect($c2);
			if($user){
				$this->getUser()->setAttribute('login', $user[0]);
			}else if($admin){
				if($admin[0]->checkPassword($this->getRequestParameter("pass"))){
					$this->getUser()->setAttribute('login', $admin[0]);
					$this->getUser()->setAttribute('admin', true);
					$this->getUser()->setAttribute('proprio', $admin[0]);
				}else{
					$this->getUser()->setAttribute('incorr', true);
				}
			}else{
				$this->getUser()->setAttribute('incorr', true);
			}
		}elseif($this->hasRequestParameter("deco")){
			// supprime une variable de la session
			$this->getUser()->getAttributeHolder()->remove('login');
		}
		
		$this->redirect($_SERVER['HTTP_REFERER']);
  }
  
    public function executeDeconnection(sfWebRequest $request)
  {
		// supprime une variable de la session
		$this->getUser()->getAttributeHolder()->remove('login');
		$this->getUser()->getAttributeHolder()->remove('admin');
		
		$this->redirect($_SERVER['HTTP_REFERER']);
  }
}
