<h1>Utilisateurs List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Nom</th>
      <th>Prenom</th>
      <th>Image</th>
      <th>Login</th>
      <th>Pass</th>
      <th>Date naissance</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Utilisateurs as $Utilisateur): ?>
    <tr>
      <td><a href="<?php echo url_for('utilisateur/show?id='.$Utilisateur->getId()) ?>"><?php echo $Utilisateur->getId() ?></a></td>
      <td><?php echo $Utilisateur->getNom() ?></td>
      <td><?php echo $Utilisateur->getPrenom() ?></td>
      <td><?php echo $Utilisateur->getImage() ?></td>
      <td><?php echo $Utilisateur->getLogin() ?></td>
      <td><?php echo $Utilisateur->getPass() ?></td>
      <td><?php echo $Utilisateur->getDateNaissance() ?></td>
      <td><?php echo $Utilisateur->getCreatedAt() ?></td>
      <td><?php echo $Utilisateur->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('utilisateur/new') ?>">New</a>
