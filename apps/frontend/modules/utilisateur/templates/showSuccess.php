<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $Utilisateur->getId() ?></td>
    </tr>
    <tr>
      <th>Nom:</th>
      <td><?php echo $Utilisateur->getNom() ?></td>
    </tr>
    <tr>
      <th>Prenom:</th>
      <td><?php echo $Utilisateur->getPrenom() ?></td>
    </tr>
    <tr>
      <th>Image:</th>
      <td><?php echo $Utilisateur->getImage() ?></td>
    </tr>
    <tr>
      <th>Login:</th>
      <td><?php echo $Utilisateur->getLogin() ?></td>
    </tr>
    <tr>
      <th>Pass:</th>
      <td><?php echo $Utilisateur->getPass() ?></td>
    </tr>
    <tr>
      <th>Date naissance:</th>
      <td><?php echo $Utilisateur->getDateNaissance() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $Utilisateur->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $Utilisateur->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('utilisateur/edit?id='.$Utilisateur->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('utilisateur/index') ?>">List</a>
