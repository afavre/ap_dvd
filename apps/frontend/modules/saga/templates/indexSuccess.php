<h1>Sagas List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Titre</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Sagas as $Saga): ?>
    <tr>
      <td><a href="<?php echo url_for('saga/show?id='.$Saga->getId()) ?>"><?php echo $Saga->getId() ?></a></td>
      <td><?php echo $Saga->getTitre() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('saga/new') ?>">New</a>
