<h1>Saisons List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Serie</th>
      <th>Numero</th>
      <th>Realisateur</th>
      <th>Titre</th>
      <th>Sous titre</th>
      <th>Titre original</th>
      <th>Titre clean</th>
      <th>Nb episode tot</th>
      <th>Version generale</th>
      <th>Bande annonce</th>
      <th>Resume</th>
      <th>Image</th>
      <th>Annee diffusion</th>
      <th>Is public</th>
      <th>Nb visite</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Saisons as $Saison): ?>
    <tr>
      <td><a href="<?php echo url_for('saison/show?id='.$Saison->getId()) ?>"><?php echo $Saison->getId() ?></a></td>
      <td><?php echo $Saison->getSerieId() ?></td>
      <td><?php echo $Saison->getNumero() ?></td>
      <td><?php echo $Saison->getRealisateurId() ?></td>
      <td><?php echo $Saison->getTitre() ?></td>
      <td><?php echo $Saison->getSousTitre() ?></td>
      <td><?php echo $Saison->getTitreOriginal() ?></td>
      <td><?php echo $Saison->getTitreClean() ?></td>
      <td><?php echo $Saison->getNbEpisodeTot() ?></td>
      <td><?php echo $Saison->getVersionGeneraleId() ?></td>
      <td><?php echo $Saison->getBandeAnnonce() ?></td>
      <td><?php echo $Saison->getResume() ?></td>
      <td><?php echo $Saison->getImage() ?></td>
      <td><?php echo $Saison->getAnneeDiffusion() ?></td>
      <td><?php echo $Saison->getIsPublic() ?></td>
      <td><?php echo $Saison->getNbVisite() ?></td>
      <td><?php echo $Saison->getCreatedAt() ?></td>
      <td><?php echo $Saison->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('saison/new') ?>">New</a>
