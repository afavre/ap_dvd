
<div>
  <p>
	<form method="post" action="actdublin" enctype="multipart/form-data" target="uploadFrame" onsubmit="verifUpload();">
		<label>Prenom  <input type="text" name="nom"/></label><br />
		<input type="hidden" id="keyFile" name="APC_UPLOAD_PROGRESS" value="<?php echo uniqid(); ?>" />
		<input type="file" name="fichier" /><br />
		<input type="submit" name="Envoyer" /><br />
	</form>
  </p>
</div>
<iframe id="uploadFrame" name="uploadFrame" src="#" style="display:none"></iframe>

<div>
  <p>
    <strong>Nom du fichier</strong> : <span id="fileName"><em>Aucun fichier chargé</em></span><br />
    <strong>Progression</strong> : <span id="progress"><em>Aucun fichier chargé</em></span>
  </p>
  <strong><a href="/dublin/Photo_Dublin_Aurel.zip"/>Photos Aurel</a></strong>
</div>
